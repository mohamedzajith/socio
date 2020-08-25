<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthenticateInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticateController extends Controller
{
    private $authenticateRepository;

    public function __construct(AuthenticateInterface $authenticateRepository)
    {
        $this->authenticateRepository = $authenticateRepository;
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'contact_no' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
            $user = $this->authenticateRepository->register($request);
            return $this->successResponse($user, 'user create successfully');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }

    public function adminRegister(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
            $user = $this->authenticateRepository->adminRegister($request);
            return $this->successResponse($user, 'user create successfully');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }

    public function login(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            $credentials = $request->only('email', 'password');

            $loginState = $this->authenticateRepository->login($credentials);

            if (!$loginState['status']) {
                return $this->errorResponse($loginState['response']);
            }

            return $this->successResponse([
                'token' => $loginState['token'],
                'expire_at' => date_create('+' . config('jwt.ttl') . 'minutes')->format('Y-m-d H:i:s'),
            ],'login success');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        }  catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }

    public function adminLogin(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            $credentials = $request->only('email', 'password');

            $loginState = $this->authenticateRepository->adminLogin($credentials);

            if (!$loginState['status']) {
                return $this->errorResponse($loginState['response']);
            }

            return $this->successResponse([
                'token' => $loginState['token'],
                'expire_at' => date_create('+' . config('jwt.ttl') . 'minutes')->format('Y-m-d H:i:s'),
            ],'login success');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        }  catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }
}