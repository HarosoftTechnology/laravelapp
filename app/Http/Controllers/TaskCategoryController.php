<?php

namespace App\Http\Controllers;

use App\Models\TaskCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TaskCategoryController extends Controller
{
    public function index() 
    {
        $categories = TaskCategory::all();
        return view('backend.task-categories', compact('categories'));
    }

    /**
     * Insert a new task category into storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        // Only process POST requests (AJAX or normal form submission)
        if ($request->isMethod('post')) { 
            // Validate the incoming request.
            $validator = Validator::make($request->all(), [
                'name'       => 'required|string|max:255',
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
            $created =  TaskCategory::create([
                'name'     => $request->input('name')
            ]);

            if ($created) {
                if ($request->ajax()) {
                    return response()->json([
                        'type'    => 'success',
                        'message' => 'Category created successfully!',
                        'redirect'=> route('task-categories'),
                    ]);
                }
                return redirect()->to(url_to_pager('task-categories'))->with([
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
                    'message' => 'Could not create task category! Please contact the administrator.'
                ]);
            }
            return redirect()->back()->with([
                'flash-message'   => "Could not create task category! Please contact the administrator.",
                'flash-type'      => 'error',
                'flash-dismiss'   => true,
                'flash-position'  => 'bottom-right',
            ]);
        }

        // For GET requests, return the create-task view along with categories.
        return view('backend.create-category');
    }

    /**
     * Update the specified task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskCategory  $category
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TaskCategory $category)
    {

        // Process POST requests (AJAX or regular form submission)
        if ($request->isMethod('post')) {
            // Validate the incoming request.
            $validator = Validator::make($request->all(), [
                'name'       => 'required|string|max:255'
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

            // Update the task in the database.
            $updated = $category->update([
                'name'       => $request->input('name')
            ]);

            if ($updated) {
                if ($request->ajax()) {
                    return response()->json([
                        'type'    => 'success',
                        'message' => 'Task updated successfully!',
                        'redirect'=> route('task-categories'),
                    ]);
                }
                return redirect()->to(url_to_pager('task-categories'))->with([
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

        return view('backend.edit-category', compact('category'));
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskCategory  $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, TaskCategory $category): Response
    {
        $category->delete();

        if ($request->ajax()) {
            return response()->json([
                'type'    => 'success',
                'message' => 'Category deleted successfully!',
            ]);
        }

        return redirect()->back()->with([
            'flash-message'  => 'Category deleted successfully!',
            'flash-type'     => 'success',
        ]);
    }
}
