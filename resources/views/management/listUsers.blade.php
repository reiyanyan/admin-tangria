@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-8 mb-3">
        <div class="row">
            <div class="col">
                <a class="btn btn-outline-dark" href="/home/">Back to Home</a>
            </div>
            <div class="col">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-dark filter-default active" onclick="showAll()">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> All
                    </label>
                    <label class="btn btn-outline-dark filter-pelanggan" onclick="showPelanggan()">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> Customer
                    </label>
                    <label class="btn btn-outline-dark filter-pegawai" onclick="showPegawai()">
                        <input type="radio" name="options" id="option2" autocomplete="off"> Employee
                    </label>
                    <label class="btn btn-outline-dark filter-block" onclick="showBlock()">
                        <input type="radio" name="options" id="option3" autocomplete="off"> Blocked
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-8 mb-3 mt-2">
        <div class="row">
            <div class="col-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend"><span id="basic-addon1" class="input-group-text">search</span></div>
                    <input type="text" id="nameSearch" placeholder="search user..." aria-label="Username"
                        aria-describedby="basic-addon1" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-8">
        <div class="card card-shadow">
            <table class="table" style="margin-bottom:0px;">
                <thead>
                    <tr>
                        <th scope="col">Avatar</th>
                        <th scope="col">Name</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Status</th>
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody class="tbody-ori">
                    @foreach ($users as $key => $user)
                    <tr class="user-{{ $user->role }}">
                        <td scope="col"><img src="/img/avatar/{{$user->avatar}}" width="50" class="img-thumbnail" alt=""></td>
                        <td scope="col">{{$user->name}}</td>
                        <td scope="col">{{$user->email}}</td>
                        <td scope="col">{{$user->phone}}</td>
                        <td scope="col">
                            @if($user->role===1)
                            Customer
                            @elseif($user->role===3)
                            Employee
                            @elseif($user->role===0)
                            Blocked
                            @endif()
                        </td>
                        <td scope="col">
                            <button type="button" class="btn btn-warning" data-toggle="modal" onclick="getUserData({{$user->id}})"
                                data-target="#exampleModalLong">
                                edit
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tbody class="tbody-search" style="display:none">
                </tbody>
            </table>
            <div class="paginate mr-5 ml-5 mt-3">{{$users->links()}}</div>
        </div>
    </div>
</div>

