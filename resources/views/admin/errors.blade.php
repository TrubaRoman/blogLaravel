@if($errors->any())
    <div class="container">
        <div class="rov col-md-10">
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                     @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
