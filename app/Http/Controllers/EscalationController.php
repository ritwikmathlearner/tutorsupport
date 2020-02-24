<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreEscalation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Escalation;
use App\Task;
use Carbon\Carbon;

class EscalationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currMonth = $request->input('month');
        $currYear = $request->input('year');
        // dd($currMonth, $currYear);
        $escalations = DB::table('escalations')
        ->join('tasks', 'escalations.task_id', '=', 'tasks.id')
        ->select(
            DB::raw('escalations.*, tasks.order_id')
        )
        ->where('tasks.user_id', Auth::user()->id)
        ->whereRaw('MONTH(upload_time) = ?', [$currMonth])
        ->whereRaw('YEAR(upload_time) = ?', [$currYear])
        ->get();
        return view('escalations.index', ['escalations' => $escalations]);
        // dd($escalations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $task = Task::findOrFail($id);
        if(Auth::user()->id == $task->user_id){
            return view('escalations.create', ['task_id'=>$id]);
        } else {
            return view('escalations.create', ['error' => 'Mentioned task is not allocated to you']);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEscalation $request)
    {
        $validatedData = $request->validated();
        $escalation = Escalation::create($validatedData);
        $request->session()->flash('status', 'Escalation is added');
        return redirect()->route('tasks.show', ['task' => $escalation->task_id]);
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
        $escalation = Escalation::findOrFail($id);
        // dd($escalation->receive_date_time);
        $escalation->receive_date_time = \Carbon\Carbon::parse($escalation->receive_date_time)->format('Y-m-d\TH:i');
        $escalation->escalation_upload = $escalation->escalation_upload === null ? null : \Carbon\Carbon::parse($escalation->escalation_upload)->format('Y-m-d\TH:i');
        $task_id = $request->input('task_id');
        $task = Task::findOrFail($task_id);
        // dd(, $id);
        if(Auth::user()->id == $task->user_id){
            return view('escalations.edit', ['task_id'=>$task_id, 'escalation'=>$escalation]);
        } else {
            return view('escalations.edit', ['error' => 'Mentioned task is not allocated to you']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEscalation $request, $id)
    {
        $validatedData = $request->validated();
        // dd($validatedData);
        $escalation = Escalation::where('id', $id)
        ->update($validatedData);
        $request->session()->flash('status', 'Escalation updated');
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
        Escalation::destroy($id);
        $task_id = $request->input('task_id');
        $request->session()->flash('status', 'Escalation is deleted');
        return redirect()->route('tasks.show', ['task'=>$task_id]);
    }
}
