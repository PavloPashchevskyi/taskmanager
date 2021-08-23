<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        switch ($request->get('filter')) {
            case 'completed':
                return Task::where('complete', true)->orderBy('due_date', 'desc')->get();
            case 'uncompleted':
                return Task::where('complete', false)->orderBy('due_date', 'desc')->get();
            default:
                return Task::orderBy('due_date', 'desc')->get();
        }
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function store(Request $request)
    {
        $executor = User::where('email', $request->get('executor_email'))->first();
        $task = Task::create([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'due_date' => ($request->has('due_date')) ? $request->get('due_date') : null,
            'complete' => ($request->has('complete')) ? $request->get('complete') : false,
            'attachment_path' => ($request->has('attachment_path')) ? $request->get('attachment_path') : '',
            'remind_executor_in' => ($request->has('remind_executor_in')) ? $request->get('remind_executor_in') : '',
            'creator_id' =>  Auth::guard('api')->id(),
            'executor_id' => ($executor instanceof User) ? $executor->id : Auth::guard('api')->id(),
        ]);

        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return response()->json($task);
    }

    public function complete(Task $task)
    {
        $task->update(['complete' => true]);

        return response()->json($task);
    }

    public function delete(Task $task)
    {
        $task->delete();

        return response()->json(null, 204);
    }
}
