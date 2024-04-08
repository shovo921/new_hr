<!DOCTYPE html>

<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
	<meta charset="utf-8" />
	<title>{{ config('app.name', 'Laravel') }}</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="{{  asset('assets/layouts/layout/css/layout_fonts.css')   }}" rel="stylesheet" type="text/css" />
	<link href="{{  asset('assets/global/plugins/font-awesome/css/font-awesome.min.css')   }}" rel="stylesheet" type="text/css" />
	<link href="{{  asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')   }}" rel="stylesheet" type="text/css" />
	<link href="{{  asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')   }}" rel="stylesheet" type="text/css" />
	<link href="{{  asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')   }}" rel="stylesheet" type="text/css" />
	<!-- END GLOBAL MANDATORY STYLES -->

	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<link href="{{  asset('assets/global/plugins/select2/css/select2.min.css')   }}" rel="stylesheet" type="text/css" />
	<link href="{{  asset('assets/global/plugins/select2/css/select2-bootstrap.min.css')   }}" rel="stylesheet" type="text/css" />
	<!-- END PAGE LEVEL PLUGINS -->
	
	<!-- BEGIN THEME GLOBAL STYLES -->
	<link href="{{  asset('assets/global/css/components.min.css')   }}" rel="stylesheet" type="text/css" />
	<link href="{{  asset('assets/global/css/plugins.min.css')   }}" rel="stylesheet" type="text/css" />
	<!-- END THEME GLOBAL STYLES -->
	
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="{{  asset('assets/pages/css/login-3.css')   }}" rel="stylesheet" type="text/css" />
	<!-- END PAGE LEVEL STYLES -->

	<!-- BEGIN THEME LAYOUT STYLES -->
	<!-- END THEME LAYOUT STYLES -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
	<!-- BEGIN LOGO -->
	<div class="logo">
		<a href="{{ url('/') }}">
			<img src="{{{ asset('assets/layouts/layout/img/logo_login.png') }}}" alt="" />
		</a>
	</div>
	<!-- BEGIN LOGIN -->
	
	<div class="content">
		@yield('content')
	</div>
	<!-- END LOGIN -->

	<!-- BEGIN COPYRIGHT -->
	<div class="copyright hide">
		{{ date("Y") }} &copy; Padma Bank PLC.
	</div>
	<!-- END COPYRIGHT -->


	<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{  asset('assets/global/plugins/respond.min.js') }}" type="text/javascript"></script>
<script src="{{  asset('assets/global/plugins/excanvas.min.js') }}" type="text/javascript"></script>
<![endif]-->

<!-- BEGIN CORE PLUGINS -->
<script src="{{  asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{  asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{  asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{  asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{  asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{  asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{  asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{  asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{  asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{  asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{  asset('assets/pages/scripts/login.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->

@yield('script')

</body>
<!-- END BODY -->
</html>