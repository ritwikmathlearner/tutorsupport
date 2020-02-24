<div class="form-group row">
    <label for="escalation_count" class="col-md-4 col-form-label text-md-right">{{ __('Escalation Count') }}</label>

    <div class="col-md-6">
        <input id="escalation_count" type="number" class="form-control @error('escalation_count') is-invalid @enderror" name="escalation_count" value="{{ old('escalation_count', $escalation->escalation_count ?? null) }}" required autocomplete="escalation_count" autofocus>

        @error('escalation_count')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="receive_date_time" class="col-md-4 col-form-label text-md-right">{{ __('Escalation Date') }}</label>

    <div class="col-md-6">
        <input id="receive_date_time" type="datetime-local" class="form-control @error('receive_date_time') is-invalid @enderror" name="receive_date_time" value="{{ old('receive_date_time', $escalation->receive_date_time ?? null) }}" required autocomplete="receive_date_time" autofocus>

        @error('receive_date_time')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="student_message" class="col-md-4 col-form-label text-md-right">{{ __('Student Message') }}</label>

    <div class="col-md-6">
        <textarea id="student_message" class="form-control @error('student_message') is-invalid @enderror" name="student_message" autocomplete="student_message" autofocus cols="30" rows="5">{{ old('student_message', $escalation->student_message ?? null) }}</textarea>

        @error('student_message')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <label for="response_message" class="col-md-4 col-form-label text-md-right">{{ __('Response Message') }}</label>

    <div class="col-md-6">
        <textarea id="response_message" class="form-control @error('response_message') is-invalid @enderror" name="response_message" autocomplete="response_message" autofocus cols="30" rows="5">{{ old('response_message', $escalation->response_message ?? null) }}</textarea>

        @error('response_message')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="escalation_upload" class="col-md-4 col-form-label text-md-right">{{ __('Upload Date') }}</label>

    <div class="col-md-6">
        <input id="escalation_upload" type="datetime-local" class="form-control @error('escalation_upload') is-invalid @enderror" name="escalation_upload" value="{{ old('escalation_upload', $escalation->escalation_upload ?? null) }}" autocomplete="escalation_upload" autofocus>

        @error('escalation_upload')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <label for="not_justified" class="col-md-4 col-form-label text-md-right">{{ __('Justified') }}</label>

    <div class="col-md-6">
        <select class="custom-select" name="not_justified" id="not_justified">
            <option value="null" selected>Select</option>
                <option value="1">No</option>
                <option value="0">Yes</option>
        </select>

        @error('not_justified')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<input type="hidden" name="task_id" id="task_id" value="{{ $task_id }}">