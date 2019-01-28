@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <a class="btn btn-outline-dark" href="/teraphis/">Back To list</a><br><br>
            <div class="card">
                <div class="card-header">
                  <h1>Teraphis</h1>
                </div>
                <div class="card-body">
                    {!! Form::open(['url' => 'teraphis/update', 'method' => 'POST', 'files' => true]) !!}
                    {{ Form::token() }}
                    <input type="hidden" name="id" value="{{ $teraphis->id }}">
                    <br>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Isikan nama product" value="{{ $teraphis->nama }}">
                    </div>
                    <div class="form-group">
                      <label for="selectHari">Hari Libur</label><br>
                      <select id="selectTime" class="form-control" name="libur">
                          <option selected="selected" value="Senin">Senin</option>
                          <option value="Selasa">Selasa</option>
                          <option value="Rabu">Rabu</option>
                          <option value="Kamis">Kamis</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Spesialis</label><br>
                        @foreach($products as $product)
                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" name="spesialis[]" class="custom-control-input" id="{{ $product->name }}" value="{{ $product->name }}" @if(getTeraphisValue($teraphis->nama,$product->id) == true ) checked  @endif>
                          <label class="custom-control-label" for="{{ $product->name }}">{{ $product->name }}</label>
                        </div>
                        @endforeach
                    </div>
                    <div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning">Simpan</button>
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
