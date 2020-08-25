<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthenticateInterface;
use App\Interfaces\ProductInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        try {
            $product = $this->productRepository->index($request);
            return $this->successResponse($product, 'user create successfully');
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'price' => 'required',
                'discount' => 'required',
                'image' => 'required',
                'discription' => 'required'
            ]);
            $product = $this->productRepository->store($request);
            return $this->successResponse($product, 'product has successfully create');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $request->validate([
                'name' => 'sometimes|required',
                'price' => 'sometimes|required',
                'discount' => 'sometimes|required',
                'image' => 'sometimes|required',
                'discription' => 'sometimes|required'
            ]);
            $product = $this->productRepository->update($id, $request);
            return $this->successResponse($product, 'product has successfully update');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }

    public function disable($id)
    {
        try {
            $product = $this->productRepository->disable($id);
            return $this->successResponse($product, 'product has disabled');
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }

    public function delete($id)
    {
        try {
            $product = $this->productRepository->delete($id);
            return $this->successResponse($product, 'product successfully removed');
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }
}