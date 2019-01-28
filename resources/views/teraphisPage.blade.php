@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
          <div class="row">
            <div class="col">
            <a class="btn btn-outline-dark" style="display:inline-block;" href="/home/">Back to Home</a> &nbsp &nbsp
            <a class="btn btn-outline-dark" style="display:inline-block;" href="/teraphis/new">Tambah pegawai</a>
          </div>
        </div>
            <br><br>
            <div class="card">
                <div class="card-header"> <h1>Teraphis</h1>
                </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Libur</th>
                                    <th scope="col">Spesialis</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                              @foreach($teraphis as $key => $teraphi)

                              <tr>
                                <th scope="row">{{ ++$key }}</th>
                                <td>{{ $teraphi->nama }}</td>
                                <td>{{ $teraphi->libur }}</td>
                                <td>{{ getSpesialis($teraphi->nama) }}</td>
                                <td>
                                    <a class="btn btn-outline-dark" href="/teraphis/{{ $teraphi->id }}">Info</a>
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
