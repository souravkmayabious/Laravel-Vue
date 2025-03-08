<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{
    public function createTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user()->id,
        ]);

        return response()->json(['task' => $task, 'message' => 'Creted successfully'], 201);
    }



    public function viewAll()
    {
        $tasks = Task::all();
        return response()->json(['task' => $tasks, 'message' => 'All tasks'], 200);
    }



    public function viewAllPaginate(Request $request)
    {
        $perPage =  $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $tasks = Task::paginate($perPage);
        return response()->json(['tasks' => $tasks, 'message' => 'All tasks'], 200);
    }





    public function viewAllWithFilter(Request $request)
    {
        $filter_status = $request->input('status', '');
        $filter_by_user = $request->input('userid', '');
        $filter_by_date = $request->input('date', '');
        $perPage =  $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $tasksQuery = Task::query();

        if ($filter_status !== '') { 
            $tasksQuery->where('status', $filter_status);
        }

        if ($filter_by_user !== '') { 
            $tasksQuery->where('user_id', $filter_by_user);
        }

        if ($filter_by_date !== '') { 
            $tasksQuery->whereDate('created_at', '=', $filter_by_date);
        }

        $tasks = $tasksQuery->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'tasks' => $tasks,
            'message' => 'Filtered tasks',
            'tasksQuery' => $tasksQuery->toSql() 
        ], 200);
    }






    public function myTasks(Request $request)
    {
        $task = Task::where('user_id', $request->user()->id)->get();

        return response()->json(['task' => $task, 'message' => 'My tasks'], 200);
    }


    public function editTask($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $uid = $request->user()->id;
        $role = $request->user()->role;

        $task = Task::find($id);

        if (!$task) return response()->json(['error' => 'No post found'], 400);

        // if ($task->user_id !== $uid) {
        // if ($role !== 'admin' && $task->user_id !== $uid) { 
        if (!in_array($role, ['admin', 'editor']) && $task->user_id !== $uid) {
            return response()->json(['error' => 'You are not authorized to edit this task'], 403);
        }

        $task->title = $request->input('title');
        $task->description = $request->input('description');

        // Save the updated task
        $task->save();

        return response()->json(['task' => $task, 'message' => 'Tasks update success'], 200);
    }



    public function deleteTask($id, Request $request)
    {
        $task = Task::find($id);
        if (!$task) return response()->json(['error' => 'No post found'], 400);

        $uid = $request->user()->id;
        $role = $request->user()->role;

        if ($role !== 'admin') {
            return response()->json(['error' => 'You are not authorized to edit this task'], 403);
        }

        $task->delete();
        return response()->json(['task' => $task, 'message' => 'Tasks deleted success'], 200);
    }


    public function updateStatus($id, Request $request)
    {
        $task = Task::find($id);
        if (!$task) return response()->json(['error' => 'No post found'], 400);

        $uid = $request->user()->id;
        $role = $request->user()->role;

        if ($role !== 'admin' && $task->user_id !== $uid) {
            return response()->json(['error' => 'You are not authorized to edit this task'], 403);
        }

        $validStatuses = ['initial', 'completed'];
        $status = $request->input('status');

        if (!in_array($status, $validStatuses)) {
            return response()->json(['error' => 'Wrong status'], 403);
        }

        $task->status = $status;

        $task->save();

        return response()->json(['task' => $task, 'message' => 'Tasks status updated success'], 200);
    }
}
