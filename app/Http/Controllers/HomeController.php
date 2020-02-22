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
        $tasks = Task::all()
        ->where('user_id', Auth::user()->id);
        $missedDeadLine = 0;
        foreach($tasks as $task) {
            if((Carbon::parse($task->upload_time)->month == $currMonth) && (Carbon::parse($task->upload_time)->year == $currYear)){
                if(($task->upload_time)>=($task->dead_line)){
                    $missedDeadLine++;
                } elseif(($task->upload_time) == NULL){
                    if(Carbon::now() >= $task->dead_line){
                        $missedDeadLine++;
                    }
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
        $statistics[0]->missedDeadLine= $missedDeadLine;
        $statistics[0]->date= $date;
        $statistics[0]->totalBackupTaken = $totalBackupTaken[0]->totalBackupTaken;
        $statistics[0]->totalBackupGiven = $totalBackupGiven[0]->totalBackupGiven;
        return view('home', ['statistics'=>$statistics]);
        // dd($missedDeadLine);
    }
}
