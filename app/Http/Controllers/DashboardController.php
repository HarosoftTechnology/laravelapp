<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show dashboard.
     */
    public function index()
    {
        // $tasks = Task::all();
        $tasks = Task::select('*')->get();

        // Passing the retrieved tasks to the view.
        return view('admin-dashboard', compact('tasks'));
    }
}
