<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'id', 'user_id', 'first_name', 'last_name', 'contact_no'
    ];
}
