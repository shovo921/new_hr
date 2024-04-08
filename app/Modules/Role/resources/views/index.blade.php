@extends('layouts.app')
@include('layouts.menu')
@section('breadcrumb')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Role List</span>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="pull-right">
            <i class="icon-calendar"></i>&nbsp;
            <span class="thin uppercase hidden-xs">{{ date('D, M d, Y') }}</span>&nbsp;
        </div>
    </div>
</div>
<!-- END PAGE BAR -->
@stop

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Roles - {{$roles->count()}} </h6>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create">Create Role</button>
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
                                        <th style="width: 200px">Name</th>
                                        <th>Permissions</th>
                                        <th style="width: 200px">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if($roles->count()>0)
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>{{$role->name ?? ''}}</td>
                                        
                                        <td>
                                         @if($role->permissions)
                                         @foreach($role->permissions as $permission)
                                         <span class="label label-success mb-1" style="display:inline-block;">{{$permission->name ?? ''}}</span>
                                         @endforeach
                                         @endif
                                     </td>

                                     <td>
                                         <button type="button" class="btn btn-circle btn-sm btn-primary  pull-left" data-toggle="modal" data-target="#edit_{{$role->id}}"><i class="fa fa-pencil"></i> Edit</button>

                                         @include('Role::edit')

                                         <form class="delete_item_form" accept-charset="UTF-8" action="role/{{ $role->id }}" method="POST"> 
                                            {!! csrf_field() !!} 
                                            <input type="hidden" value="DELETE" name="_method"><button class="btn btn-circle btn-sm red pull-left" type="submit"><i class="fa fa-trash-o"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@include('Role::create')
@endsection
@section('script')
<script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
@endsection