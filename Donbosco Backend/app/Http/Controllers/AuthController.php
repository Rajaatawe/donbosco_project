<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthFormRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(AuthFormRequest $request)
    {
        $this->authService->register($request->validated());
        return response()->json(['message' => __('messages.register_success')], 201);
    }
    public function send_email(AuthFormRequest $request)
    {
        $result = $this->authService->send_email($request->validated()['email']);
        if ($result) {
            return response()->json(['message' => __('messages.email_sent')], 200);
        } else {
            return response()->json(['message' => __('messages.email_failed')], 404);
        }
    }
    public function verify_code(AuthFormRequest $request)
    {
        $result = $this->authService->verify_code($request->validated());
        if (!$result) {
            return response()->json(['message' => __('messages.verification_failed')], 400);
        }
        $response = [
            'message' => __('messages.verification_success'),
            'access_token' => $result['access_token'],
        ];
        $cookie = cookie(
            'refresh_token',
            $result['refresh_token'],
            1440,
            '/',
            null,
            true,
            true,
            false,
            'Strict'
        );
        return response()->json($response)->withCookie($cookie);
    }
    public function verify_for_new_password(AuthFormRequest $request)
    {
        $result = $this->authService->verify_for_new_password($request->validated());
        if (!$result) {
            return response()->json(['message' => __('messages.verification_failed')], 400);
        }
        return response()->json([
            'message' => __('messages.verification_success'),
            'reset_token' => $result['reset_token'] ?? null,
        ], 200);
    }
    public function reset_password(AuthFormRequest $request)
    {
        $result = $this->authService->reset_password($request->validated());
        if ($result === "same_old_password") {
            return response()->json(['message' => __('messages.same_old_password')], 422);
        }
        if (!$result) {
            return response()->json(['message' => __('messages.reset_failed')], 400);
        }
        return response()->json(['message' => __('messages.reset_success')], 200);
    }
    public function login(AuthFormRequest $request)
    {
        $result = $this->authService->login($request->validated());
        if ($result === 'unverified') {
            return response()->json(['message' => __('messages.unverified')], 202);
        }
        if ($result === 'banned') {
            return response()->json(['message' => __('messages.banned')], 403);
        }
        if (!$result) {
            return response()->json(['message' => __('messages.login_failed')], 401);
        }
        $cookie = cookie(
            'refresh_token',
            $result['refresh_token'],
            1440,
            '/',
            null,
            true,
            true,
            false,
            'Strict'
        );

        return response()->json([
            'message' => $result['message'],
            'access_token' => $result['access_token'],
        ])->withCookie($cookie);
    }
    public function logout()
    {
        $this->authService->logout();
        return response()->json(['message' => __('messages.logout_success')], 200);
    }
    public function refresh()
    {
        $result = $this->authService->refresh(request()->cookie('refresh_token'));
        if ($result === 'banned') {
            return response()->json(['message' => __('messages.banned')], 403);
        }
        if (!$result) {
            return response()->json(['message' => __('messages.invalid_refresh_token')], 401);
        }
        if (isset($result['refresh_token'])) {
            $cookie = cookie(
                'refresh_token',
                $result['refresh_token'],
                1440,
                '/',
                null,
                true,
                true,
                false,
                'Strict'
            );

            return response()->json([
                'access_token' => $result['access_token'],
            ])->withCookie($cookie);
        }
        return response()->json([
            'access_token' => $result['access_token'],
        ]);
    }
}
