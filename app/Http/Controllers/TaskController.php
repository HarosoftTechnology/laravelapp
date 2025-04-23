<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index()
    {
        // Using Eloquent to select just the 'id' and 'title' from the tasks table.
        $tasks = Task::all()->where('user_id', 1);
        return view('backend.tasks', compact('tasks'));
    }

    /**
     * Insert a new task into storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        // Retrieve all categories for the form
        $categories = TaskCategory::all();

        // Only process POST requests (AJAX or normal form submission)
        if ($request->isMethod('post')) { 
            // Validate the incoming request.
            $validator = Validator::make($request->all(), [
                'title'       => 'required|string|max:255',
                'category'    => 'required|numeric',
                'description' => 'required|string|max:255',
                'deadline'    => 'required|date',
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
            $created =  Task::create([
                'title'     => $request->input('title'),
                'category'     => $request->input('category'),
                'description'    => $request->input('description'),
                'deadline' => $request->input('deadline'),
                'user_id' => $user = Auth::user()->id,
            ]);

            if ($created) {
                if ($request->ajax()) {
                    return response()->json([
                        'type'    => 'success',
                        'message' => 'Task created successfully!',
                        'redirect'=> route('dashboard'),
                    ]);
                }
                return redirect()->to(url_to_pager('dashboard'))->with([
                    'flash-message'   => "Task created successfully!",
                    'flash-type'      => 'success',
                    'flash-dismiss'   => true,
                    'flash-position'  => 'bottom-right',
                ]);
            }

            // If creation failed, return error response.
            if ($request->ajax()) {
                return response()->json([
                    'type'    => 'error',
                    'message' => 'Could not create task! Please contact the administrator.'
                ]);
            }
            return redirect()->back()->with([
                'flash-message'   => "Could not create task! Please contact the administrator.",
                'flash-type'      => 'error',
                'flash-dismiss'   => true,
                'flash-position'  => 'bottom-right',
            ]);
        }

        // For GET requests, return the create-task view along with categories.
        return view('backend.create-task', compact('categories'));
    }

    /**
     * Update the specified task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Task $task)
    {
        // Retrieve all categories for the form
        $categories = TaskCategory::all();

        // Process POST requests (AJAX or regular form submission)
        if ($request->isMethod('post')) {
            // Validate the incoming request.
            $data = $request->validate([
                'title'       => 'required|string|max:255',
                'category'    => 'required|numeric', // You might change this to exists:task_categories,id
                'description' => 'required|string|max:255',
                'deadline'    => 'required|date',
            ]);

            // Update the task in the database.
            $updated = $task->update($data);

            if ($updated) {
                if ($request->ajax()) {
                    return response()->json([
                        'type'    => 'success',
                        'message' => 'Task updated successfully!',
                        'redirect'=> route('dashboard'),
                    ]);
                }
                return redirect()->to(url_to_pager('dashboard'))->with([
                    'flash-message'   => "Task updated successfully!",
                    'flash-type'      => 'success',
                    'flash-dismiss'   => true,
                    'flash-position'  => 'bottom-right',
                ]);
            }

            if ($request->ajax()) {
                return response()->json([
                    'type'    => 'error',
                    'message' => 'Could not update task! Please contact the administrator.',
                ]);
            }
            return redirect()->back()->with([
                'flash-message'   => "Could not update task! Please contact the administrator.",
                'flash-type'      => 'error',
                'flash-dismiss'   => true,
                'flash-position'  => 'bottom-right',
            ]);
        }
        // For GET requests, return the edit-task view along with task data and categories.
        //The compact second parameter is to pre-fill the form with the existing task's data.
        return view('backend.edit-task', compact('categories', 'task'));
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, Task $task): Response
    {
        $task->delete();

        if ($request->ajax()) {
            return response()->json([
                'type'    => 'success',
                'message' => 'Task deleted successfully!',
            ]);
        }

        return redirect()->back()->with([
            'flash-message'  => 'Task deleted successfully!',
            'flash-type'     => 'success',
        ]);
    }
}

