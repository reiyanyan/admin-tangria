@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <a class="btn btn-outline-dark" href="/home/">Back To home</a><br><br>
            <div class="card card-shadow">
                <div class="card-header">
                    <h1>Booking</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <input type="date" name="date" id="datepicker" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <input type="text" id="nameSearch" placeholder="Cari nama atau kode" class="form-control">
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Order</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Room</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="ori-table">
														<?php setlocale(LC_TIME, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID'); ?>
                            @foreach($bookings as $key => $booking)
                                <tr @if($booking->created_at->format('Y-m-d') == date('Y-m-d')) style="color:#18dcff;" @elseif($booking->status == "cancel") style="color:#e86118"
                                    @elseif($booking->status == "rejected") style="color:#f20000"
                                    @endif>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{ DB::table('users')->where('id',$booking->user_id)->first()->name }}</td>
                                    <td>{{ DB::table('products')->where('id',$booking->order)->first()->name }}</td>
                                    <td>{{ strftime("%A, %B %d %Y. %H:%M", strtotime($booking->date)) }}</td>
                                    <td>{{ $booking->status}}</td>
                                    <td>{{ $booking->room }}</td>
                                    <td>
                                        <a class="btn btn-outline-dark" href="/booking/{{$booking->id}}">Info</a>
                                    </td>
                                </tr>
																@endforeach
                        </tbody>
                        <tbody id="nama-table">
                        </tbody>
                        <tbody id="date-table">
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            {{$bookings -> links()}}
        </div>
    </div>
</div>
</div>
@endsection

@section('javascript')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        document.getElementById("nameSearch").addEventListener("keypress", searchUser);
        document.getElementById("datepicker").addEventListener("input", searchDate);
        function searchUser(e) {
            var key = e.which || e.keycode;
            if(key == 13){
                $('#ori-table').css('display','none');
                $('#nama-table').empty();
                $('.pagination').css('display','none');
                $('#date-table').empty();
                document.getElementById("datepicker").value= '';
                if (document.getElementById("nameSearch").value.length > 0) {
                    var someUrl = '/api/booking/name/' + document.getElementById("nameSearch").value;
                    $.ajax({
                        type: "GET",
                        url: someUrl,
                        success: function (data) {
                            $.each(data, function (index, element) {
                                index = index+1;
                                var room = ((element.room != null) ? element.room : "");
                                var html = '<tr><td>'+ index +'</td><td>' + element.name +
                                    '</td><td>' + element.order + '</td><td>' + element.date +
                                    '</td><td>' + element.status +
                                    '</td><td>' + room +
                                    '</td><td><a href="/booking/' + element.id +
                                    '" class="btn btn-dark">Info</a></td></tr>'
                                $('#nama-table').append(html);
                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(errorThrown);
                        },
                        dataType: "json"
                    });
                }else{
                    $('#ori-table').css('display','');
                    $('.pagination').css('display','');
                    $('#nama-table').empty();
                    $('#date-table').empty();
                    document.getElementById("datepicker").value= '';
                }
            }
        }
        function searchDate(){
            $('#ori-table').css('display','none');
            $('#nama-table').empty();
            $('.pagination').css('display','none');
            $('#date-table').empty();
            document.getElementById("nameSearch").value='';
            if (document.getElementById("datepicker").value!='') {
                var someUrl = '/api/booking/date/' + document.getElementById("datepicker").value;
                $.ajax({
                    type: "GET",
                    url: someUrl,
                    success: function (data) {
                        $.each(data, function (index, element) {
                            index = index+1;
var room = ((element.room != null) ? element.room : "");
                  
                            var html = '<tr><td>'+ index +'</td><td>' + element.name +
                                '</td><td>' + element.order + '</td><td>' + element.date +
                                '</td><td>' + element.status +
                                '</td><td>' + room +
                                '</td><td><a href="/booking/' + element.id +
                                '" class="btn btn-dark">Info</a></td></tr>'
                            $('#nama-table').append(html);
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                    },
                    dataType: "json"
                });
            }else{
                $('#ori-table').css('display','');
                $('.pagination').css('display','');
                $('#nama-table').empty();
                $('#date-table').empty();
            }
        }
    });

</script>
@endsection
