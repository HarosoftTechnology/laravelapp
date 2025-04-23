<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        // If the user is already authenticated, redirect them to the dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        if ($request->isMethod('post')) {  
            // Manually validate the request instead of using $request->validate()
            $validator = Validator::make($request->all(), [
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->errors(),
                    ], 422);
                }
                return redirect()->back()->with([
                    'flash-message'   => implode('<br>', $validator->errors()->all()),
                    'flash-type'      => 'error',
                    'flash-dismiss'   => false,
                    'flash-position'  => 'bottom-right',
                ]);                
            }

            // Attempt login using the provided credentials
            if (Auth::attempt($request->only('email', 'password'))) {
                // Regenerate session to prevent fixation
                $request->session()->regenerate();

                if ($request->ajax()) {
                    return response()->json([
                        'type'   => 'success',
                        'message'  => 'Login successful!',
                        'redirect' => route('dashboard'),
                    ]);
                }
                return redirect()->to(url_to_pager('dashboard'))->with([
                    'flash-message'   => "Login successful!",
                    'flash-type'      => 'success',
                    'flash-dismiss'   => true,
                    'flash-position'  => 'bottom-right',
                ]);
            }
            if ($request->ajax()) {
                return response()->json([
                    'type'   => 'error',
                    'message'  => 'Invalid username or password!',
                ]);
            }
            return redirect()->back()->with([
                'flash-message'   => "Invalid username or password!",
                'flash-type'      => 'error',
                'flash-dismiss'   => false,
                'flash-position'  => 'bottom-right',
            ]);
            // If authentication fails, return error response
            return response()->json([
                'errors' => [
                    'email' => ['Invalid username or password!'],
                ]
            ], 422);
        }

        return view('frontend.auth.login');
    }
}

