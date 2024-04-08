<!DOCTYPE html>

<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <link rel="icon" type="image/png" href="{{asset('assets/layouts/layout/img/logo.png')}}">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ asset('assets/layouts/layout/css/layout_fonts.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('assets/global/css/components.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ asset('assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/layouts/layout/css/themes/blue.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    @yield('css')
</head>
<!-- END HEAD -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <div class="page-wrapper">
         @yield('header')

        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            @yield('menu')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    @yield('breadcrumb')
                    <!-- END PAGE HEADER-->

                    <!-- ALERT-->
                    <div class="row">
                        <div class="col-md-12">
                            @if(Session::has('msg-success'))
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {!! Session::get('msg-success') !!}
                            </div>
                            @elseif(Session::has('msg-error'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {!! Session::get('msg-error') !!}
                            </div>
                            @elseif(Session::has('msg-info'))
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {!! Session::get('msg-info') !!}
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- END ALERT-->

                    <!-- BEGIN CONTENT BODY -->
                    @yield('content')
                    <!-- END CONTENT BODY -->
                </div>
            </div>
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner"> {{ date('Y') }} &copy; 
                    <a target="_blank" style="color: #c9dae9" href="https://www.padmabankbd.com/">Padma Bank PLC.</a>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>

                <div >
                    <a target="_blank" style="color: #c9dae9;float:right !important;text-align: right !important ;">Design & Developed By Padma Bank ICT Division</a>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
    </div>
    <!--[if lt IE 9]>
    <script src="{{  asset('assets/global/plugins/respond.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/excanvas.min.js') }}" type="text/javascript"></script>
    <![endif]-->

    <!-- BEGIN CORE PLUGINS -->
    <script type="text/javascript">
        var base_url = "{!! url('/') !!}";
        // alert(base_url);

        /*window.setInterval(function(){
            getAttendaceInfo();
        }, 6000);//600000*/
    </script>
    <script src="{{  asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{  asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    
    <script src="{{  asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/jquery-loading/loadingoverlay.min.js') }}" type="text/javascript"></script>

    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{  asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/pages/scripts/table-datatables-responsive.min.js') }}" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{  asset('assets/pages/scripts/form-wizard.min.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="{{  asset('assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
    <script src="{{  asset('assets/my_scripts/custom.js') }}" type="text/javascript"></script>
    @yield('script')
</body>
</html>