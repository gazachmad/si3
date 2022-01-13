<?php

use App\core\Controller;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

class Auth extends Controller
{
    public function index()
    {
        $payload = [
            'email'  => $this->request->email,
            'ymdhis' => Carbon::now()->format('YmdHis'),
            'random' => Str::random(),
            'iat'    => time(),
            'exp'    => 10
        ];
        
        $token = JWT::encode($payload, $_SERVER['JWT_APP_KEY'], $_SERVER['JWT_APP_SECRET']);

        return $this->response->json(['status' => true, '_token' => $token])->send();
    }
}
