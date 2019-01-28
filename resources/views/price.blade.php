@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <a class="btn btn-outline-dark" href="/home/">Back To home</a><br><br>
            <div class="card">
                <div class="card-header"> <h1>Harga</h1></div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Diskon</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prices as $key => $price)
                                <tr @if($price->harga == NULL) style="color:#e84118" @endif>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{ infoProduct($price->product_id)->name }}</td>
                                    <td>{{ $price->diskon }}%</td>
                                    <td>{{ $price->harga }}</td>
                                    <td>
                                        <a class="btn btn-outline-dark" href="/price/edit/{{$price->id}}" >Info</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
