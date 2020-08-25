<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AuthenticateInterface
{
    public function register(Request $request);

    public function adminRegister(Request $request);

    public function login($credentials);

    public function adminLogin($credentials);
}