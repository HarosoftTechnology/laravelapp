<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    /**
     * Process the AJAX signup form submission.
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {            
            // Validate the form inputs
            $validator = Validator::make($request->all(), [
                'firstname'    => 'required|string|max:255',
                'email'        => 'required|email|unique:users,email',
                'password'     => 'required|string|min:6|confirmed',
            ]);

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

            // Create the user after successful validation
            $created = $user = User::create([
                'firstname'     => $request->input('firstname'),
                'lastname'     => $request->input('lastname'),
                'email'    => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            if($created) {
                // Automatically log in the newly registered user
                Auth::login($user);
                if ($request->ajax()) {
                    return response()->json([
                        'type'   => 'success',
                        'message'  => 'Registration successful!',
                        'redirect' => route('dashboard'),
                    ]);
                }
                return redirect()->to(url_to_pager('dashboard'))->with([
                    'flash-message'   => "Registration successful!",
                    'flash-type'      => 'success',
                    'flash-dismiss'   => true,
                    'flash-position'  => 'bottom-right',
                ]);
            }
            if ($request->ajax()) {
                return response()->json([
                    'type'   => 'error',
                    'message'  => 'Could not signup! Please contact the administrator.',
                ]);
            }
            return redirect()->back()->with([
                'flash-message'   => "Could not signup! Please contact the administrator.",
                'flash-type'      => 'error',
                'flash-dismiss'   => true,
                'flash-position'  => 'bottom-right',
            ]);
            
        }
        
        return view('frontend.auth.signup');
    }
}
