@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-md-center">
<div class="col-xs-7 col-md-7 col-sm-7">
        <a class="btn btn-outline-dark" href="/home/">Back To home</a><br><br>
    <div class="card card-shadow">
        <div class="card-header">
            <h1>Closed Hour</h1>
        </div>
        <div class="card-body">
        <hr>
            {!! Form::open(['url' => 'date', 'method' => 'POST', 'files' => true]) !!}
            {{ Form::token() }}
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" required name="date" id="date" class="form-control">
            </div>
            <div class="form-group">
                <label for="time">Time</label>
                <select id="selectTime" class="form-control" name="time" id="time">
                    <option selected="selected" value="08:00:00">08:00</option>
                    <option value="09:00:00">09:00</option>
                    <option value="10:00:00">10:00</option>
                    <option value="11:00:00">11:00</option>
                    <option value="12:00:00">12:00</option>
                    <option value="13:00:00">13:00</option>
                    <option value="14:00:00">14:00</option>
                    <option value="15:00:00">15:00</option>
                    <option value="16:00:00">16:00</option>
                </select>
            </div>
            <div class="form-group">
                <label for="descReason">Reason</label>
                <textarea name="description" class="form-control" id="reason" rows="5" placeholder="Reason for closing" required></textarea>
            </div>
            <center><button type="submit" id="oke" class="btn btn-primary" style="width:120px;">Ok</button></center>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center" style="margin-top:10px;">
                    <h2 id="txtDate" style="display:inline; margin-right:30px;"></h2>
                    <h2 id="txtTime" style="display:inline;"></h2>
                    </div>
                </div>
                </div>
            </div>
            {!! Form::close() !!}
            <br><br>
            <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Information</th>
                    </tr>
                </thead>
                <tbody>
                  <?php setlocale(LC_TIME, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID' ) ?>
                    @foreach($results as $result)
                    <tr>
                        <th scope="row">{{$result->id}}</th>
                        <td>{{ strftime("%A, %B %d %Y. %H:%M", strtotime($result->date)) }}</td>
                        <td>unavailable</td>
                        <td>{{ $result->reason }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <br>
        {{$results -> links()}}
    </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#date').on('input',function(){
        var valu = $('#date').val();
        $('#txtDate').html(valu);
    });
     $('#selectTime').change(function(){
         var valu = $('#selectTime').val();
         $('#txtTime').html(valu);
    });
});
</script>
@endsection
