@extends('layouts.app')

@section('content')
    <div class="container-md">
        <h1 class="h1">Task Details</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Add New Task</a>
        <form id="search" action="{{ route('tasks.index') }}" method="POST" class="form-inline w-100 mb-3" onsubmit="return dateForm();">
            @csrf
            @method('GET')
            <input type="hidden" name="type" id="type" value="search">
            <input type="date" name="startDate" id="startDate" class="form-control">
            <span class="ml-2 mr-2">&rightarrow;</span>
            <input type="date" name="endDate" id="endDate" class="form-control">
            <input type="submit" value="Search" class="btn btn-primary ml-3">
            <span class="font-italic ml-3">(Search for deadline within dates)</span>
        </form>
        <table class="table table-bordered">
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Subject</th>
                <th scope="col">Title</th>
                <th scope="col">Word Count</th>
                <th scope="col">Deadline</th>
                <th scope="col">Upload Time</th>
                <th scope="col">Actions</th>
            </tr>
            @forelse ($tasks as $task)
            <tr class=”row”>
                <td><a href="{{ route('tasks.show', ['task'=>$task->id])  }}">
                        {{ $task->order_id  }}
                    </a></td>
                <td>{{ $task->subject  }}</td>
                <td>{{ $task->title  }}</td>
                <td>{{ $task->word_count  }}</td>
                <td>{{ \Carbon\Carbon::parse($task->dead_line)->format('l jS \\of F Y h:i:s A')  }}</td>
                <td>
                    @if(empty($task->upload_time))
                        Task not uploaded yet
                    @else
                        {{ \Carbon\Carbon::parse($task->upload_time)->format('l jS \\of F Y h:i:s A')  }}
                    @endif    
                </td>
                <td>
                    <form action="{{ route('tasks.destroy', ['task'=>$task->id]) }}" method="post" onsubmit="return checkForm();">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" name="delete" class="btn btn-danger">
                    </form>
                </td>
            </tr>
            @empty
                <p class="alert alert-danger">Task list is empty</p>
            @endforelse

        </table>
    </div>
@endsection
