@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">   خطأ في البيانات</h4>
        <div class="alert-body">
            <div class="">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
@endif
