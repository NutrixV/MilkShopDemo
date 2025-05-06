<?php
/**
 * Controller for customer registration.
 *
 * @category Controller
 * @package  App\Http\Controllers
 * @author   Your Name
 * @license  MIT
 * @link     https://yourdomain.com
 */

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class CustomerAuthController
 * @package App\Http\Controllers
 */
class CustomerAuthController extends Controller
{
    /**
     * Handle customer registration request.
     *
     * @param  Request $request Request instance
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email',
                'password' => 'required|string|min:6',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                422
            );
        }

        $customer = Customer::create(
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]
        );

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Registration successful',
                'customer' => $customer,
            ]
        );
    }

    /**
     * Handle customer login request.
     *
     * @param  Request $request Request instance
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                422
            );
        }

        $customer = Customer::where('email', $request->input('email'))->first();
        if (!$customer || !\Hash::check($request->input('password'), $customer->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => ['login' => ['Invalid email or password']],
            ], 401);
        }
        // Зберігаємо кастомера в сесії
        $request->session()->put('customer_id', $customer->id);
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'customer' => $customer,
        ]);
    }

    /**
     * Logout customer (clear session).
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->session()->forget('customer_id');
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out',
        ]);
    }
} 