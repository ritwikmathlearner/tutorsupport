@extends('layouts.app')

@section('content')
    @if(empty($error))
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Update Backup') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('backups.update', ['backup'=>$backup->id]) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Word Count') }}</label>
                                
                                    <div class="col-md-6">
                                        <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount', $backup->amount ?? null) }}" required autocomplete="amount" autofocus>
                                
                                        @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="backup_given_date" class="col-md-4 col-form-label text-md-right">{{ __('Word Count') }}</label>
                                
                                    <div class="col-md-6">
                                        <input id="backup_given_date" type="date" class="form-control @error('backup_given_date') is-invalid @enderror" name="backup_given_date" value="{{ old('backup_given_date', $backup->backup_given_date ?? null) }}" required autocomplete="backup_given_date" autofocus>
                                
                                        @error('backup_given_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Word Count') }}</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="20" rows="2" autocomplete="description" autofocus>{{ old('description', $backup->description ?? null) }}</textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="user_id" id="user_id" value="{{ $backup->user_id }}">
                                <input type="hidden" name="task_id" id="task_id" value="{{ $backup->task_id }}">

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update Backup') }}
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
        @include('backups._error')
    @endif
@endsection
