@extends('layouts.app')

@section('content')
    @if(empty($error))
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Update Task') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('tasks.update', ['task'=>$task->id]) }}">
                                @csrf
                                @method('PUT')

                                @include('tasks._form');

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update Task') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('tasks._error')
    @endif
@endsection
