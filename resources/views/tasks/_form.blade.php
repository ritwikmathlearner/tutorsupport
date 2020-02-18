<div class="form-group row">
    <label for="order_id" class="col-md-4 col-form-label text-md-right">{{ __('Order ID') }}</label>

    <div class="col-md-6">
        <input id="order_id" type="number" class="form-control @error('order_id') is-invalid @enderror" name="order_id" value="{{ old('order_id', $task->order_id ?? null) }}" required autocomplete="order_id" autofocus>

        @error('order_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="subject" class="col-md-4 col-form-label text-md-right">{{ __('Subject') }}</label>

    <div class="col-md-6">
        <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject', $task->subject ?? null) }}" required autocomplete="subject" autofocus>

        @error('subject')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

    <div class="col-md-6">
        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $task->title ?? null) }}" required autocomplete="title" autofocus>

        @error('title')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

    <div class="col-md-6">
        <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country', $task->country ?? null) }}" required autocomplete="country" autofocus>

        @error('country')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="reference_style" class="col-md-4 col-form-label text-md-right">{{ __('Reference Style') }}</label>

    <div class="col-md-6">
        <input id="reference_style" type="text" class="form-control @error('reference_style') is-invalid @enderror" name="reference_style" value="{{ old('reference_style', $task->reference_style ?? null) }}" required autocomplete="reference_style" autofocus>

        @error('reference_style')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="reference_number" class="col-md-4 col-form-label text-md-right">{{ __('No of References') }}</label>

    <div class="col-md-6">
        <input id="reference_number" type="number" class="form-control @error('reference_number') is-invalid @enderror" name="reference_number" value="{{ old('reference_number', $task->reference_number ?? null) }}" required autocomplete="reference_number" autofocus>

        @error('reference_number')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="dead_line" class="col-md-4 col-form-label text-md-right">{{ __('Deadline') }}</label>

    <div class="col-md-6">
        <input id="dead_line" type="datetime-local" class="form-control @error('dead_line') is-invalid @enderror" name="dead_line" value="{{ old('dead_line', $task->dead_line ?? null) }}" required autocomplete="dead_line" autofocus>

        @error('dead_line')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="upload_time" class="col-md-4 col-form-label text-md-right">{{ __('Upload Time') }}</label>

    <div class="col-md-6">
        <input id="upload_time" type="datetime-local" class="form-control @error('upload_time') is-invalid @enderror" name="upload_time" value="{{ old('upload_time', $task->upload_time ?? null) }}" autocomplete="upload_time" autofocus>

        @error('upload_time')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="deliverable" class="col-md-4 col-form-label text-md-right">{{ __('Deliverables') }}</label>

    <div class="col-md-6">
        <textarea id="deliverable" class="form-control @error('deliverable') is-invalid @enderror" name="deliverable" autocomplete="deliverable" autofocus cols="30" rows="5">{{ old('deliverable', $task->deliverable ?? null) }}</textarea>

        @error('deliverable')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

    <div class="col-md-6">
        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" autofocus cols="30" rows="5">{{ old('description', $task->description ?? null) }}</textarea>

        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="word_count" class="col-md-4 col-form-label text-md-right">{{ __('Assigned Word Count') }}</label>

    <div class="col-md-6">
        <input id="word_count" type="number" class="form-control @error('word_count') is-invalid @enderror" name="word_count" value="{{ old('word_count', $task->word_count ?? null) }}" required autocomplete="word_count" autofocus>

        @error('word_count')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="word_distribution" class="col-md-4 col-form-label text-md-right">{{ __('Word Count Break') }}</label>

    <div class="col-md-6">
        <input id="word_distribution" type="text" class="form-control @error('word_distribution') is-invalid @enderror" name="word_distribution" value="{{ old('word_distribution', $task->word_distribution ?? null) }}" required autocomplete="word_distribution" autofocus>

        @error('word_distribution')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="case_study" class="col-md-4 col-form-label text-md-right">{{ __('Case Study') }}</label>

    <div class="col-md-6">
        <input id="case_study" type="text" class="form-control @error('case_study') is-invalid @enderror" name="case_study" value="{{ old('case_study', $task->case_study ?? null) }}" required autocomplete="case_study" autofocus>

        @error('case_study')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">