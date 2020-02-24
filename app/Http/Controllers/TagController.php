<?php

namespace App\Http\Controllers;

use App\Task;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index(Request $request){
        $tag = $request->input('tag');
        $tasks = DB::table('tasks')
        ->select('tasks.*')
        ->join('tags', 'tasks.id', '=', 'tags.task_id')
        ->where('tasks.user_id', Auth::user()->id)
        ->where('tags.tag', 'like', "%{$tag}%")
        ->orderByDesc('dead_line')
        ->distinct()
        ->get();
        if(count($tasks) !== 0) {
            if(count($tasks) === 1) {
                $task = $tasks[0];
                return redirect()->route('tasks.show', ['task' => $task->id]);
            } else {
                return view('tasks.index', ['tasks' => $tasks]);
            }
        } else {
            return view('tasks.index', ['error' => 'No result found']);
        }
        
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
            'tag'=>'required|string|max:200',
            'task_id'=>'required|integer'
        ]);
        $task_id = $validatedData['task_id'];
        Tag::Create($validatedData);
        $request->session()->flash('status', 'Tag is added');
        return redirect()->route('tasks.show', ['task' => $task_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Tag::destroy($id);
        $task_id = $request->input('task_id');
        $request->session()->flash('status_danger', 'Tag is deleted');
        return redirect()->route('tasks.show', ['task'=>$task_id]);
    }
}
