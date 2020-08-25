<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'id', 'email', 'password', 'first_name', 'last_name', 'contact_no'
    ];
}
