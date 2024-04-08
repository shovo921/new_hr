@section('header')
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/layouts/layout/img/logo.png') }}" alt="" height="40" width="80"
                         class="logo-default"/>
                </a>
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <!-- END LOGO -->
            <div class="pull-left" style="margin-top: -10px;">
                <h3>HR Management System</h3>
            </div>
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
               data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->

            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle" src="{{ asset('assets/layouts/layout/img/avatar.png')}}"/>
                            <span class="username username-hide-on-mobile">
                            {{ (@Auth::user()->NAME) ? @Auth::user()->NAME:'' }}
                        </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{ url('/profile') }}">
                                    <i class="icon-user"></i> Change Password
                                </a>
                            </li>
                            {{-- <li>
                                 <a href="{{ url('changePassword') }}">
                                     <i class="icon-key"></i> Change Password
                                 </a>
                             </li>--}}
                            <li class="divider"></li>
                            <!-- <li>
                            <a href="{{ url('/') }}">
                                <i class="icon-lock"></i> Terms & Conditions
                            </a>
                        </li> -->
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="icon-key"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->

    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"></div>
    <!-- END HEADER & CONTENT DIVIDER -->

@stop

<?php
if (!isset($_SESSION['MenuActive'])) {
    $_SESSION["MenuActive"] = "dashboard";
}

if (!isset($_SESSION['SubMenuActive'])) {
    $_SESSION["SubMenuActive"] = "";
}
?>

