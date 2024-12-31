<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssigned;


class TaskController extends Controller
{
   
    public function create()
    {
        return view('tasks.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'required|date|after:today',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('attachments', 'public');
        }

        $task = Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => 'pending',
            'file_path' => $filePath,
        ]);
        // Send email notification
        // Mail::to(auth()->user()->email)->send(new TaskAssigned($task));

        return redirect()->route('dashboard');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'required|date|after:today',
            'status' => 'required|in:pending,completed',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('attachments', 'public');
            $task->file_path = $filePath;
        }

        $task->update($request->except('file'));

        return redirect()->route('dashboard');
    }

    public function destroy(Task $task)
    {
        if ($task->file_path) {
            \Storage::disk('public')->delete($task->file_path);
        }

        $task->delete();
        return redirect()->route('dashboard');
    }
}
