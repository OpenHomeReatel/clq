<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Gate;
use Mail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller {

    public function index() 
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tasks = Task::with(['user'])->get();

        return view('admin.tasks.index', compact('tasks'));
    }

    public function create() 
    {
        abort_if(Gate::denies('task_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.tasks.create', compact('users'));
    }

    public function store(StoreTaskRequest $request) 
    {
        $task = Task::create($request->all());

        Mail::send('mails.task_created', compact('task'), function ($message) use ($task) {
            $message
                ->from(config('mail.from.address'), config('mail.from.name'))
                ->to($task->user->email, $task->user->full_name)
                ->subject('You have been assigned to a new task');
        });

        return redirect()->route('admin.tasks.index');
    }

    public function edit(Task $task) 
    {
        abort_if(Gate::denies('task_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $task->load('user');

        return view('admin.tasks.edit', compact('users', 'task'));
    }

    public function update(UpdateTaskRequest $request, Task $task) 
    {
        $task->update($request->all());

        
      
        return redirect()->route('admin.tasks.index');
    }

    public function show(Task $task) 
    {
        abort_if(Gate::denies('task_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $task->load('user');

        return view('admin.tasks.show', compact('task'));
    }

    public function destroy(Task $task) 
    {
        abort_if(Gate::denies('task_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $task->delete();

        return back();
    }

    public function massDestroy(MassDestroyTaskRequest $request) 
    {
        Task::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
