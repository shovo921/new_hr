@extends('layouts.login')

@section('content')
{{Form::open(['route'=>'login','method'=>'post', 'class'=>'login-form'])}}
<h2 class="form-title">HR Management</h2>
<h3 class="form-title">Login to your account</h3>
<div class="form-title">
    <span class="form-title">Welcome.</span>
    <span class="form-subtitle">Please login.</span>
</div>

<div class="row">
    <div class="col-md-12">
        @foreach($errors->all() as $error)
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span> {{ $error }} </span>
        </div>
        @endforeach

        @if(Session::has('auth-error'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('auth-error') !!}
        </div>
        @endif
    </div>
</div>


<div class="form-group">
    <label class="control-label mb-10" for="exampleInputEmail_2">Employee ID</label>
    {{Form::text('employee_id',null,['required', 'class' => 'form-control', 'autocomplete' => 'employee_id', 'autofocus', 'tabindex'=>'1'])}}
    @error('employee_id')
    <span style="color: red">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="form-group">
    <label class="pull-left control-label mb-10" for="exampleInputpwd_2">Password</label>

    {{--<a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="{{ route('forget-password') }}">forgot password ?</a>--}}

    <div class="clearfix"></div>
    {{Form::password('password',['required','class'=>'form-control', 'tabindex'=>'2'])}}
</div>
<div class="form-group text-center">
    <button type="submit" class="btn btn-info btn-success btn-rounded">sign in</button>
</div>
{{Form::close()}}

@endsection

@section('script')
<script src="{{asset('js/show-hide-sweet-alert.js')}}"></script>
<script>
    @if(session('success'))
    showBasicSweetAlert('success', '{{ session('success')}}')
    @endif

    @if($errors->any())
    <?php $html = '';?>
    @foreach ($errors->all() as $error)
    <?php $html .= $error . '. ';?>
    @endforeach
    showBasicSweetAlert('error', '{!! $html !!}')
    @endif
</script>
@endsection
