<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function register(array $request)
    {
        $user = $this->userRepository->create($request);
        $this->send_email($user->email);
    }
    public function send_email($email)
    {
        $currentLocale = app()->getLocale();
        $user = $this->userRepository->find_by_email($email);
        if (!$user) return false;

        $code = rand(100000, 999999);
        $emailBody = view('emails.verify-code', [
            'user' => $user,
            'code' => $code,
            'lang' => $currentLocale
        ])->render();

        $subject = __('emails.verification_subject', [], $currentLocale);

        Cache::put('verification_code_' . $user->id, $code, now()->addMinutes(3));
        SendEmailJob::dispatch($user->email, $emailBody, $subject);

        return true;
    }
    public function verify_code(array $request)
    {
        $user = $this->userRepository->find_by_email($request['email']);
        if (!$user) return false;
        $cachedCode = Cache::get('verification_code_' . $user->id);
        if ($cachedCode && $cachedCode == $request['code']) {
            $user->email_verified_at = now();
            $this->userRepository->save($user);
            $token = $user->createToken('AccessToken')->plainTextToken;
            $refreshToken = $this->generate_refresh_token($user);
            Cache::forget('verification_code_' . $user->id);
            return [
                'access_token' => $token,
                'refresh_token' => $refreshToken,
            ];
        }
        return false;
    }
    private function generate_refresh_token($user)
    {
        $refreshToken = Str::random(64);

        $this->userRepository->create_refresh_token(
            $user->id,
            $refreshToken,
            now()->addMonth()
        );

        return $refreshToken;
    }
    public function verify_for_new_password(array $request)
    {
        $user = $this->userRepository->find_by_email($request['email']);
        if (!$user) return false;
        $cachedCode = Cache::get('verification_code_' . $user->id);
        if ($cachedCode && $cachedCode == $request['code']) {
            $user->email_verified_at = now();
            $this->userRepository->save($user);
            Cache::forget('verification_code_' . $user->id);
            $resetToken = Str::random(64);
            Cache::put("reset_token_" . $user->id, $resetToken, now()->addMinutes(10));
            return ['reset_token' => $resetToken];
        }
        return false;
    }
    public function reset_password(array $request)
    {
        $user = $this->userRepository->find_by_email($request['email']);
        if (!$user) return false;
        $cachedResetToken = Cache::get("reset_token_" . $user->id);
        if (!$cachedResetToken || $cachedResetToken !== $request['reset_token']) {
            return false;
        }
        if (Hash::check($request['new_password'], $user->password)) {
            return "same_old_password";
        }
        $user->password = $request['new_password'];
        $this->userRepository->save($user);
        Cache::forget("reset_token_" . $user->id);
        $user->tokens()->delete();
        $this->userRepository->revoke_user_tokens($user->id);
        return true;
    }
    public function login(array $request)
    {
        $user = $this->userRepository->find_by_email($request['email']);
        if (!$user || !Hash::check($request['password'], $user->password)) {
            return false;
        }
        if (!$user->email_verified_at) {
            return 'unverified';
        }
        if ($user->status == 2) {
            return 'banned';
        }

        $token = $user->createToken('AccessToken')->plainTextToken;
        $refreshToken = $this->generate_refresh_token($user);
        return [
            'message' => __('messages.login_success'),
            'access_token' => $token,
            'refresh_token' => $refreshToken,
        ];
    }
    public function logout()
    {
        $this->userRepository->revoke_user_tokens(auth()->id());
        Auth::user()->currentAccessToken()->delete();
    }
    public function refresh($refresh_token) {

       $refreshToken = $this->userRepository->find_refresh_token($refresh_token);
        if (
            !$refreshToken ||
            $refreshToken->is_revoked ||
            $refreshToken->expires_at->isPast()
        ) {
            return false;
        }

        $user = $this->userRepository->find_user($refreshToken->user_id);
        if ($user->status==2) {
            return "banned";
        }
        $newAccessToken = $user->createToken('AccessToken')->plainTextToken;
        $response = [
            'access_token' => $newAccessToken,
        ];
        // New Refresh
        if ($refreshToken->expires_at <= now()->addDays(3)) {

            $this->userRepository->revoke_token($refreshToken);
            $newRefreshToken = $this->generate_refresh_token($user);
            $response['refresh_token'] = $newRefreshToken;
        }

        return $response;
    }
}
