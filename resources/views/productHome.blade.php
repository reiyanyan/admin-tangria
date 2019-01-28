@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <a class="btn btn-outline-dark" href="/home/">Back to Home</a><br><br>
            <div class="card-columns">
                <div class="card text-black-50 bg-light mb-3 p-5">
                    <div class="text-center">
                        <a class="btn btn-outline-primary" href="/product/new">Tambah baru</a>
                    </div>
                </div>
                @foreach ($products as $product)

                <div class="card">
                    <img class="card-img-top" src="{{ "/img/product/".$product->image}}">
                    <div class="card-body">
                        <h5 class="card-title"><a href="/product/{{ $product->id }}">{{ $product->name }}</a></h5>
                        <p class="card-text">{{ $product->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
