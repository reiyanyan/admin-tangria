@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<div class="container">

    <div class="row justify-content-center">
        <div class="col">
            <a class="btn btn-outline-dark" href="/home/">Back to Home</a><br><br>
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="customer-tab" data-toggle="pill" href="#customers-tab" role="tab" aria-controls="customers-tab" aria-selected="true" onclick="localStorage.setItem('i', 1);">Customer</a>
                </li>
                @if(getRole()==2)
                <li class="nav-item">
                    <a class="nav-link" id="cashier-tab" data-toggle="pill" href="#cashiers-tab" role="tab" aria-controls="cashiers-tab" aria-selected="false" onclick="localStorage.setItem('i', 3);">Cashiers</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" id="blocked-tab" data-toggle="pill" href="#blocks-tab" role="tab" aria-controls="blocks-tab" aria-selected="false" onclick="localStorage.setItem('i', 2);">Blocked</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">

        {{-- Tab Customers --}}
        <div class="tab-pane fade show active" id="customers-tab" role="tabpanel" aria-labelledby="customer-tab">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card card-shadow">
                        <div class="card-header">
                            <h1 style="display:inline-block;">Customers</h1>
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">search</span>
                                </div>
                                <input type="text" class="form-control" id="nameSearch" placeholder="search user..." aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            <table class="table" id="tableOri">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Avatar</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                    <tr @if($user->created_at->format('Y-m-d') == date('Y-m-d')) style="color: #44bd32;" @endif>
                                        <th scope="row">{{++$key}}</th>
                                        <td>
                                        @if (substr($user->avatar, 0, 4)!="http")
                                        <img class="img-thumbnail" width="50" src="/img/avatar/{{ $user->avatar }}" alt="">
                                        @else
                                        <img class="img-thumbnail" width="50" src="{{ $user->avatar }}" alt="">
                                        @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <a href="/user/edit/{{$user->id}}" class="btn btn-dark">edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table" id="tableSearch" style="display:none">
                                <thead>
                                    <tr>
                                        <th scope="col">Avatar</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="search-tbody">

                                </tbody>
                            </table>
                        </div>
                        </div>
                        <br>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        @if(getRole()==2)
        {{-- Tab Cashiers --}}
        <div class="tab-pane fade" id="cashiers-tab" role="tabpanel" aria-labelledby="cashiers-tab">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card card-shadow">
                        <div class="card-header">
                            <h1 style="display:inline-block;">Cashiers</h1>
                        </div>
                        <div class="card-body">
                            <table class="table" id="tableOri">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Avatar</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cashiers as $key => $cashier)
                                        <tr @if($cashier->created_at->format('Y-m-d') == date('Y-m-d')) style="color: #44bd32;" @endif>
                                            <th scope="row">{{++$key}}</th>
                                            <td>
                                            @if (substr($cashier->avatar, 0, 4)!="http")
                                            <img class="img-thumbnail" width="50" src="/img/avatar/{{ $cashier->avatar }}" alt="">
                                            @else
                                            <img class="img-thumbnail" width="50" src="{{ $user->avatar }}" alt="">
                                            @endif
                                            </td>
                                            <td>{{ $cashier->name }}</td>
                                            <td>{{ $cashier->email }}</td>
                                            <td>{{ $cashier->phone }}</td>
                                            <td>
                                                <a href="/user/edit/{{$cashier->id}}" class="btn btn-dark">edit</a>
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
        @endif

        {{-- Tab Blocked --}}
        <div class="tab-pane fade" id="blocks-tab" role="tabpanel" aria-labelledby="blocks-tab">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card card-shadow">
                        <div class="card-header">
                            <h1 style="display:inline-block;">Blocked</h1>
                        </div>
                        <div class="card-body">
                            <table class="table" id="tableOri">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Avatar</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blocks as $key => $block)
                                        <tr @if($block->created_at->format('Y-m-d') == date('Y-m-d')) style="color: #44bd32;" @endif>
                                            <th scope="row">{{++$key}}</th>
                                            <td>
                                            @if (substr($block->avatar, 0, 4)!="http")
                                            <img class="img-thumbnail" width="50" src="/img/avatar/{{ $block->avatar }}" alt="">
                                            @else
                                            <img class="img-thumbnail" width="50" src="{{ $user->avatar }}" alt="">
                                            @endif
                                            </td>
                                            <td>{{ $block->name }}</td>
                                            <td>{{ $block->email }}</td>
                                            <td>
                                                <a href="/user/edit/{{$block->id}}" class="btn btn-dark">edit</a>
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

</div>
@endsection
@section('javascript')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
var v = localStorage.getItem("i");
if (v == 2){
    document.getElementById("blocks-tab").classList.add('show', 'active');
    document.getElementById("blocked-tab").classList.add('active');
    document.getElementById("customers-tab").classList.remove('show', 'active');
    document.getElementById("customer-tab").classList.remove('active');
    document.getElementById("cashiers-tab").classList.remove('show', 'active');
    document.getElementById("cashier-tab").classList.remove('active');
}
if (v == 3){
    document.getElementById("cashiers-tab").classList.add('show', 'active');
    document.getElementById("cashier-tab").classList.add('active');
    document.getElementById("customers-tab").classList.remove('show', 'active');
    document.getElementById("customer-tab").classList.remove('active');
    document.getElementById("blocks-tab").classList.remove('show', 'active');
    document.getElementById("blocked-tab").classList.remove('active');
}

$(document).ready(function() {
    // function checkSearch(){
    //     var tableSearch = document.getElementById("tableSearch");
    //     var tableOri = document.getElementById("tableOri");

    //     setTimeout(checkSearch, 2500);
    // }
    // checkSearch();
    document.getElementById("nameSearch").addEventListener("keypress", searchUser);
    function searchUser(e){
        var key = e.which || e.keycode;
        if(key === 13){
            var tableSearch = document.getElementById("tableSearch");
            var tableOri = document.getElementById("tableOri");
            $( "#search-tbody" ).empty();
            if(document.getElementById("nameSearch").value.length == 0){
                tableOri.style.display = "";
                tableSearch.style.display = "none";
                $('.pagination').css('display','');
            }else{
                tableOri.style.display = "none";
                tableSearch.style.display = "";
                $('.pagination').css('display','none');
                var someUrl = "/api/search/"+document.getElementById("nameSearch").value;
                $.ajax({
                    type:"GET",
                    url: someUrl,
                    success: function(data) {
                        $.each(data, function(index, element) {
                            if(element.avatar != null && element.avatar.substr(0, 4) != "http"){
                                imageCheck = '<td><img class="img-thumbnail" width="70" src="/img/avatar/'+ element.avatar +'" ></td>';
                            }else{
                                imageCheck = '<td><img class="img-thumbnail" width="70" src="'+ element.avatar +'" ></td>';
                            }
                            var html = '<tr>'+imageCheck+'<td>'+ element.name +'</td><td>'+ element.email +'</td><td><a href="/user/edit/'+ element.id +'" class="btn btn-dark">edit</a></td></tr>'
                            $('#search-tbody').append(html);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                    },
                    dataType: "json"
                });
            }
        }
    }
});
</script>
@endsection
