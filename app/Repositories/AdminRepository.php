<?php

namespace App\Repositories;

use App\Interfaces\AdminInterface;
use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminRepository implements AdminInterface
{
    public function store($user_id, Request $request)
    {
        try {
            $admin = Admin::create([
                'name' => $request->name,
                'user_id' => $user_id
            ]);
            return $admin;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

}