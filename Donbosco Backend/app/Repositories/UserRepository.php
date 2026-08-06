<?php

namespace App\Repositories;

use App\Models\RefreshToken;
use App\Models\User;

class UserRepository
{
    protected $userModel;
    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }
    public function create(array $data)
    {
        return $this->userModel->create($data);
    }
    public function find_by_email($email)
    {
        return $this->userModel->where('email', $email)->first();
    }
    public function find_user($id): ?User
    {
        return $this->userModel->where('id', $id)->first();
    }

    public function save(User $user)
    {
        return $user->save();
    }
    public function create_refresh_token($userId, $token, $expiresAt)
    {
        return RefreshToken::create([
            'user_id' => $userId,
            'token' => hash('sha256', $token),
            'expires_at' => $expiresAt,
        ]);
    }
    public function revoke_user_tokens($userId)
    {
        RefreshToken::where('user_id', $userId)
            ->update(['is_revoked' => true]);
    }
    public function find_refresh_token($token)
    {
        return RefreshToken::where('token', hash('sha256', $token))->first();
    }
    public function revoke_token($token)
    {
        $token->update(['is_revoked' => true]);
    }
}
