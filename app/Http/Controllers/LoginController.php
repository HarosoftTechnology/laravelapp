<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Libraries\MetaTags;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        MetaTags::getInstance()
            ->set('title', 'Welcome to My Laravel App')
            ->set('description', 'This is the homepage of my awesome Laravel application.')
            ->set('keywords', 'laravel, homepage, awesome');

        // If the user is already authenticated, redirect them to the dashboard
        if (Auth::check()) {
            return redirect()->route('admin-dashboard');
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
                return redirect()->back()->withInput()->with([
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
            
                $user = Auth::user();
                
                if (!empty($user->resume)) {
                    // If resume is not empty, use its value for redirection.
                    session()->put('resume', $user->resume);
                    $redirect = session()->get('resume');
                    
                    // Clear the resume column so it doesn't affect subsequent logins
                    $user->resume = "";
                    $user->save();
                } else {
                    // If resume is empty, check if the user has the admin role.
                    if ($user->hasRole('admin')) {
                        $redirect = route('admin-dashboard');
                    } else {
                        $redirect = route('home');
                    }
                }
            
                if ($request->ajax()) {
                    return response()->json([
                        'type'     => 'success',
                        'message'  => 'Login successful!',
                        'redirect' => $redirect,
                    ]);
                }
                return redirect()->to($redirect)->with([
                    'flash-message'   => "Login successful!",
                    'flash-type'      => 'success',
                    'flash-dismiss'   => true,
                    'flash-position'  => 'bottom-left',
                ]);
            }
            if ($request->ajax()) {
                return response()->json([
                    'type'   => 'error',
                    'message'  => 'Invalid username or password!',
                ]);
            }
            return redirect()->back()->withInput()->with([
                'flash-message'   => "Invalid username or password!",
                'flash-type'      => 'error',
                'flash-dismiss'   => false,
                'flash-position'  => 'bottom-right',
            ]);
        }

        return view('auth.login', [
            'title'       => $this->title,
            'keywords'    => $this->keywords,
            'description' => $this->description,
            'noBanner'    => $this->noBanner, 
        ]);
    }
}

