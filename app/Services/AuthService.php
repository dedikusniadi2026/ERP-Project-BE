<?php 

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService {
    public function login($data) {
        if (!$token = Auth::guard('api')->attempt($data)) {
            throw new \Exception('Unauthorized');
        }
        return $token;
    }
}

?>