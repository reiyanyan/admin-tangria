  @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <a class="btn btn-outline-dark" href="/user/">Back To list</a><br><br>
            <div class="card">
                <div class="card-header">
		@if(getRole()==2)
                  @if (getRole()==2)
                  <a class="btn btn-outline-danger" data-toggle="modal" data-target="#modalBlock"> Block </a>
                  @else
                  <a class="btn btn-outline-danger" href="/user/block/{{ $user->id }}"> Unblock </a>
                  @endif
		@else
		<h4>{{ $user->name }}</h4>
		@endif
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <div class="modal fade" id="modalBlock" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Block User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <h1>Block user <b>{{ $user->name }}</b> ?</h1>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                {{--<a href="/user/block/{{ $user->id }}" class="btn btn-danger">Block</a>--}}
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    {!! Form::open(['url' => 'user/edit', 'method' => 'POST', 'files' => true]) !!}
                    {{ Form::token() }}
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <center>
                        @if (substr($user->avatar, 0, 4)!="http")
                            <img class="img-thumbnail" src="/img/avatar/{{ $user->avatar }}" alt="">
                        @else
                            <img class="img-thumbnail" src="{{ $user->avatar }}" alt="">
                        @endif
                    </center>
                    <br>
                    <div class="form-group">
                        <input name="avatar" type="file" class="form-control-file" accept="image/*" id="exampleFormControlFile1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name="nama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Isikan nama user" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">E-mail</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Isikan Email"
                            value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone</label>
                        <input type="text" name="phone" class="form-control" id="exampleInputEmail1" placeholder="Isikan no hp"
                            value="{{ $user->phone }}">
                    </div>
                    <div>
                        <a href="../" class="btn btn-outline-info">Cancel</a>
                        <button type="submit" class="btn btn-warning">Save</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection
