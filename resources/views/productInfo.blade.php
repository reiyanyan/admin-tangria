@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
        <a class="btn btn-outline-dark" href="/product/">Back To list</a><br><br>
            <div class="card">
                <div class="card-header">
                    <div class="float-md-right">
                      @if(getRole() == 2 )
                      <a class="btn btn-outline-danger" data-toggle="modal" data-target="#modalDelete">Delete</a>
                      @else
                      <a class="btn btn-outline-danger">Delete</a>
                      @endif
                        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Hapus Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <h1>Yakin ingin menghapus <b>{{ $product->name }}</b> ?</h1>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a href="/product/delete/{{ $product->id }}" class="btn btn-danger">Delete</a>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['url' => 'product/update', 'method' => 'POST', 'files' => true]) !!}
                    {{ Form::token() }}
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <center>
                        <img class="img-thumbnail" src="/img/product/{{ $product->image }}" alt="">
                    </center>
                    <br>
                    <div class="form-group">
                        <input name="image" type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Isikan nama product" value="{{ $product->name }}">
                    </div>
                    <div class="form-group">
                        <label for="time">Category</label>
                        <select id="selectTime" class="form-control" name="cat" id="cat">
                          <option value="package_treatment">Package Treatment</option>
                          <option value="ala_carte_treatment">Ala Carte Treatment</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="time">Available</label>
                        <select id="selectAvailable" class="form-control" name="available" id="available">
                            @if($product->available == "true")
                            <option selected="selected" value="true">Tersedia</option>
                            <option value="false">Tidak Tersedia</option>
                            @else
                            <option value="true">Tersedia</option>
                            <option selected="selected" value="false">Tidak Tersedia</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Deskripsi</label>
                        <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="5">{{ $product->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea name="note" class="form-control" id="note" rows="3">{{ $product->note }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Harga</label>
                        @if(is_null(infoPrice($product->id)->harga))
                            <input type="text" name="price" readonly class="form-control" id="exampleInputEmail1" placeholder="Isikan harga"
                                value="">
                        @else
                            <input type="text" name="price" readonly class="form-control" id="exampleInputEmail1" placeholder="Isikan harga"
                                value="{{ infoPrice($product->id)->harga }}">
                        @endif
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection
