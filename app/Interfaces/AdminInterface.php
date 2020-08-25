<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AdminInterface
{
    public function store($user_id, Request $request);

}