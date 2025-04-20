@if(Session::has('success'))
    <div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">نجاح</h4>
        <div class="alert-body">
            {{Session::get('success')}}
        </div>
    </div>
@endif
