@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Settings</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    @if (Lang::has('Settings::example.welcome'))
                    {{ trans('Settings::example.welcome') }}
                    @else
                    Welcome, this is Site Settings.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('Branch::create')
@endsection
@push('scripts')

<script>
    $(document).ready(function () {
        highlight_nav('branch_management', 'branch_management');
    });

</script>
@endpush

