@if ($notification = Session::get('success'))
    <div class="alert alert-success alert-dismissible text-white" role="alert">
        <span class="text-sm">{{ $notification }}</span>
        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span>
        </button>
    </div>
@endif

@if ($notification = Session::get('error'))
    <div class="alert alert-danger alert-dismissible text-white" role="alert">
        <span class="text-sm">{{ $notification }}</span>
        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span>
        </button>
    </div>
@endif

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible text-white" role="alert">
                <span class="text-sm">{{ $error }}</span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                    aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
        @endforeach
    </ul>
@endif



@if ($notification = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible text-white" role="alert">
        <span class="text-sm">{{ $notification }}</span>
        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span>
        </button>
    </div>
@endif


@if ($notification = Session::get('info'))
    <div class="alert alert-info alert-dismissible text-white" role="alert">
        <span class="text-sm">{{ $notification }}</span>
        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span>
        </button>
    </div>
@endif
