@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

        @if(Session::has('message'))
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Change password success</h4>
            <p>{!! Session::get('message') !!}</p>
            <hr>
            <p class="mb-0">Immediately tell {{ $user->name }} his/her new password!.</p>
        </div>
        @endif
        <a class="btn btn-outline-danger" href="{{ URL::previous() }}">Cancel</a><br><br>
            <div class="card">
                <div class="card-header">
                    <h4>Change Password <b>{{ $user->name }}</b></h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['url' => 'ubah-password', 'method' => 'POST', 'files' => false]) !!}
                    {{ Form::token() }}
                    <center>
                        @if (substr($user->avatar, 0, 4)!="http")
                            <img class="img-thumbnail" src="/img/avatar/{{ $user->avatar }}" alt="">
                        @else
                            <img class="img-thumbnail" src="{{ $user->avatar }}" alt="">
                        @endif
                        <h3 class="mt-2"><b>{{ $user->name }}</b></h3>
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="form-group">
                            <label for="exampleInputEmail1">New Password</label>
                            <input type="password" name="newPassword" class="form-control" id="exampleInputEmail1" placeholder="Fill in the password for {{ $user->name }}">
                        </div>
                        <p>User will not be able to login with their old password, immediately tell {{ $user->name }} his/her new password!</p>
                        <input class="btn btn-warning" type="submit" value="Change Password">
                    </center>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert-success").slideUp(500);
});
</script>
@endsection
