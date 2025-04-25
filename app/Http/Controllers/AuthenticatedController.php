<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class AuthenticatedController extends Controller
{
    public function __construct()
    {
        // Apply the session timeout middleware automatically 
        // for all controllers that extend this one.
        $this->middleware('session.timeout');
    }
}
