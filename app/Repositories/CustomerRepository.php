<?php

namespace App\Repositories;

use App\Interfaces\CustomerInterface;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class CustomerRepository implements CustomerInterface
{
    public function store($user_id, Request $request)
    {
        try {
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'contact_no' => $request->contact_no,
                'user_id' => $user_id
            ]);
            return $customer;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}