<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller 
{
    public function __invoke()
    {
        $users = ['John', 'Mike', 'Susan', 'Jimmy', 'Kazem'];
        return view('frontend.friends', compact('users',));
    }
}
