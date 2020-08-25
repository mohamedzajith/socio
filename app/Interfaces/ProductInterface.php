<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductInterface
{
    public function index(Request $request);

    public function store(Request $request);

    public function update($id, Request $request);

    public function disable($id);

    public function delete($id);

}