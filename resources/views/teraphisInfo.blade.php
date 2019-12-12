@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <a class="btn btn-outline-dark" href="/teraphis/">Back To list</a><br><br>
            <div class="card card-shadow">
                <div class="card-header">
                  <h1>Teraphist</h1>
                </div>
                <div class="card-body">
                    {!! Form::open(['url' => 'teraphis/update', 'method' => 'POST', 'files' => true]) !!}
                    {{ Form::token() }}
                    <input type="hidden" name="id" value="{{ $teraphis->id }}">
                    <br>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Isikan nama product" value="{{ $teraphis->nama }}">
                    </div>
                    <div class="form-group">
                      <label for="selectHari">Day off</label><br>
                      <select id="selectTime" class="form-control" name="libur">
                          <option selected="selected" value="Senin">Monday</option>
                          <option value="Selasa">Tuesday</option>
                          <option value="Rabu">Wednesday</option>
                          <option value="Kamis">Thursday</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Specialist</label><br>
                        @foreach($products as $product)
                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" name="spesialis[]" class="custom-control-input" id="{{ $product->name }}" value="{{ $product->name }}" @if(getTeraphisValue($teraphis->nama,$product->id) == true ) checked  @endif>
                          <label class="custom-control-label" for="{{ $product->name }}">{{ $product->name }}</label>
                        </div>
                        @endforeach
                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" name="spesialis[]" class="custom-control-input" id="Other" value="Other" @if($teraphis->spesialis == '"Other"') checked  @endif>
                          <label class="custom-control-label" for="Other">Other</label>
                        </div>
                    </div>
                    <div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning">Save</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
