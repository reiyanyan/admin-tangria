@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <a class="btn btn-outline-dark" href="/booking/">Back To list</a><br><br>
            <div class="card">
                <div class="card-header">
                    <div class="float-md-right">
                        @if ($booking->status == "pending")
                            <a href="#" class="btn btn-outline-warning" style="cursor:default;">
                                Pending
                            </a>
                        @elseif($booking->status == "diterima")
                            <a href="#" class="btn btn-outline-success" style="cursor:default;">
                                Diterima
                            </a>
                        @else
                            <a href="#" class="btn btn-outline-danger" style="cursor:default;">
                                Cancel
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
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
                            <label for="exampleInputEmail1">Teraphis</label>
                            <input type="text" readonly class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ infoTeraphis($booking->order)->nama }}">
                        <br>
                        <label for="ruangan">Ruangan</label>
                          <input type="text" readonly class="form-control" id="ruangan" aria-describedby="emailHelp"
                          value="{{ $booking->room }}">
                          <br>
                        <label for="code">Kode</label>
                          <input type="text" readonly class="form-control" id="code" aria-describedby="emailHelp"
                           value="{{ $booking->code }}">
                        </div>
                            <p align="center" class="text-black-50">Pembookingan telah diterima</p>
                        @elseif($booking->status == "cancel")
                        <div class="form-group">
                          <label for="pesan">Pesan</label>
                          <input type="text" readonly class="form-control" id="pesan" aria-describedby="emailHelp"
                            value="{{ $booking->message }}">
                        </div>
                        <p align="center" class="text-red-50">Pembookingan telah dibatalkan</p>
                        @else
                        <center>
                            <a class="btn btn-outline-danger" data-toggle="modal" data-target="#modalCancel">Batalkan</a>
                            <a class="btn btn-outline-success" @if($teraphis->isNotEmpty()) data-toggle="modal" data-target="#modalDone" @endif >Diterima</a>
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
                              <label for="selectRoom">Ruangan</label>
                              <select id="selectRoom" class="form-control" name="room">
                                <option selected="selected" value="Lavender 1">Lavender 1</option>
                                <option value="Lavender 2">Lavender 2</option>
                                <option value="Magnolia 1">Magnolia 1</option>
                                <option value="Magnolia 2">Magnolia 2</option>
                                <option value="Dendalion 1">Dendalion 1</option>
                                <option value="Dendalion 2">Dendalion 2</option>
                                <option value="Desk 1">Desk 1</option>
                                <option value="Desk 2">Desk 2</option>
                                <option value="Desk 3">Desk 3</option>
                                <option value="Salon 1">Salon 1</option>
                                <option value="Salon 2">Salon 2</option>
                                <option value="Chair 1">Chair 1</option>
                                <option value="Chair 2">Chair 2</option>
                                <option value="Chair 3">Chair 3</option>
                                <option value="Chair 4">Chair 4</option>
                              </select>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-success">Terima Booking</a>
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
                            <h5 class="modal-title" id="exampleModalLongTitle">Hapus Booking</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                            <div class="modal-body">

                              <label for="pesan" class="col-form-label" style="float: left;">Pesan:</label>
                              <textarea name="pesan" class="form-control" id="pesan" placeholder="Pesan kenapa pesanan dibatalkan" required></textarea>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-danger">Cancel Booking</a>
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
