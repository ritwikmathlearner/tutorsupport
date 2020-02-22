@extends('layouts.app')

@section('content')
    <div class="container-md">
        {{-- {{ dd($statistics[0]->date) }} --}}
        <h3>
            <small class="text-muted">Welcome</small>
            {{ Auth::user()->name  }}
        </h3>
        <table class="table table-bordered">
            <tr>
                <th scope="col">Email</th>
                <th scope="col">Team</th>
            </tr>
            <tr>
                <td>{{ Auth::user()->email  }}</td>
                <td>{{ Auth::user()->team  }}</td>
            </tr>
        </table>
        <h3 class="pt-3">
            <small class="text-muted">Statistics for month of</small>
            {{ date("F", mktime(0, 0, 0, $statistics[0]->date[0], 10)) }}
            {{ $statistics[0]->date[1] }}
        </h3>
        <form action="{{ route('home') }}" method="post" class="w-50 pt-3 pb-3 input-group">
            @csrf
            @method('GET')
            <select class="custom-select" name="month" id="month">
                <option value="null" selected>Select Month</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
            </select>
            <select class="custom-select ml-2" name="year" id="year">
                <option value="null" selected>Select Year</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
            </select>
            <input type="submit" value="See Details" name="monthSelect" class="btn btn-primary ml-2">
        </form>
        <table class="table table-bordered pt-3">
            <tr>
                <th style="width: 60%">Total Tasks Delivered this Month</th>
                <td style="width: 40%">{{ $statistics[0]->totalTaskCount  }}</td>
            </tr>
            <tr>
                <th>Total Word Count Submitted</th>
                <td class="form-inline" style="width: 100%; border: none;">
                    <a class="align-middle">{{ $statistics[0]->sumWordCount ?? 0  }}</a>
                    @if(isset($statistics[0]->sumWordCount))
                    <form action="{{ route('tasks.index') }}" method="post" class="w-50 input-group pl-3">
                        @csrf
                        @method('GET')
                        <input type="hidden" name="month" id="month" value="{{ $statistics[0]->date[0] }}">
                        <input type="hidden" name="year" id="year" value="{{ $statistics[0]->date[1] }}">
                        <input type="submit" value="See all" name="allSubmittedTasks" class="btn btn-link p-0 ml-2" title="shows only submitted tasks">
                    </form>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Total Backup Taken</th>
                <td style="display: flex;">
                    <a class="align-middle">{{ $statistics[0]->totalBackupTaken ?? 0 }}</a>
                    @if(isset($statistics[0]->totalBackupTaken))
                    <form action="{{ route('backups.index') }}" method="post" class="w-50 input-group pl-3">
                        @csrf
                        @method('GET')
                        <input type="hidden" name="month" id="month" value="{{ $statistics[0]->date[0] }}">
                        <input type="hidden" name="year" id="year" value="{{ $statistics[0]->date[1] }}">
                        <input type="submit" value="See all" name="backupsTaken" class="btn btn-link p-0 ml-2" title="shows only submitted tasks">
                    </form>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Total Backup Given</th>
                <td>{{ $statistics[0]->totalBackupGiven ?? 0 }}</td>
            </tr>
            <tr>
                <th>Total Missed Deadlines</th>
                <td>{{ $statistics[0]->missedDeadLine }}&nbsp;({{ ($statistics[0]->missedDeadLine/$statistics[0]->totalTaskCount)*100 }}%)</td>
            </tr>
        </table>
    </div>
@endsection