<!-- modal -->

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center>
                    <div class="modal-edit-body">
                    </div>
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="editForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        document.getElementById("nameSearch").addEventListener("keydown", searchUser);
        var processSearching = 0;

        function searchUser(e) {
            if (document.getElementById("nameSearch").value == 0) {
                $(".paginate").css('display', 'block');
                $(".tbody-ori").css('display', 'table-row-group');
                $(".tbody-search").css('display', 'none');
                $(".tbody-search").empty();
                $(".filter-default").addClass('active');
                $(".filter-pegawai").removeClass('active');
                $(".filter-block").removeClass('active');
                $(".filter-pelanggan").removeClass('active');
                showAll();
                processSearching = 0;
            } else if (e.keyCode == 13) {
                $(".tbody-ori").css('display', 'none');
                $(".paginate").css('display', 'block');
                $(".tbody-search").css('display', 'table-row-group');
                $(".tbody-search").empty();
                processSearching = 0;
                if (document.getElementById("nameSearch").value.length == 0) {
                    $(".tbody-ori").css('display', 'table-row-group');
                    $(".tbody-search").css('display', 'none');
                    $(".tbody-search").empty();
                    $(".paginate").css('display', 'block');
                    showAll();
                    processSearching = 0;
                } else {
                    processSearching = 1;
                    if (processSearching == 1) {
                        $(".paginate").css('display', 'none');
                        $(".tbody-ori").css('display', 'none');
                        $(".tbody-search").css('display', 'table-row-group');
                        $(".tbody-search").empty();
                        $(".filter-default").addClass('active');
                        $(".filter-pegawai").removeClass('active');
                        $(".filter-block").removeClass('active');
                        $(".filter-pelanggan").removeClass('active');
                        showAll();
                        var someUrl = "/search/users/" + document.getElementById("nameSearch").value;
                        $.ajax({
                            type: "GET",
                            url: someUrl,
                            success: function (data) {
                                $.each(data, function (index, element) {
                                    if (element.avatar != null && element.avatar.substr(0,
                                            4) != "http") {
                                        imageCheck =
                                            '<td><img class="img-thumbnail" width="70" src="/img/avatar/' +
                                            element.avatar + '" ></td>';
                                    } else {
                                        imageCheck =
                                            '<td><img class="img-thumbnail" width="70" src="' +
                                            element.avatar + '" ></td>';
                                    }
                                    var role = 'block';
                                    if (element.role == 0) {
                                        role = 'block';
                                    } else if (element.role == 1) {
                                        role = 'customer';
                                    } else if (element.role == 3) {
                                        role = 'employee';
                                    }
                                    var html =
                                        `
                                            <tr class="user-` +
                                        element.role +
                                        `">
                                                ` +
                                        imageCheck +
                                        `
                                                <td scope="col">` +
                                        element.name +
                                        `</td>
                                                <td scope="col">` +
                                        element.email +
                                        `</td>
                                                <td scope="col">` +
                                        element.phone +
                                        `</td>
                                                <td scope="col">` +
                                        role +
                                        `</td>
                                                <td scope="col">
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" onclick="getUserData(` +
                                        element.id +
                                        `)" data-target="#exampleModalLong">
                                                        edit
                                                    </button>
                                                </td>
                                            </tr>
                                    `
                                    $('.tbody-search').append(html);
                                });
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alert(errorThrown);
                            },
                            dataType: "json"
                        });
                    }
                }
            }
        }
    });

    function showAll() {
        var ele = document.getElementsByClassName('user-1');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "table-row";
        }
        ele = document.getElementsByClassName('user-0');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "table-row";
        }
        ele = document.getElementsByClassName('user-3');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "table-row";
        }
    }

    function showPegawai() {
        var ele = document.getElementsByClassName('user-1');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "none";
        }
        ele = document.getElementsByClassName('user-0');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "none";
        }
        ele = document.getElementsByClassName('user-3');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "table-row";
        }
    }

    function showBlock() {
        var ele = document.getElementsByClassName('user-1');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "none";
        }
        ele = document.getElementsByClassName('user-3');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "none";
        }
        ele = document.getElementsByClassName('user-0');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "table-row";
        }
    }

    function showPelanggan() {
        var ele = document.getElementsByClassName('user-0');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "none";
        }
        ele = document.getElementsByClassName('user-3');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "none";
        }
        ele = document.getElementsByClassName('user-1');
        for (var i = 0; i < ele.length; i++) {
            ele[i].style.display = "table-row";
        }
    }

    function getUserData(id) {
        $('.modal-edit-body').empty();
        var someUrl = "/data/user/" + id;
        var roleOption = '';
        $.ajax({
            type: "GET",
            url: someUrl,
            success: function (data) {
                if (data.avatar != null && data.avatar.substr(0, 4) != "http") {
                    imageCheck = '<center><img class="img-thumbnail mb-3" width="280" src="/img/avatar/' +
                        data.avatar + '"></center>';
                } else {
                    imageCheck = '<center><img class="img-thumbnail mb-3" width="280" src="' + data.avatar +
                        '"></center>';
                }
                if (data.role == 3) {
                    roleOption =
                        `
                        <option disabled>Status...</option>
                        <option value="1">Customer</option>
                        <option value="3" selected="selected">Employee</option>
                        <option value="0">Block</option>
                    `
                } else if (data.role == 1) {
                    roleOption =
                        `
                        <option disabled>Status...</option>
                        <option value="1" selected="selected">Customer</option>
                        <option value="3">Employee</option>
                        <option value="0">Block</option>
                    `
                } else if (data.role == 0) {
                    roleOption =
                        `
                        <option disabled>Status...</option>
                        <option value="1">Customer</option>
                        <option value="3">Employee</option>
                        <option value="0" selected="selected">Block</option>
                    `
                } else {
                    roleOption =
                        `
                        <option disabled selected="selected">Status...</option>
                        <option value="1">Customer</option>
                        <option value="3">Employee</option>
                        <option value="0">Block</option>
                    `
                }
                var html =
                    `
                {!! Form::open(['url' => 'save/user','id' => 'editForm', 'method' => 'POST', 'files' => true]) !!}
                {{ Form::token() }}
                    <input type="hidden" value="` +
                    data.id + `" name="id">
                    ` + imageCheck +
                    `
                    <div class="input-group mb-3">
                        <input type="file" name="avatar">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Status</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01" value="` +
                    data.role + `" name="role">
                            ` + roleOption +
                    `
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="staticEmail" value="` +
                    data.name +
                    `" name="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="staticEmail" value="` +
                    data.email +
                    `" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="staticEmail" value="` +
                    data.phone +
                    `" name="phone">
                        </div>
                    </div>
                    <a class="btn btn-outline-danger btn-md" href="/ubah-password/` +
                    data.id +
                    `"><b>Change Password?</b></a>
                    {!! Form::close() !!}
                `;
                $('.modal-edit-body').append(html);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json"
        });
    }

</script>
@endsection
