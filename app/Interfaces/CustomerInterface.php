<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CustomerInterface
{
    public function store($user_id, Request $request);

}