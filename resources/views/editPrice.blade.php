@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a class="btn btn-outline-dark" href="/price/">Back To List</a><br><br>
            <div class="card">
                <div class="card-header">
                    <h1>Harga</h1>
                </div>
                <div class="card-body">
                    {!! Form::open(['url' => 'price', 'method' => 'POST']) !!}
                    {{ Form::token() }}
                    <input type="hidden" name="id" value="{{ $prices->id }}">
                    <center>
                        <img class="img-thumbnail" src="/img/product/{{ infoProduct($prices->product_id)->image }}" alt="">
                    </center>
                    <br>
                    <div class="form-group">
                        <label for="nameInput">Nama</label>
                        <input type="text" name="name" readonly class="form-control" id="nameInput" value="{{ infoProduct($prices->product_id)->name }}">
                    </div>
                    <div class="form-group">
                        <label for="desc">Deskripsi</label>
                        <textarea readonly name="description" class="form-control" id="desc" rows="5">{{infoProduct($prices->product_id)->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea readonly name="note" class="form-control" id="note" rows="3">{{ infoProduct($prices->product_id)->note }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="hargaInput">Harga</label>
                        <input type="text" name="price" class="form-control" id="hargaInput" value="{{ $prices->harga}}">
                    </div>
                    <div class="form-group">
                        <label for="diskonInput">Diskon</label>
                        <input type="text" name="diskon" class="form-control" id="diskonInput" value="{{ $prices->diskon }}">
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
@endsection
