<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Backup;
use App\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->input());
        if($request->input('backupsTaken') !== null){
            $currMonth = $request->input('month');
            $currYear = $request->input('year');
            $backups = DB::table('backups')
            ->join('tasks', 'backups.task_id', '=', 'tasks.id')
            ->join('users', 'backups.user_id', '=', 'users.id')
            ->select(
            DB::raw('tasks.order_id, users.name, backups.*')
            )
            ->where('tasks.user_id', Auth::user()->id)
            ->whereRaw('MONTH(backup_given_date) = ?', [$currMonth])
            ->whereRaw('YEAR(backup_given_date) = ?', [$currYear])
            ->get();
            // dd($tasks);
            // return view('tasks.index', ['tasks' => $tasks]);
            return view('backups.index', ['backups' => $backups, 'heading'=>'Backup Taken']);
        } elseif($request->input('backupsGiven') !== null) {
            $currMonth = $request->input('month');
            $currYear = $request->input('year');
            $backups = DB::table('backups')
            ->join('tasks', 'backups.task_id', '=', 'tasks.id')
            ->join('users', 'backups.user_id', '=', 'users.id')
            ->select(
            DB::raw('tasks.order_id, backups.*')
            )
            ->where('backups.user_id', Auth::user()->id)
            ->whereRaw('MONTH(backup_given_date) = ?', [$currMonth])
            ->whereRaw('YEAR(backup_given_date) = ?', [$currYear])
            ->get();
            foreach($backups as $backup){
                $result = DB::table('tasks')
                ->join('users', 'tasks.user_id', '=', 'users.id')
                ->select('users.name')
                ->where('tasks.id', $backup->task_id)
                ->get();
                $backup->name = $result[0]->name;
            }
            // dd($backups);
            return view('backups.index', ['backups' => $backups,'heading'=>'Backup Given']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|integer|min:100',
            'user_id' => 'required|integer',
            'task_id' => 'required|integer',
            'backup_given_date' => 'nullable|date',
            'description' => 'nullable|string|max:1000'
        ]);

        // dd($validatedData);
        $backup = Backup::create($validatedData);

        $request->session()->flash('status', 'Backup added');
        return redirect()->route('tasks.show', ['task' => $backup->task_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $backup = Backup::findOrFail($id);
        // dd($backup);
        $task = DB::table('tasks')
        ->where('user_id', Auth::user()->id)
        ->where('id', $backup->task_id)
        ->get();
        // dd($task);
        if(!empty($task[0])){
            return view('backups.edit', ['backup' => $backup]);
        } else {
            return view('backups.edit', ['error' => 'This backup is not associated with your assignment']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'amount' => 'required|integer|min:100',
            'user_id' => 'required|integer',
            'task_id' => 'required|integer',
            'backup_given_date' => 'nullable|date',
            'description' => 'nullable|string|max:1000'
        ]);
        $backup = Backup::where('id', $id)
        ->update($validatedData);
        $request->session()->flash('status', 'Backup updated');
        return redirect()->route('tasks.show', ['task' => $validatedData['task_id']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // dd($id);
        Backup::destroy($id);
        $task_id = $request->input('task_id');
        $request->session()->flash('status', 'Backup is deleted');
        return redirect()->route('tasks.show', ['task'=>$task_id]);
    }
}
