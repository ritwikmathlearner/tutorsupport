@extends('layouts.app')

@section('content')
    @if(empty($error))
        @if(!empty($errors))
            <div class="container-md mb-3 danger text-danger">
                {{ $errors->first() }}
            </div>
        @endif
        <div class="container-md">
            <h3>
                <small class="text-muted">Order ID: </small>
                {{ $task->order_id }}
            </h3>
            <div class="mb-3 row container">
                <a href="{{ route('tasks.edit', ['task'=>$task->id]) }}" class="btn btn-warning col-xs-6">Edit</a>
                <form action="{{ route('tasks.destroy', ['task'=>$task->id]) }}" method="post" onsubmit="return checkForm();" class="col-xs-6">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete" name="delete" class="btn btn-danger ml-3">
                </form>
            </div>
            
            <div>
                <h3 class="text-primary">Order Details</h3>
                <table class="table table-bordered">
                    <tr>
                        <th scope="col">Subject</th>
                        <th scope="col">Title</th>
                        <th scope="col">Country</th>
                        <th scope="col">Reference Style</th>
                        <th scope="col">No of References</th>
                    </tr>
                    <tr>
                        <td style="width: 20%">{{ $task->title  }}</td>
                        <td style="width: 20%">{{ $task->subject  }}</td>
                        <td style="width: 20%">{{ $task->country  }}</td>
                        <td style="width: 20%">{{ $task->reference_style  }}</td>
                        <td style="width: 20%">{{ $task->reference_number  }}</td>
                    </tr>
                </table>
            </div>

            <div>
                <h3 class="text-primary">Deliverable</h3>
                <table class="table table-bordered">
                    <tr>
                        <th scope="col">Case Study</th>
                        <th scope="col">Description Message</th>
                        <th scope="col">Deliverable</th>
                    </tr>
                    <tr>
                        <td style="width: 20%">{{ $task->case_study  }}</td>
                        <td style="width: 40%">
                            @if(empty($task->description))
                                Description was not provided
                            @else
                                {{ $task->description }}
                            @endif    
                        </td>
                        <td style="width: 40%">
                            @if(empty($task->deliverable))
                                Deliverable not sent yet
                            @else
                                {{ $task->deliverable }}
                            @endif    
                        </td>
                    </tr>
                </table>
            </div>

            <div>
                <h3 class="text-primary">Word Count Details</h3>
                <table class="table table-bordered">
                    <tr>
                        <th scope="col">Total Word Count</th>
                        <th scope="col">Backups</th>
                        <th scope="col">Deductions</th>
                    </tr>
                    <tr>
                        <td style="width: 20%">
                            {{ $task->word_count }}
                        </td>
                        <td style="width: 40%">
                            @forelse($backups as $backup)
                                <div class="mb-2 w-100" style="display: flex; justify-content: flex-start;">
                                    <p>{{ $backup->amount }} words by {{ $backup->name }}</p>
                                    &nbsp; 
                                    <form action="{{ route('backups.edit', ['backup'=>$backup->id]) }}" method="post" onsubmit="return checkBackupAdd();">
                                        @csrf
                                        @method('GET')
                                        <input type="hidden" name="task_id" id="task_id" value="{{ $task->id }}">
                                        <button type="submit" value="add" name="add" style="border: none; background: transparent"></i
                                            <span><i class="fas fa-edit text-warning" style="cursor: pointer"></i></span>
                                        </button>
                                    </form>
                                    &nbsp;
                                    <form action="{{ route('backups.destroy', ['backup'=>$backup->id]) }}" method="post" onsubmit="return checkDeleteBackup();">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="task_id" id="task_id" value="{{ $task->id }}">
                                        <button type="submit" value="Delete" name="delete" style="border: none; background: transparent"></i
                                            <span><i class="far fa-trash-alt text-danger" style="cursor: pointer"></i></span>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                No backup taken for this task
                            @endforelse
                            <br>
                            <p>
                                <strong>Total:</strong>
                                @if (!empty($backups))
                                    {{ $tt }}  
                                @endif
                            </p>
                            <form class="input-group" action="{{ route('backups.store') }}" method="post" onsubmit="return checkBackupAdd();">
                                @csrf
                                <input type="hidden" name="task_id" id="task_id" value="{{ $task->id }}">
                                <input type="number" name="amount" class="form-control w-25" id="amount" placeholder="Word count" value="{{ old('amount') }}" required>
                                <input type="date" name="backup_given_date" class="form-control ml-3" id="backup_given_date" value="{{ old('backup_given_date') }}">
                                <select class="custom-select ml-3" name="user_id" id="user_id">
                                    <option value="null" selected>Select User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="email" name="amount" id="amount" placeholder="User email" required> --}}
                                <button type="submit" value="add" name="add" style="border: none; background: transparent"></i
                                    <span><i class="fas fa-plus text-primary" style="cursor: pointer"></i></span>
                                </button>
                            </form>
                        </td>
                        <td style="width: 40%">
                            @if(($task->upload_time)>($task->dead_line))
                                Deadline missed
                            @elseif(empty($task->upload_time))
                                @if((\Carbon\Carbon::now())>($task->dead_line))
                                    Deadline missed
                                @else
                                    Still have {{ (\Carbon\Carbon::parse($task->dead_line)->diffForHumans()) }}
                                @endif
                            @else
                                Submitted in time
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            
            <div>
                <h3 class="text-primary">Deadline Details</h3>
                <table class="table table-bordered">
                    <tr>
                        <th scope="col">Deadline</th>
                        <th scope="col">Upload Date Time</th>
                        <th scope="col">Deadline Status</th>
                    </tr>
                    <tr>
                        <td style="width: 40%">
                            {{ \Carbon\Carbon::parse($task->dead_line)->format('l jS \\of F Y h:i:s A')  }}
                        </td>
                        <td style="width: 40%">
                            @if(empty($task->upload_time))
                                Task not uploaded yet
                            @else
                                {{ \Carbon\Carbon::parse($task->upload_time)->format('l jS \\of F Y h:i:s A')  }}
                            @endif
                        </td>
                        <td style="width: 20%">
                            @if(($task->upload_time)>($task->dead_line))
                                Deadline missed
                            @elseif(empty($task->upload_time))
                                @if((\Carbon\Carbon::now())>($task->dead_line))
                                    Deadline missed
                                @else
                                    Still have {{ (\Carbon\Carbon::parse($task->dead_line)->diffForHumans()) }}
                                @endif
                            @else
                                Submitted in time
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div>
                <h3 class="text-primary">Escalations</h3>
                <a href="{{ route('escalations.create', ['task_id'=>$task->id]) }}" class="btn btn-danger mb-3">Add New Escalation</a>
                <table class="table table-bordered">
                    @if(isset($escalations[0]))
                        <tr>
                            <th scope="col">Number</th>
                            <th scope="col">Receive Date</th>
                            <th scope="col">Student Message</th>
                            <th scope="col">Response</th>
                            <th scope="col">Upload Date</th>
                            <th scope="col">Justified</th>
                        </tr>
                        @foreach($escalations as $escalation)
                            <tr>
                                <td style="display: flex; border: none">
                                    {{ $escalation->escalation_count }}
                                    &nbsp; 
                                    <form action="{{ route('escalations.edit', ['escalation'=>$escalation->id]) }}" method="post">
                                        @csrf
                                        @method('GET')
                                        <input type="hidden" name="task_id" id="task_id" value="{{ $task->id }}">
                                        <button type="submit" value="edit" name="edit" style="border: none; background: transparent">
                                            <span><i class="fas fa-edit text-warning" style="cursor: pointer"></i></span>
                                        </button>
                                    </form>
                                    &nbsp;
                                    <form action="{{ route('escalations.destroy', ['escalation'=>$escalation->id]) }}" method="post" onsubmit="return checkDeleteEscalation();">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="task_id" id="task_id" value="{{ $task->id }}">
                                        <button type="submit" value="Delete" name="delete" style="border: none; background: transparent"></i
                                            <span><i class="far fa-trash-alt text-danger" style="cursor: pointer"></i></span>
                                        </button>
                                    </form>
                                </td>
                                <td style="width: 10%">{{ (\Carbon\Carbon::parse($escalation->receive_date_time)->format('l jS \\of F Y h:i:s A')) }}</td>
                                <td style="width: 30%">{{ $escalation->student_message }}</td>
                                <td style="width: 30%">{{ $escalation->response_message }}</td>
                                <td style="width: 10%">{{ $escalation->escalation_upload === null ? 'Not uploaded yet' : (\Carbon\Carbon::parse($escalation->escalation_upload)->format('l jS \\of F Y h:i:s A')) }}</td>
                                <td style="width: 10%">
                                    @if (isset($escalation->not_justified))
                                        {{ $escalation->not_justified !== 1 ? 'Yes' : 'No' }}
                                    @else
                                        Not selected
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <p class="text-success">No escalations</p>
                    @endif
                    {{-- @forelse($escalations as $escalation)
                        <tr>
                            <td></td>
                        </tr>
                    @empty
                        <p class="text-success">No escalations</p>
                    @endforelse --}}
                </table>
            </div>

            <div>
                <h3 class="text-primary">Tags</h3>
                @forelse ($tags as $tag)
                    <div class="tag">
                        {{ $tag->tag }}
                        <form action="{{ route('tags.destroy', ['tag'=>$tag->id]) }}" method="post" onsubmit="return checkTagDelete();">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="task_id" id="task_id" value="{{ $tag->task_id }}">
                            <button type="submit" value="Delete" name="delete" id="tagDeleteBtn">+</button>
                        </form>
                    </div>
                @empty
                    <p>No tag is available</p>
                @endforelse
                <div>
                    <form method="POST" action="{{ route('tags.store') }}" id="addTagForm" class="form-inline">
                        @csrf
                        <input type="hidden" name="task_id" id="task_id" value="{{ $task->id }}">
                        <input type="text" name="tag" id="tag" placeholder="Enter tag" required>
                        <button type="submit" id="add" class="btn">+</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        @include('tasks._error')
    @endif
@endsection
