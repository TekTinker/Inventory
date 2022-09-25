@foreach($errors->all() as $error)
    <div class="alert alert-danger">
        <i class="ace-icon fa fa-times"></i>
        {{ $error }}
    </div>
@endforeach

@if (session('info-error'))

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('info-error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif
@if (session('info-success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('info-success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif