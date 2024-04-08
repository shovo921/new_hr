@extends('layouts.app')

@section('content')
<!--<div class="row heading-bg">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h5 class="txt-dark">System Users</h5>
    </div>
     Breadcrumb
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#"><span>speciality pages</span></a></li>
            <li class="active"><span>blank page</span></li>
        </ol>
    </div>
     /Breadcrumb
</div>-->


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Filter </h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap">
                        {{Form::open(['route'=>'system-users.index','method'=>'get'])}}
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            {{Form::text('name',request('name'),['class'=>'form-control','placeholder'=>'Name'])}}
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            {{Form::text('mobile_no',request('mobile_no'),['class'=>'form-control','placeholder'=>'Mobile No'])}}
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            {{Form::text('email',request('email'),['class'=>'form-control','placeholder'=>'Email'])}}
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <a href="{{route('system-users.index')}}" class="btn btn-sm btn-danger">Clear</a>
                            <button type="submit" class="btn btn-sm btn-success">
                                <span class="btn-text">submit</span>
                            </button>

                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">System Users - {{$users->count()}} </h6>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create">Create User</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Mobile No.</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if($users->count()>0)
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name ?? ''}}</td>
                                        <td>{{$user->mobile_no ?? ''}}</td>
                                        <td>{{$user->email ?? ''}}</td>

                                        <td>
                                            @if($user->getRoleNames()->count())
                                            <span class="label label-success"> {{$user->getRoleNames()[0]}} </span>
                                            @endif
                                        </td>
                                        <td>{{$user->created_at ?? ''}}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit_{{$user->id}}">Edit</button>

                                            @include('User::system.edit')

                                             <button class="btn btn-sm btn-danger" onclick="showConfirmSweetAlert('delete-form-{{$user->id}}')">Delete</button>
                                            {{Form::model($user,['route'=>['system-users.destroy',$user->id],'method'=>'delete','id'=>'delete-form-'.$user->id,'name'=>'delete-form-'.$user->id])}}

                                            {{Form::close()}}


                                        </td>

                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                            </table>

                            @if($users->count()>0)
                            {{$users->appends($_REQUEST)->render()}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('User::system.create')
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $("#Password").keyup(function(){
                if($("#ConfirmPassword").val() !== '') {
                    if ($("#Password").val() != $("#ConfirmPassword").val()) {
                        $("#msg").html("Password do not match").css("color", "red");
                    } else {
                        $("#msg").html("Password matched").css("color", "green");
                    }
                } else {
                    $("#msg").empty();
                }
            });
            $("#ConfirmPassword").keyup(function(){
                if($("#Password").val() !== '') {
                    if ($("#Password").val() != $("#ConfirmPassword").val()) {
                        $("#msg").html("Password do not match").css("color", "red");
                    } else {
                        $("#msg").html("Password matched").css("color", "green");
                    }
                }else {
                    $("#msg").empty();
                }
            });
        });
    </script>
<script>

    $(document).ready(function () {
        highlight_nav('user_management', 'system_users');

    });

</script>
@endpush

