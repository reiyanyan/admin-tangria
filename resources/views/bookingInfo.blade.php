@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <a class="btn btn-outline-dark" href="/booking/">Back To list</a><br><br>
            <div class="card card-shadow">
                <div class="card-header">
                    <div class="float-md-right">
                        @if ($booking->status == "pending")
                            <a href="#" class="btn btn-outline-warning" style="cursor:default;">
                                Pending
                            </a>
                        @elseif($booking->status == "diterima")
                            <a href="#" class="btn btn-outline-success" style="cursor:default;">
                                Accepted
                            </a>
                        @else
                            <a href="#" class="btn btn-outline-danger" style="cursor:default;">
                                Rejected
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" readonly class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ infoUser($booking->user_id)->name }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Order</label>
                            <input type="text" readonly class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ infoProduct($booking->order)->name }}">
                        </div>
                        <div class="form-group">
                          <?php setlocale(LC_TIME, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID'); ?>
                            <label for="exampleInputEmail1">Date</label>
                            <input type="text" readonly class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ strftime("%A, %B %d %Y", strtotime($booking->date)) }}">
                        </div>
                        @if ($booking->status == "diterima" )
                        <div class="form-group">
                            <label for="exampleInputEmail1">Teraphist</label>
                            <input type="text" readonly class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ infoTeraphis($booking->order, strftime("%A", strtotime($booking->date)), $booking->teraphist)->nama }}">
                        <br>
                        <label for="ruangan">Room</label>
                          <input type="text" readonly class="form-control" id="ruangan" aria-describedby="emailHelp"
                          value="{{ $booking->room }}">
                          <br>
                        <label for="code">Code</label>
                          <input type="text" readonly class="form-control" id="code" aria-describedby="emailHelp"
                           value="{{ $booking->code }}">
                        </div>
                            <p align="center" class="text-black-50">Booking has been accepted</p>
                        @elseif($booking->status == "cancel")
                        <div class="form-group">
                          <label for="pesan">Message</label>
                          <input type="text" readonly class="form-control" id="pesan" aria-describedby="emailHelp"
                            value="{{ $booking->message }}">
                        </div>
                        <p align="center" class="text-red-50">Booking has been rejected</p>
                        @else
                        <center>
                            <a class="btn btn-outline-danger" data-toggle="modal" data-target="#modalCancel">Reject</a>
                            <a class="btn btn-outline-success" @if($teraphis->isNotEmpty()) data-toggle="modal" data-target="#modalDone" @endif >Accept</a>
                        </center>
                        @endif
                    </form>

                    <form action="/booking/done/{{$booking->id}}" method="get">
                    <div class="modal fade" id="modalDone" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Teraphis</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                            <div class="modal-body">
                              <label for="selectTeraphis">Teraphis</label>
                              <select id="selectTeraphis" class="form-control" name="teraphis">
                                  @foreach($teraphis as $teraphi)
                                    <option value="{{ $teraphi->nama }}">{{ $teraphi->nama  }}</option>
                                  @endforeach
                              </select>
                            </div>
                            <div class="modal-body">
                              <label for="selectRoom">Room</label>
                              <select id="selectRoom" class="form-control" name="room">
                                <option selected="selected" value="Lily 1">Lily 1</option>
                                <option value="Lily 2">Lily 2</option>
                                <option value="Aster 1">Aster 1</option>
                                <option value="Aster 2">Aster 2</option>
                                <option value="Aster 3">Aster 3</option>
                                <option value="Orchid 1">Orchid 1</option>
                                <option value="Orchid 2">Orchid 2</option>
                                <option value="Orchid 3">Orchid 3</option>
				<option value="Lavender 1">Lavender 1</option>
				<option value="Lavender 2">Lavender 2</option>
				<option value="Dandelion 1">Dandelion 1</option>	
				<option value="Dandelion 2">Dandelion 2</option>
				<option value="Magnolia 1">Magnolia 1</option>
				<option value="Magnolia 2">Magnolia 2</option>
				<option value="Lotus 1">Lotus 1</option>
				<option value="Lotus 2">Lotus 2</option>
				<option value="Lotus 3">Lotus 3</option>
                              </select>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-success">Accept Booking</a>
                            </div>
                        </div>
                      </div>
                    </div>
                  </form>

                    <form action="/booking/cancel/{{$booking->id}}" method="get">
                    <div class="modal fade" id="modalCancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Reject Booking</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                            <div class="modal-body">

                              <label for="pesan" class="col-form-label" style="float: left;">Message:</label>
                              <textarea name="pesan" class="form-control" id="pesan" placeholder="Message why this booking was rejected" required></textarea>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-danger">Reject Booking</a>
                            </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
</script>
@endsection
