@extends('layouts.app')

@section('content')
    <div class="container-md">
        <h1 class="h1">Escalations</h1>
        <table class="table table-bordered">
            @if($escalations !== null)
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Number</th>
                    <th scope="col">Receive Date</th>
                    <th scope="col">Student Message</th>
                    <th scope="col">Response</th>
                    <th scope="col">Upload Date</th>
                    <th scope="col">Justified</th>
                </tr>
                @foreach($escalations as $escalation)
                    <tr>
                        <td>
                            <a href="{{ route('tasks.show', [$escalation->task_id]) }}">{{ $escalation->order_id }}</a>
                        </td>
                        <td>{{ $escalation->escalation_count }}</td>
                        <td>{{ (\Carbon\Carbon::parse($escalation->receive_date_time)->format('l jS \\of F Y h:i:s A')) }}</td>
                        <td>{{ $escalation->student_message }}</td>
                        <td>{{ $escalation->response_message }}</td>
                        <td>{{ $escalation->escalation_upload === null ? 'Not uploaded yet' : (\Carbon\Carbon::parse($escalation->escalation_upload)->format('l jS \\of F Y h:i:s A')) }}</td>
                        <td>
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
        </table>
    </div>
@endsection
