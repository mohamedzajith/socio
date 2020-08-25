<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductRepository implements ProductInterface
{
    public function index(Request $request)
    {
        try {
            $products = Product::whereIn('status', $request->status)
                ->paginate(5);
            return $products;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function store(Request $request)
    {
        try {
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'discount' => $request->discount,
                'image' => $request->image,
                'discription' => $request->discription,
                'status' => 'active'
            ]);
            return $product;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function update($id, Request $request)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                Product::where('id',$id)->update([
                    'name' => $request->name ? $request->name : $product->name,
                    'price' => $request->price ? $request->price : $product->price,
                    'discount' => $request->discount ? $request->discount : $product->discount,
                    'image' => $request->image ? $request->image : $product->image,
                    'discription' => $request->discription ? $request->discription : $product->discription,
                ]);
                return Product::find($id);
            }
            throw new Exception('product not found', 404);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function disable($id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                Product::where('id',$id)->update([
                    'status' => 'disable'
                ]);
                return Product::find($id);
            }
            throw new Exception('product not found', 404);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function delete($id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                Product::where('id',$id)->delete();
                return $product;
            }
            throw new Exception('product not found', 404);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}