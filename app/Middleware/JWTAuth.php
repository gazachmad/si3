<?php

namespace App\Middleware;

use App\Core\Middleware;
use Firebase\JWT\JWT;

class JWTAuth extends Middleware
{
    public function handle()
    {
        try {
            $bearerToken = $this->request->bearerToken();

            JWT::decode($bearerToken, $_SERVER['JWT_APP_KEY'], [$_SERVER['JWT_APP_SECRET']]);
        } catch (\Throwable $th) {
            $this->response->json(['status' => FALSE, 'message' => $th->getMessage()], HTTP_UNAUTHORIZED)->send();

            exit;
        }
    }
}
