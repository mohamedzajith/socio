<?php

namespace App\Repositories;

use App\Interfaces\AdminInterface;
use App\Interfaces\AuthenticateInterface;
use App\Interfaces\CustomerInterface;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateRepository implements AuthenticateInterface
{
    private $adminRepository;
    private $customerRepository;

    public function __construct(AdminInterface $adminRepository, CustomerInterface $customerRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->customerRepository = $customerRepository;
    }

    public function register(Request $request)
    {
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => 'customer',
            ]);

            $this->customerRepository->store($user->id, $request);
            return $user;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function adminRegister(Request $request)
    {
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => 'admin',
            ]);

            $admin = $this->adminRepository->store($user->id, $request);
            return $user;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function login($credentials)
    {
        try {
            $user = User::where('email', '=', $credentials['email'])->where('type', 'customer')->first();
            if (!empty($user)) {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return ['status' => false, 'response' => 'Your password / email is incorrect'];
                }
                return ['status' => true, 'token' => $token];
            }
            throw new Exception('User not found', 422);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function adminLogin($credentials)
    {
        try {
            $user = User::where('email', '=', $credentials['email'])->where('type', 'admin')->first();
            if (!empty($user)) {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return ['status' => false, 'response' => 'Your password / email is incorrect'];
                }
                return ['status' => true, 'token' => $token];
            }
            throw new Exception('User not found', 422);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

}