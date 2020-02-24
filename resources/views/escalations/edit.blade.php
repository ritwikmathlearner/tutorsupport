
@extends('layouts.app')

@section('content')
@if(empty($error))
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Escalation') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('escalations.update', ['escalation'=>$escalation->id]) }}">
                            @csrf
                            @method('PUT')

                            @include('escalations._form')

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('Add Escalation') }}
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
    @include('backups._error');
@endif
@endsection
