@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <a class="btn btn-outline-dark" href="/teraphis">Back To list</a><br><br>
            <div class="card card-shadow">
                <div class="card-header">
                    <h4>New Therapist</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['url' => 'teraphis', 'method' => 'POST']) !!}
                    {{ Form::token() }}
                    <br>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name="nama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Fill in the therapist's name" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="selectHari">Day Off</label><br>

                        <select id="selectTime" class="form-control" name="libur">
                            <option selected="selected" value="Senin">Monday</option>
                            <option value="Selasa">Tuesday</option>
                            <option value="Rabu">Wednesday</option>
                            <option value="Kamis">Thursday</option>
                        </select>
                    </div>

                    <div class="form-group">
                      <label>Specialist</label><br>
                      <span class="invalid text-danger lead" style="display:none">Check one</span>
                      @foreach($products as $product)
                      <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" name="spesialis[]" class="priduct-checked custom-control-input" id="{{ $product->name }}" value="{{ $product->name }}">
                        <label class="custom-control-label" for="{{ $product->name }}">{{ $product->name }}</label>
                      </div>
                      @endforeach
                      <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" name="spesialis[]" class="priduct-checked custom-control-input" id="Other" value="Other">
                        <label class="custom-control-label" for="Other">Other</label>
                      </div>

                    </div>

                    <div>
                        <div class="text-center">
                            <button type="submit" class="btn-submit btn btn-warning" onclick="return validate()">Save</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')

<script>


    var submit = document.getElementsByClassName("btn-submit");
    submit.onclick = function(){
        validate();
    }

    function validate(){
        var valid = document.getElementsByClassName("priduct-checked");
        // console.log(checked[0].checked);
        var status = "";
        for (var i = 0; i < valid.length; i++) {
            status += document.getElementsByClassName("priduct-checked")[i].checked;
            // console.log(status);
            // if(document.getElementsByClassName("priduct-checked")[i].checked){
            //     alert("sudah terpilih");
            //     return true;
            // }else{
            //     alert("tidak ada yang dipilih");
            //     return false;
            // }
        }
        if(status.includes('true')){
            return true;
        }else{
            document.getElementsByClassName('invalid')[0].style.display = "block";
            return false;
        }
    }

</script>
@endsection
