@if($errors->any())
    <div class="alert alert-danger alert-dismissible show fade w-100">
        @foreach($errors->all() as $key => $error)
            <ul>
                <li>{{$error}}</li>
            </ul>
        @endforeach

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
