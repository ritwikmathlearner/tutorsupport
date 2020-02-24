@extends('layouts.app')

@section('content')
    <div class="container-md">
        <h1 class="h1">{{ $heading }}</h1>
        <table class="table table-bordered">
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Tutor Name</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
            </tr>
            @forelse ($backups as $backup)
            <tr class=”row”>
                <td>{{ $backup->order_id  }}</td>
                <td>{{ $backup->name  }}</td>
                <td>{{ $backup->amount  }}</td>
                <td>{{ \Carbon\Carbon::parse($backup->backup_given_date)->format('l jS \\of F Y') }}</td>
            </tr>
            @empty
                <p class="alert alert-danger">Task list is empty</p>
            @endforelse

        </table>
    </div>
@endsection
