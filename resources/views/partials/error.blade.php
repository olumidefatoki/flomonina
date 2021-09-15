@if(count($errors->all()))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif


@if(session('errorMessage'))
<div class="col-md-12">
    <div class="alert alert-danger" role="alert">
        {{ session('errorMessage') }}
    </div>
</div>
@endif