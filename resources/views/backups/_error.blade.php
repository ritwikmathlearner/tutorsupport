<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Oops!</h1>
                <h2>{{ $error }}</h2>
                <div class="error-details alert alert-danger">
                    If this is intentional then it may lead to your account be deleted forever
                </div>
                <div class="error-actions">
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                Take Me Home </a><a href="{{ route('tasks.index') }}" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> All Tasks </a>
                </div>
            </div>
        </div>
    </div>
</div>