@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="user-tab" data-toggle="pill" href="#users-tab" role="tab"
                        aria-controls="users-tab" aria-selected="true" onclick="localStorage.setItem('j', 1);">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="booking-tab" data-toggle="pill" href="#bookings-tab" role="tab"
                        aria-controls="bookings-tab" aria-selected="false" onclick="localStorage.setItem('j', 2);">Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/date">Set the Schedule</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/product">Product Management</a>
                </li>
            @if(getRole() == 2)
                <li class="nav-item">
                    <a class="nav-link" href="/price">Price Management</a>
                </li>
            @endif
                <li>
                    <a class="nav-link" href="/teraphis">Employee Management</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade show active" id="users-tab" role="tabpanel" aria-labelledby="users-tab">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card card-shadow">
                        <div class="card-header">
                            <h1>User Management</h1>
                        </div>
                        <div class="card-body" class="">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" id="customer-tab" href="#customers-tab"
                                        role="tab" aria-controls="customers-tab" aria-selected="true"  onclick="localStorage.setItem('i', 1);">Customers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="blocked-tab" data-toggle="pill" href="#blocks-tab" role="tab"
                                        aria-controls="blocks-tab" aria-selected="false"  onclick="localStorage.setItem('i', 2);">Blocked</a>
                                </li>
                            </ul>
                            <br>
                            <div class="tab-content">

                                {{-- Customer --}}
                                <div class="tab-pane show active" id="customers-tab" role="tabpanel" aria-labelledby="customers-tab">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">E-mail</th>
                                                <th scope="col">Phone</th>
                                                {{-- <th scope="col">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer as $key => $user)
                                            <tr @if($user->created_at->format('Y-m-d') == date('Y-m-d')) style="color:#44bd32;" @endif>
                                                <th scope="row">{{++$key}}</th>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{$user->phone}}</td>
                                                {{-- <td><a class="btn btn-dark" style="width:120px;" href="/user/edit/{{$user->id}}">Info</a></td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Blocked --}}
                                <div class="tab-pane" id="blocks-tab">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="10%">#</th>
                                                <th scope="col" width="30%">Name</th>
                                                <th scope="col" width="30%">E-mail</th>
						                                    <th scope="col" width="30%">Phone</th>
                                                {{--<th scope="col" width="30%">Action</th>--}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($blocks as $key => $block)
                                            <tr @if($block->created_at->format('Y-m-d') == date('Y-m-d')) style="color:#44bd32;" @endif>
                                                <th scope="row">{{ ++$key }}</th>
                                                <td>{{ $block->name }}</td>
                                                <td>{{ $block->email }}</td>
						                                    <td>{{ $block->phone }}</td>
                                                {{-- <td><a class="btn btn-dark" style="width:120px;" href="/user/edit/{{$block->id}}">Info</a></td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if(getRole() === 2)
                            <a style="font-weight:bold;font-size:23px;" href="/user-management">More</a>
                            @else
                            <a style="font-weight:bold;font-size:23px;" href="/user">More</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="bookings-tab" role="tabpanel" aria-labelledby="bookings-tab">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="card card-shadow">
                        <div class="card-header">
                            <h1>Booking Management</h1>
                        </div>
                        <div class="card-body" class="">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">name</th>
                                        <th scope="col">order</th>
                                        <th scope="col">date</th>
                                        <th scope="col">status</th>
                                        <th scope="col">room</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php setlocale(LC_TIME, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID'); ?>
                                    {{-- {{ $bookings }} --}}
                                    @foreach ($bookings as $key => $booking)
                                    <tr @if($booking->created_at->format('Y-m-d') == date('Y-m-d'))
                                        style="color:#18dcff;" @elseif($booking->status == "cancel")
                                        style="color:#e84118" @endif>
                                        <th scope="row">{{++$key}}</th>
                                        <td>{{ DB::table('users')->where('id',$booking->user_id)->first()->name }}</td>
                                        <td>{{infoProduct($booking->order)->name}}</td>
                                        <td>{{ strftime("%A, %B %d %Y. %H:%M", strtotime($booking->date))}}</td>
                                        <td>{{$booking->status}}</td>
                                        <td>{{$booking->room}}</td>
                                        <td><a class="btn btn-dark" style="width:120px;" href="/booking/{{$booking->id}}">Info</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a style="font-weight:bold;font-size:23px;" href="/booking">More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <br>
</div>
@endsection

@section('javascript')
<script>

    var k = localStorage.getItem("j");
    if (k == 2){
        document.getElementById("bookings-tab").classList.add('show', 'active');
        document.getElementById("booking-tab").classList.add('active');
        document.getElementById("users-tab").classList.remove('show', 'active');
        document.getElementById("user-tab").classList.remove('active');
    }

    var v = localStorage.getItem("i");
    if (v == 2){
        document.getElementById("blocks-tab").classList.add('show', 'active');
        document.getElementById("blocked-tab").classList.add('active');
        document.getElementById("customers-tab").classList.remove('show', 'active');
        document.getElementById("customer-tab").classList.remove('active');
    }
</script>
@endsection
