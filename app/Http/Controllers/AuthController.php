<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credential = $request->only(['username', 'password']);

        if (!$token = $this->jwt->attempt(['username' => $credential['username'], 'password' => $credential['password']]))
        {
            return response()->json(['error' => 'Unauthorized', 'info' => $credential, 'token' => $token], 401);
        }

        $user = $this->jwt->user();
        if ($user['member_status'] == 1) {
            $this->jwt->parseToken()->invalidate()->unsetToken();
            return response()->json(['error' => 'Forbidden', 'info' => $credential, 'token' => $token], 403);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Revoke JWT token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->jwt->parseToken()->invalidate()->unsetToken();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        $token = $this->jwt->parseToken();
        $user = $this->jwt->toUser($token);

        return response()->json(['result' => $user]);
    }

    /**
     * Refresh the token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->jwt->parseToken()->refresh());
    }

    /**
     * Respond with JWT toekn
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'token_type' => 'bearer',
            'access_token' => $token,
            'expires_in' => $this->jwt->factory()->getTTL() * 60
        ]);
    }
}