@section('menu')
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
                data-slide-speed="200" style="padding-top: 20px">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <li class="sidebar-toggler-wrapper hide">
                    <div class="sidebar-toggler">
                        <span></span>
                    </div>
                </li>
                @if ((auth()->user()->password_changed_at != null))
                    @if (in_array(auth()->user()->role_id,['1']))
                        <li class="nav-item start {{ $_SESSION["MenuActive"] == 'dashboard' ? 'active open' : "" }}">
                            <a href="{{ url('/') }}" class="nav-link">
                                <i class="icon-bar-chart"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'settings' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i><span class="title">SETTINGS</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'division' ? 'active':'' }}">
                                    <a href="{{ asset('/division') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Division</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'district' ? 'active':'' }}">
                                    <a href="{{ asset('/district') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage District</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'thana' ? 'active':'' }}">
                                    <a href="{{ asset('/thana') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Thana</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'designation' ? 'active':'' }}">
                                    <a href="{{ asset('/designation') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Designation</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-education' ? 'active':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                        <span class="title">Manage Employee Education</span>
                                        <span class="selected"></span><span class="arrow open"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'professional-institue' ? 'active':'' }}">
                                            <a href="{{ asset('/professional-institue') }}" class="nav-link ">
                                                <i class="fa fa-certificate" aria-hidden="true"></i>
                                                <span class="title">Training Institute</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'education-exam' ? 'active':'' }}">
                                            <a href="{{ asset('/education-exam') }}" class="nav-link ">
                                                <i class="fa fa-certificate" aria-hidden="true"></i>
                                                <span class="title">Education Exam</span>
                                            </a>
                                        </li>

                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'training-organization' ? 'active':'' }}">
                                            <a href="{{ asset('/training-organization') }}" class="nav-link ">
                                                <i class="fa fa-certificate" aria-hidden="true"></i>
                                                <span class="title">Training Organization</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'training-subject' ? 'active':'' }}">
                                            <a href="{{ asset('/training-subject') }}" class="nav-link ">
                                                <i class="fa fa-certificate" aria-hidden="true"></i>
                                                <span class="title">Training Subject</span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'branch' ? 'active':'' }}">
                                    <a href="{{ asset('/branch') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Add Branch / Division</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'br-division' ? 'active':'' }}">
                                    <a href="{{ asset('/br-division') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Branch Division</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'br-department' ? 'active':'' }}">
                                    <a href="{{ asset('/br-department') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Division Department</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'department-unit' ? 'active':'' }}">
                                    <a href="{{ asset('/department-unit') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Department Unit</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'document' ? 'active':'' }}">
                                    <a href="{{ asset('/document') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Document</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'specialization' ? 'active':'' }}">
                                    <a href="{{ asset('/specialization') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Specialization</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'tour-type' ? 'active':'' }}">
                                    <a href="{{ asset('/tour-type') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Tour Type</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'job-status' ? 'active':'' }}">
                                    <a href="{{ asset('/job-status') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Job Status</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'salary-head' ? 'active':'' }}">
                                    <a href="{{ asset('/salary-head') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Salary Head</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'salary-slave' ? 'active':'' }}">
                                    <a href="{{ asset('/salary-slave') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Salary Slab</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'salary-increment-slave' ? 'active':'' }}">
                                    <a href="{{ asset('/salary-increment-slave') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Salary Increment Slab</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'disciplinary-category' ? 'active':'' }}">
                                    <a href="{{ asset('/disciplinary-category') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Disciplinary Category</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'FunctionalDesignation' ? 'active':'' }}">
                                    <a href="{{ asset('/functional-designation') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Functional Designation</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'reporting-heads' ? 'active':'' }}">
                                    <a href="{{ asset('/reporting-heads') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Reporting Managers</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'holiday' ? 'active':'' }}">
                                    <a href="{{ asset('/holiday') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Holiday Setup</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'PasswordReset' ? 'active':'' }}">
                                    <a href="{{ asset('/PasswordReset') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">User Password Reset</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'employee' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-users"></i><span class="title">Employee</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee' ? 'active':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="icon-users"></i><span class="title">Manage Employee</span>
                                        <span class="selected"></span><span class="arrow open"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee' ? 'active':'' }}">
                                            <a href="{{ asset('/employee') }}" class="nav-link ">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                <span class="title">Add Employee</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'resignation' ? 'active':'' }}">
                                            <a href="{{ asset('/resign') }}" class="nav-link ">
                                                <i class="fa fa-ban" aria-hidden="true"></i>
                                                <span class="title">Separation</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'resignation-auth' ? 'active':'' }}">
                                            <a href="{{ asset('/resign-auth-list') }}" class="nav-link ">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                <span class="title">Separation Auth</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'resignation-auth' ? 'active':'' }}">
                                            <a href="{{ asset('/getEmpDoc') }}" class="nav-link ">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                <span class="title">Employee Document</span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                @if (auth()->user()->role_id == '1')
                                    <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'hiddenReference' ? 'active':'' }}">
                                        <a href="{{ asset('/employee-hidden-reference') }}" class="nav-link ">
                                            <i class="fa fa-retweet" aria-hidden="true"></i>
                                            <span class="title">Employee Hidden Reference</span></a>
                                    </li>
                                    <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-kpi' ? 'active':'' }}">
                                        <a href="{{ asset('/employee-kpi') }}" class="nav-link ">
                                            <i class="fa fa-trophy" aria-hidden="true"></i>
                                            <span class="title">Employee KPI</span></a>
                                    </li>
                                    <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'job-description' ? 'active':'' }}">
                                        <a href="{{ asset('/job-description') }}" class="nav-link ">
                                            <i class="fa fa-briefcase" aria-hidden="true"></i>
                                            <span class="title">Job Description</span>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()->role_id == '2')
                                    <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employeeIncrement' ? 'active':'' }}">
                                        <a href="{{ asset('/incrementAuthorization') }}" class="nav-link ">
                                            <i class="icon-list"></i>
                                            <span class="title">Salary / Increment Authorize</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employeePromotion' ? 'active':'' }}">
                                        <a href="{{ asset('/promotionAuthorization') }}" class="nav-link ">
                                            <i class="icon-list"></i>
                                            <span class="title">Promotion Authorize</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'increment' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-arrow-up"></i><span class="title">Manage Salary/Increment</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'all-salary' ? 'active':'' }}">
                                    <a href="{{ asset('/all-sal') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Salary Info</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-increment' ? 'active':'' }}">
                                    <a href="{{ asset('/employee-increment') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Salary / Increment</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'bulk-increment' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Bulk Salary / Increment</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employeeIncrement' ? 'active':'' }}">
                                    <a href="{{ asset('/incrementAuthorization') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Salary / Increment Authorize</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'salary-certificate' ? 'active':'' }}">
                                    <a href="{{ asset('/salary-certificate') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Salary Certificate</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'promotion' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-bullhorn"></i><span class="title">Manage Promotion</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-promotion' ? 'active':'' }}">
                                    <a href="{{ asset('/employee-promotion') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Promotion</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'bulk-promotion' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Bulk Promotion</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employeePromotion' ? 'active':'' }}">
                                    <a href="{{ asset('/promotionAuthorization') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Promotion Authorize</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'transfer' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-reload"></i><span class="title">Manage Transfer/Posting</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'zone' ? 'active':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="icon-users"></i><span class="title"> Manage Leave Hierarchy</span>
                                        <span class="selected"></span><span class="arrow open"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'zone' ? 'active':'' }}">
                                            <a href="{{ asset('/zone') }}" class="nav-link ">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                <span class="title">Zone Mange</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'br_bom' ? 'active':'' }}">
                                            <a href="{{ asset('/BrBom') }}" class="nav-link ">
                                                <i class="fa fa-ban" aria-hidden="true"></i>
                                                <span class="title">Br Bom Manage</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'Rm' ? 'active':'' }}">
                                            <a href="{{ asset('/Rm') }}" class="nav-link ">
                                                <i class="fa fa-ban" aria-hidden="true"></i>
                                                <span class="title">Rm Manage</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'new-transfer' ? 'active':'' }}">
                                    <a href="{{ asset('/postinglist') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Transfer/Posting</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employeePosting' ? 'active':'' }}">
                                    <a href="{{ asset('/postingAuthorization') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Transfer/Posting Authorize</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employment-log' ? 'active':'' }}">
                                    <a href="{{ asset('/employment-log') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employment Log</span>
                                    </a>
                                </li>
                            </ul>

                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'new-transfer' ? 'active':'' }}">
                                    <a href="{{ asset('/postinglist') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Transfer/Posting</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employeePosting' ? 'active':'' }}">
                                    <a href="{{ asset('/postingAuthorization') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Transfer/Posting Authorize</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employment-log' ? 'active':'' }}">
                                    <a href="{{ asset('/employment-log') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employment Log</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'disciplinary-action' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-user"></i><span class="title">Disciplinary Action</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'disciplinaryAction' ? 'active':'' }}">
                                    <a href="{{ asset('/disciplinaryAction') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Disciplinary Action</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'addDisciplinaryAction' ? 'active':'' }}">
                                    <a href="{{ asset('/disciplinaryAction/create') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Add New Disciplinary Action</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'leave' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-plane" aria-hidden="true"></i>
                                <span class="title">Leave</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-leave' ? 'active':'' }}">
                                    <a href="{{ asset('/leave') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">All Employee Leave Balance</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'all-applications' ? 'active':'' }}">
                                    <a href="{{ asset('/allApplication') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">All Leave Application</span>
                                    </a>
                                </li>

                                {{--<li class="nav-item {{ $_SESSION['SubMenuActive'] == 'leave-apply' ? 'active':'' }}">
                                    <a href="{{ asset('/leave/create') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Apply for Leave</span>
                                    </a>
                                </li>--}}

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'waiting-for' ? 'active':'' }}">
                                    <a href="{{ asset('/waiting-list-hr') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Waiting for Approval</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'leave-types' ? 'active':'' }}">
                                    <a href="{{ asset('/leave-type') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Leave Types</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'attendance' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <span class="title">Attendance</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-attendance' ? 'active':'' }}">
                                    <a href="{{ asset('/attendance') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">All Employee Attendance</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-attendance' ? 'active':'' }}">
                                    <a href="{{ asset('/today-attendance') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Today's Attendance</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'report' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                <span class="title">Report</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'all-employee' ? 'active':'' }}">
                                    <a href="{{ asset('/all-employee') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">All Employee List</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-on-leave' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee On Leave</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'branch-leave' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Branch/Division Wise Leave Report</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'without-pay-report' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Without Pay Report</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-leave-balance' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Leave Balance</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'Payroll' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span class="title">Payroll</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['MenuActive'] == 'Payroll' ? 'active open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="icon-settings"></i>
                                        <span class="title">Payroll-Settings</span>
                                        <span class="selected"></span><span class="arrow open"></span>
                                    </a>
                                    <ul class="sub-menu" {{ $_SESSION['MenuActive'] == 'Payroll' ? 'active open':'' }}>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'payroll-settings-pay' ? 'active':'' }}">
                                            <a href="{{ asset('/pay-type') }}" class="nav-link ">
                                                <i class="icon-list"></i>
                                                <span class="title">Payment Setup</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'payroll-settings-deduct' ? 'active':'' }}">
                                            <a href="{{ asset('/deduction-type') }}" class="nav-link ">
                                                <i class="icon-list"></i>
                                                <span class="title">Deduction Setup</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'payroll-settings-gl-pl' ? 'active':'' }}">
                                            <a href="{{ asset('/gl-pl') }}" class="nav-link ">
                                                <i class="icon-list"></i>
                                                <span class="title">GL-PL Setup</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ $_SESSION['MenuActive'] == 'Payroll' ? 'active open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <span class="title">Salary Info</span>
                                        <span class="selected"></span><span class="arrow open"></span>
                                    </a>

                                    <ul class="sub-menu" {{ $_SESSION['MenuActive'] == 'Payroll' ? 'active open':'' }}>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'payroll-salary-account' ? 'active':'' }}">
                                            <a href="{{ asset('/salary-account') }}" class="nav-link ">
                                                <i class="icon-list"></i>
                                                <span class="title">Salary Account Setup</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'payroll-loan' ? 'active':'' }}">
                                            <a href="{{ asset('/account-loan') }}" class="nav-link ">
                                                <i class="icon-list"></i>
                                                <span class="title">Loan Setup</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'payroll-allowance' ? 'active':'' }}">
                                            <a href="{{ asset('/allowance') }}" class="nav-link ">
                                                <i class="icon-list"></i>
                                                <span class="title">Employee Allowance</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'emp-bills' ? 'active':'' }}">
                                            <a href="{{ asset('/emp-bills') }}" class="nav-link ">
                                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                                <span class="title">Employee Bills</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'payroll-salary-account' ? 'active':'' }}">
                                            <a href="{{ asset('/salary-account') }}" class="nav-link ">
                                                <i class="icon-list"></i>
                                                <span class="title">PF Manage</span>
                                            </a>
                                        </li>

                                    </ul>

                                </li>
                                <li class="nav-item {{ $_SESSION['MenuActive'] == 'Payroll' ? 'active open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="fa fa-calculator" aria-hidden="true"></i>
                                        <span class="title">Salary Process</span>
                                        <span class="selected"></span><span class="arrow open"></span>
                                    </a>

                                    <ul class="sub-menu" {{ $_SESSION['MenuActive'] == 'Payroll' ? 'active open':'' }}>

                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'FestivalBonus' ? 'active':'' }}">
                                            <a href="{{ asset('/FestivalBonus') }}" class="nav-link ">
                                                <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                                <span class="title">Festival Bonus Process</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'payroll-salary-account' ? 'active':'' }}">
                                            <a href="{{ asset('/salary-process') }}" class="nav-link ">
                                                <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                                <span class="title">Day Count</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'payroll-salary-account' ? 'active':'' }}">
                                            <a href="{{ asset('/salary-process/final') }}" class="nav-link ">
                                                <i class="fa fa-paypal" aria-hidden="true"></i>
                                                <span class="title">Process</span>
                                            </a>
                                        </li>
                                    </ul>

                                </li>

                            </ul>
                        </li>

                    @endif
                    @if (in_array(auth()->user()->role_id,['3']))
                        <li class="nav-item start {{ $_SESSION["MenuActive"] == 'dashboard' ? 'active open' : "" }}">
                            <a href="{{ url('/') }}" class="nav-link">
                                <i class="icon-bar-chart"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        {{--<li class="nav-item {{ $_SESSION['MenuActive'] == 'administration' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i><span class="title">ADMINISTRATION</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                @if (auth()->user()->role_id == '2')
                                    --}}{{-- @can('Permission Management') --}}{{--
                                    <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'permission' ? 'active':'' }}">
                                        <a href="{{ asset('/permission') }}" class="nav-link ">
                                            <i class="icon-list"></i>
                                            <span class="title">Manage Permission</span>
                                        </a>
                                    </li>
                                    --}}{{-- @endcan --}}{{--

                                    --}}{{-- @can('Role Management') --}}{{--
                                    <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'role' ? 'active':'' }}">
                                        <a href="{{route('role.index')}}" class="nav-link ">
                                            <i class="icon-list"></i>
                                            <span class="title">Manage Role</span>
                                        </a>
                                    </li>
                                    --}}{{-- @endcan --}}{{--
                                @endif

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'division' ? 'active':'' }}">
                                    <a href="{{ asset('/division') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Division</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'district' ? 'active':'' }}">
                                    <a href="{{ asset('/district') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage District</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'thana' ? 'active':'' }}">
                                    <a href="{{ asset('/thana') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Thana</span>
                                    </a>
                                </li>
                            </ul>
                        </li>--}}
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'settings' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i><span class="title">SETTINGS</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'division' ? 'active':'' }}">
                                    <a href="{{ asset('/division') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Division</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'district' ? 'active':'' }}">
                                    <a href="{{ asset('/district') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage District</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'thana' ? 'active':'' }}">
                                    <a href="{{ asset('/thana') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Thana</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'designation' ? 'active':'' }}">
                                    <a href="{{ asset('/designation') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Designation</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'branch' ? 'active':'' }}">
                                    <a href="{{ asset('/branch') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Add Branch / Division</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'br-division' ? 'active':'' }}">
                                    <a href="{{ asset('/br-division') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Branch Division</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'br-department' ? 'active':'' }}">
                                    <a href="{{ asset('/br-department') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Division Department</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'department-unit' ? 'active':'' }}">
                                    <a href="{{ asset('/department-unit') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Department Unit</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'document' ? 'active':'' }}">
                                    <a href="{{ asset('/document') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Document</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'specialization' ? 'active':'' }}">
                                    <a href="{{ asset('/specialization') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Specialization</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'tour-type' ? 'active':'' }}">
                                    <a href="{{ asset('/tour-type') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Tour Type</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'job-status' ? 'active':'' }}">
                                    <a href="{{ asset('/job-status') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Job Status</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'salary-head' ? 'active':'' }}">
                                    <a href="{{ asset('/salary-head') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Salary Head</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'salary-slave' ? 'active':'' }}">
                                    <a href="{{ asset('/salary-slave') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Salary Slab</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'salary-increment-slave' ? 'active':'' }}">
                                    <a href="{{ asset('/salary-increment-slave') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Salary Increment Slab</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'disciplinary-category' ? 'active':'' }}">
                                    <a href="{{ asset('/disciplinary-category') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Disciplinary Category</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'FunctionalDesignation' ? 'active':'' }}">
                                    <a href="{{ asset('/functional-designation') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Functional Designation</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'reporting-heads' ? 'active':'' }}">
                                    <a href="{{ asset('/reporting-heads') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Reporting Managers</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'employee' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-users"></i><span class="title">Employee</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee' ? 'active':'' }}">
                                    <a href="{{ asset('/employee') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Employee</span>
                                    </a>
                                </li>
                                @if (auth()->user()->role_id == '1')
                                    <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'hiddenReference' ? 'active':'' }}">
                                        <a href="{{ asset('/employee-hidden-reference') }}" class="nav-link ">
                                            <i class="icon-list"></i>
                                            <span class="title">Employee Hidden Reference</span>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()->role_id == '2')
                                    <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employeeIncrement' ? 'active':'' }}">
                                        <a href="{{ asset('/incrementAuthorization') }}" class="nav-link ">
                                            <i class="icon-list"></i>
                                            <span class="title">Salary / Increment Authorize</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employeePromotion' ? 'active':'' }}">
                                        <a href="{{ asset('/promotionAuthorization') }}" class="nav-link ">
                                            <i class="icon-list"></i>
                                            <span class="title">Promotion Authorize</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'increment' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-arrow-up"></i><span class="title">Manage Salary / Increment</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'all-salary' ? 'active':'' }}">
                                    <a href="{{ asset('/all-sal') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Salary Info</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-increment' ? 'active':'' }}">
                                    <a href="{{ asset('/employee-increment') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Salary / Increment</span>
                                    </a>
                                </li>

                                {{--<li class="nav-item {{ $_SESSION['SubMenuActive'] == 'bulk-increment' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Bulk Increment</span>
                                    </a>
                                </li>--}}

                                {{-- <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employeeIncrement' ? 'active':'' }}">
                                     <a href="{{ asset('/incrementAuthorization') }}" class="nav-link ">
                                         <i class="icon-list"></i>
                                         <span class="title">Increment Authorize</span>
                                     </a>
                                 </li>--}}
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'salary-certificate' ? 'active':'' }}">
                                    <a href="{{ asset('/salary-certificate') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Salary Certificate</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'promotion' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-bullhorn"></i><span class="title">Manage Promotion</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-promotion' ? 'active':'' }}">
                                    <a href="{{ asset('/employee-promotion') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Promotion</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'bulk-promotion' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Bulk Promotion</span>
                                    </a>
                                </li>

                                {{--<li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employeePromotion' ? 'active':'' }}">
                                    <a href="{{ asset('/promotionAuthorization') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Promotion Authorize</span>
                                    </a>
                                </li>--}}
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'transfer' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-reload"></i><span class="title">Manage Transfer/Posting</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'new-transfer' ? 'active':'' }}">
                                    <a href="{{ asset('/postinglist') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Transfer/Posting</span>
                                    </a>
                                </li>
                                {{--<li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employeePosting' ? 'active':'' }}">
                                    <a href="{{ asset('/postingAuthorization') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Transfer/Posting Authorize</span>
                                    </a>
                                </li>--}}
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'disciplinary-action' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-user"></i><span class="title">Disciplinary Action</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'disciplinaryAction' ? 'active':'' }}">
                                    <a href="{{ asset('/disciplinaryAction') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Manage Disciplinary Action</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'addDisciplinaryAction' ? 'active':'' }}">
                                    <a href="{{ asset('/disciplinaryAction/create') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Add New Disciplinary Action</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'leave' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-plane" aria-hidden="true"></i>
                                <span class="title">Leave</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-leave' ? 'active':'' }}">
                                    <a href="{{ asset('/leave') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">All Employee Leave Balance</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'all-applications' ? 'active':'' }}">
                                    <a href="{{ asset('/allApplication') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">All Leave Application</span>
                                    </a>
                                </li>

                                {{-- <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'leave-apply' ? 'active':'' }}">
                                     <a href="{{ asset('/leave/create') }}" class="nav-link ">
                                         <i class="icon-list"></i>
                                         <span class="title">Apply for Leave</span>
                                     </a>
                                 </li>--}}

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'waiting-for' ? 'active':'' }}">
                                    <a href="{{ asset('/waiting-list') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Waiting for Approval</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'leave-types' ? 'active':'' }}">
                                    <a href="{{ asset('/leave-type') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Leave Types</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'attendance' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <span class="title">Attendance</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-attendance' ? 'active':'' }}">
                                    <a href="{{ asset('/attendance') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">All Employee Attendance</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-attendance' ? 'active':'' }}">
                                    <a href="{{ asset('/today-attendance') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Today's Attendance</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'report' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                <span class="title">Report</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'all-employee' ? 'active':'' }}">
                                    <a href="{{ asset('/all-employee') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">All Employee List</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-on-leave' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee On Leave</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'branch-leave' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Branch/Division Wise Leave Report</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'without-pay-report' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Without Pay Report</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-leave-balance' ? 'active':'' }}">
                                    <a href="{{ asset('/common') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Employee Leave Balance</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    {{--The Role ID 21 is Belongs to All employees.--}}
                    @if (in_array(auth()->user()->role_id,['2','21']))
                        <li class="nav-item start {{ $_SESSION["MenuActive"] == 'dashboard' ? 'active open' : "" }}">
                            <a href="{{ url('/') }}" class="nav-link">
                                <i class="icon-bar-chart"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee' ? 'active':'' }}">
                            <a href="{{ asset('/employee') }}" class="nav-link ">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="title">Employee Profile</span>
                            </a>
                        </li>
                        {{--<li class="nav-item {{ $_SESSION['MenuActive'] == 'employeeSalaryCertificate' ? 'active':'' }}">
                                <a href="{{ asset('/employeeSalaryCertificate') }}" class="nav-link ">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <span class="title">Salary Certificate</span>
                                </a>
                            </li>--}}
                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'leave' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-plane" aria-hidden="true"></i>
                                <span class="title">Leave</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-leave' ? 'active':'' }}">
                                    <a href="{{ asset('/leave') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Leave Balance</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'leave-apply' ? 'active':'' }}">
                                    <a href="{{ asset('/leave/create') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Apply for Leave</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'all-applications' ? 'active':'' }}">
                                    <a href="{{ asset('/allApplication') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">All Leave Application</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'waiting-for' ? 'active':'' }}">
                                    <a href="{{ asset('/waiting-list') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Waiting for Approval</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item {{ $_SESSION['MenuActive'] == 'attendance' ? 'active open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <span class="title">Attendance</span>
                                <span class="selected"></span><span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-attendance' ? 'active':'' }}">
                                    <a href="{{ asset('/attendance') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">All Employee Attendance</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-attendance' ? 'active':'' }}">
                                    <a href="{{ asset('/today-attendance') }}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Today's Attendance</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endif
                @endif
                @if (in_array(auth()->user()->role_id,['5']))
                    <li class="nav-item start {{ $_SESSION["MenuActive"] == 'dashboard' ? 'active open' : "" }}">
                        <a href="{{ url('/') }}" class="nav-link">
                            <i class="icon-bar-chart"></i>
                            <span class="title">Dashboard</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item {{ $_SESSION['MenuActive'] == 'leave' ? 'active open':'' }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-plane" aria-hidden="true"></i>
                            <span class="title">Leave</span>
                            <span class="selected"></span><span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">

                            <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'all-applications' ? 'active':'' }}">
                                <a href="{{ asset('/allApplication') }}" class="nav-link ">
                                    <i class="icon-list"></i>
                                    <span class="title">All Leave Application</span>
                                </a>
                            </li>


                            <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'waiting-for-hr' ? 'active':'' }}">
                                <a href="{{ asset('/waiting-list-hr') }}" class="nav-link ">
                                    <i class="icon-list"></i>
                                    <span class="title">Waiting for Approval</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif
                @if (in_array(auth()->user()->role_id,['6']))
                    <li class="nav-item start {{ $_SESSION["MenuActive"] == 'dashboard' ? 'active open' : "" }}">
                        <a href="{{ url('/') }}" class="nav-link">
                            <i class="icon-bar-chart"></i>
                            <span class="title">Dashboard</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item {{ $_SESSION['MenuActive'] == 'attendance' ? 'active open':'' }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            <span class="title">Attendance</span>
                            <span class="selected"></span><span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item {{ $_SESSION['SubMenuActive'] == 'employee-attendance' ? 'active':'' }}">
                                <a href="{{ asset('/today-attendance') }}" class="nav-link ">
                                    <i class="icon-list"></i>
                                    <span class="title">Today's Attendance</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->
@stop