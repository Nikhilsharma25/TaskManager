<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;


class DashboardController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $taskdata =  Task::get();
        return view('dashboard', compact('taskdata'));
    }


    public function getTasksData(Request $request)
    {
        $query = Task::where('status', 'completed');

        if ($request->has('title') && $request->title) {
            $query->where('title', 'LIKE', "%" . $request->title . "%");
        }

        if ($request->has('description') && $request->description) {
            $query->where('description', 'LIKE', "%" . $request->description . "%");
        }

        $taskdata = $query->get();
        return response()->json($taskdata);
    }
}
