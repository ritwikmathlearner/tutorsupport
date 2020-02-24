<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
use App\Task;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->input() != null){
            if($request->input('type') == 'search'){
                $tasks = DB::table('tasks')
                ->where('user_id', Auth::user()->id)
                ->whereRaw('DATE(dead_line) >= ?', [$request->input('startDate')])
                ->whereRaw('DATE(dead_line) <= ?', [$request->input('endDate')])
                ->orderByDesc('dead_line')
                ->get();
            } else {
                $currMonth = $request->input('month');
                $currYear = $request->input('year');
                $tasks = DB::table('tasks')
                ->where('user_id', Auth::user()->id)
                ->whereRaw('MONTH(upload_time) = ?', [$currMonth])
                ->whereRaw('YEAR(upload_time) = ?', [$currYear])
                ->orderByDesc('dead_line')
                ->get();
            }
        } else {
            $tasks = DB::table('tasks')
            ->where('user_id', Auth::user()->id)
            ->orderByDesc('dead_line')
            ->get();
        }
        return view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTask $request)
    {
        $validatedData = $request->validated();
        $validatedData['dead_line'] = \Carbon\Carbon::parse($validatedData['dead_line'])->format('Y-m-d H:i:s');
        if (!empty($validatedData['upload_time'])) {
            $validatedData['upload_time'] = \Carbon\Carbon::parse($validatedData['upload_time'])->format('Y-m-d H:i:s');
        }
//        dd($validatedData);
        $task = Task::create($validatedData);

        $request->session()->flash('status', 'Task is added');
        return redirect()->route('tasks.show', ['task' => $task->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        $tags = DB::table('tags')
        ->where('task_id', $id)
        ->get();
        $backups = DB::table('backups')
        ->join('users', 'backups.user_id', '=', 'users.id')
        ->select('backups.*', 'users.name')
        ->where('task_id', $id)
        ->get();
        $escalations = DB::table('escalations')
        ->select('escalations.*')
        ->where('task_id', $id)
        ->get();
        $totalBackupTaken = $backups->sum('amount');
        $users = User::all()->except(Auth::id());
        // dd(isset($escalations[0]));
        if(Auth::user()->id == $task->user_id) {
            return view('tasks.show', ['task' => $task, 'tags'=>$tags, 'backups'=>$backups, 'tt'=>$totalBackupTaken, 'escalations' => $escalations, 'users'=>$users]);
        } else {
            return view('tasks.show', ['error' => 'This task is not assigned to you']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $task->dead_line = \Carbon\Carbon::parse($task->dead_line)->format('Y-m-d\TH:i');
        if (!empty($task->upload_time)) {
            $task->upload_time = \Carbon\Carbon::parse($task->upload_time)->format('Y-m-d\TH:i');
        }
        if(Auth::user()->id == $task->user_id) {
            return view('tasks.edit', ['task' => $task]);
        } else {
            return view('tasks.edit', ['error' => 'This task is not assigned to you']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTask $request, $id)
    {
        $validatedData = $request->validated();
        // dd($validatedData);
        $task = Task::where('id', $id)
            ->update($validatedData);

        $request->session()->flash('status', 'Task is updated');
        return redirect()->route('tasks.show', ['task' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        if(Auth::user()->id == $task->user_id) {
            Task::destroy($id);
            $request->session()->flash('status_danger', 'Task is deleted');
            return redirect()->route('tasks.index');
        } else {
            return view('tasks.show', ['error' => 'This task is not assigned to you']);
        }
    }
}
