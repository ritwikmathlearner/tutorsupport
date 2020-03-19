<?php

namespace App\Http\Controllers;

use App\User;
use App\Task;
use App\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // dd($request->input('year') == 0 ? 0 : 1);
        if($request->input() != null){
            $currMonth = $request->input('month') != 0 ? $request->input('month') : Carbon::now()->month;
            $currYear = $request->input('year') != 0 ? $request->input('year') : Carbon::now()->year;
        } else {
            $currMonth = Carbon::now()->month;
            $currYear = Carbon::now()->year;
        }
        $date = [$currMonth, $currYear];
        // $tasks = Task::all()
        // ->where('user_id', Auth::user()->id);
        $tasks = DB::table('tasks')
        ->select('tasks.*')
        ->where('tasks.user_id', Auth::user()->id)
        ->whereNotNull('upload_time')
        ->whereRaw('MONTH(upload_time) = ?', [$currMonth])
        ->whereRaw('YEAR(upload_time) = ?', [$currYear])
        ->get();
        $missedDeadLine = 0;
        foreach($tasks as $task) {
            if(($task->upload_time)>=($task->dead_line)){
                $missedDeadLine++;
            } elseif(($task->upload_time) == NULL){
                if(Carbon::now() >= $task->dead_line){
                    $missedDeadLine++;
                }
            }
        }
        $statistics = DB::table('tasks')
        ->select(
        DB::raw('SUM(tasks.word_count) as sumWordCount'),
        DB::raw('count(tasks.id) as totalTaskCount')
        )
        ->where('tasks.user_id', Auth::user()->id)
        ->whereNotNull('upload_time')
        ->whereRaw('MONTH(upload_time) = ?', [$currMonth])
        ->whereRaw('YEAR(upload_time) = ?', [$currYear])
        ->get();
        $totalBackupTaken = DB::table('backups')
        ->join('tasks', 'backups.task_id', '=', 'tasks.id')
        ->select(
        DB::raw('SUM(backups.amount) as totalBackupTaken')
        )
        ->where('tasks.user_id', Auth::user()->id)
        ->whereRaw('MONTH(backup_given_date) = ?', [$currMonth])
        ->whereRaw('YEAR(backup_given_date) = ?', [$currYear])
        ->get();

        $totalBackupGiven = DB::table('backups')
        ->select(
        DB::raw('SUM(backups.amount) as totalBackupGiven')
        )
        ->where('backups.user_id', Auth::user()->id)
        ->whereRaw('MONTH(backup_given_date) = ?', [$currMonth])
        ->whereRaw('YEAR(backup_given_date) = ?', [$currYear])
        ->get();
        // dd($totalBackupTaken);
        $totalEscalations = DB::table('escalations')
        ->join('tasks', 'escalations.task_id', '=', 'tasks.id')
        ->select(
            DB::raw('COUNT(escalations.id) as totalEscalations')
        )
        ->where('tasks.user_id', Auth::user()->id)
        ->whereRaw('MONTH(receive_date_time) = ?', [$currMonth])
        ->whereRaw('YEAR(receive_date_time) = ?', [$currYear])
        ->get();
        // dd($totalEscalations);
        $statistics[0]->missedDeadLine= $missedDeadLine;
        $statistics[0]->date= $date;
        $statistics[0]->totalBackupTaken = $totalBackupTaken[0]->totalBackupTaken;
        $statistics[0]->totalBackupGiven = $totalBackupGiven[0]->totalBackupGiven;
        $statistics[0]->totalEscalations = $totalEscalations[0]->totalEscalations;
        return view('home', ['statistics'=>$statistics]);
        // dd($missedDeadLine);
    }
}
