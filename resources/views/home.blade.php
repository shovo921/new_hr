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
                <span>Dashboard</span>
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
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> Dashboard
        <small>dashboard & statistics</small>
    </h1>
    <!-- END PAGE TITLE-->
    <div class="clearfix"></div>
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="row">
        @if (in_array(auth()->user()->role_id,['1','3']))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="{{ url('/employee') }}">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            {{--<span data-counter="counterup" data-value="{{ $total_employee }}">{{ $total_employee }}</span>--}}
                        </div>
                        <div class="desc"> Total Regular Employee: <span data-counter="counterup"
                                                                         data-value="{{ $total_employee }}">{{ $total_employee }}</span>
                        </div>
                        <div class="desc"> Total Employee(Male) : <span data-counter="counterup"
                                                                        data-value="{{ $total_male_Employee }}">{{ $total_male_Employee }}</span>
                        </div>
                        <div class="desc"> Total Employee(Female) : <span data-counter="counterup"
                                                                          data-value="{{ $total_female_Employee }}">{{ $total_female_Employee }}</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="{{ url('/employee') }}">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                        </div>
                        <div class="desc"> Total Sales Employee: <span data-counter="counterup"
                                                                       data-value="{{ $total_sales_staff }}">{{ $total_sales_staff }}</span>
                        </div>
                        <div class="desc"> Total Sales Employee (Male): <span data-counter="counterup"
                                                                              data-value="{{ $total_male_sales_staff }}">{{ $total_male_sales_staff }}</span>
                        </div>
                        <div class="desc"> Total Sales Employee (Female): <span data-counter="counterup"
                                                                                data-value="{{ $total_female_sales_staff }}">{{ $total_female_sales_staff }}</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="{{ url('/employee') }}">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            {{--<span data-counter="counterup" data-value="{{ $total_casual_staff }}">{{ $total_casual_staff }}</span>--}}
                        </div>
                        <div class="desc"> Total Casual Employee: <span data-counter="counterup"
                                                                        data-value="{{ $total_casual_staff }}">{{ $total_casual_staff }}</span>
                        </div>
                        <div class="desc"> Total Casual Employee (Male): <span data-counter="counterup"
                                                                               data-value="{{ $total_male_casual_staff }}">{{ $total_male_casual_staff }}</span>
                        </div>
                        <div class="desc"> Total Casual Employee Female): <span data-counter="counterup"
                                                                                data-value="{{ $total_female_casual_staff }}">{{ $total_female_casual_staff }}</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple" href="{{ url('/branch') }}">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $total_branch }}">{{ $total_branch }}</span>
                        </div>
                        <div class="desc"> Total Branch</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="{{ url('/today-attendance') }}">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup"
                                  data-value="{{$totalPresent[0]->totalpresent}}">{{$totalPresent[0]->totalpresent}}</span>
                        </div>
                        <div class="desc">Today's Total Attendance</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 red" href="{{ url('/attendance') }}">
                    <div class="visual">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{$totalLeave}}">{{$totalLeave}}</span>
                        </div>
                        <div class="desc">Today's Employee Leave</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="{{ url('/job-description') }}">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-value="{{$totalJdApproval}}">{{$totalJdApproval}}</span>
                        </div>
                        <div class="desc">Approval of Job Description</div>
                    </div>
                </a>
            </div>

        @endif
        @if (in_array(auth()->user()->role_id,['21','2']))
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple" href="{{ url('/') }}">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <?php /*dd($employee); */?>
                            <span>
                             <small>Welcome {{ $employee->name }} To Padma Bank HR Management System</small>

                        </span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple" href="{{ url('/waiting-list') }}">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup"
                                  data-value="{{ $total_waitingList }}">{{ $total_waitingList }}</span>
                        </div>
                        <div class="desc"> Total Leave Approval Waiting</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="{{ url('/attendance') }}">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-value="{{$today_attendance[0]->todays_attendance}}">{{$today_attendance[0]->todays_attendance}}</span>
                        </div>
                        <div class="desc">Today's In Time</div>
                    </div>
                </a>
            </div>

            @if (in_array(auth()->user()->role_id,['21','2']) && !empty($jdInfo->status))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple"
                   href="{{ url('/job-description/jd/'.$jdInfo->employee_id) }}">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup"
                                  data-value="{{ $totalJdApproval }}">{{ $totalJdApproval }}</span>
                        </div>
                        <div class="desc">Click Here to Check Your Job Description</div>
                    </div>
                </a>
            </div>
            @endif
            {{--@if (in_array(auth()->user()->role_id,['2']) && $jdInfo->status == 2))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple"
                   href="{{ url('/job-description/jd/'.$jdInfo->employee_id) }}">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup"
                                  data-value="{{ $totalJdApproval }}">{{ $totalJdApproval }}</span>
                        </div>
                        <div class="desc">Click Here to Check Your Job Description</div>
                    </div>
                </a>
            </div>
            @endif--}}
            @if (in_array(auth()->user()->role_id,['2']))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="{{ url('/job-description') }}">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-value="{{$jdApproveBrManager}}">{{$jdApproveBrManager}}</span>
                        </div>
                        <div class="desc">Approval of Job Description</div>
                    </div>
                </a>
            </div>
            @endif
        @endif


        @if (in_array(auth()->user()->role_id,['5']))
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple" href="{{ url('/') }}">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <?php /*dd($employee); */?>
                            <span>
                             <small>Welcome {{ $employee->name }} To Padma Bank HR Management System</small>

                        </span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple" href="{{ url('/waiting-list-hr') }}">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup"
                                  data-value="{{ $total_waitingList }}">{{ $total_waitingList }}</span>
                        </div>
                        <div class="desc"> Total Leave Approval Waiting</div>
                    </div>
                </a>
            </div>
        @endif

        {{--  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 green" href="{{ url('/attendance') }}">
                  <div class="visual">
                      <i class="fa fa-shopping-cart"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{$total_attendance}}">{{$total_attendance}}</span>
                      </div>
                      <div class="desc">Today's Total Attendance </div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 red" href="{{ url('/attendance') }}">
                  <div class="visual">
                      <i class="fa fa-globe"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{$total_absent}}">{{$total_absent}}</span>
                      </div>
                      <div class="desc">Today's Total Absent </div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 green" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-globe"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc">Total Contrucual Expired</div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 yellow" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-globe"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc">Total Provision Complete</div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 purple" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc"> Total Release Pending </div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 blue" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc"> Total Promotion Held Up </div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 red" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc"> Total Increment Held Up </div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 blue" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc"> Total Increment Held Up </div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 yellow" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc"> Monthly Total New Joinner </div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 green" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc"> Monthly Total Separation </div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 green" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc"> Total Disciplinary Action Pending </div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 blue" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc"> Total Employees On Leave </div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 red" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc"> Total Intern </div>
                  </div>
              </a>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <a class="dashboard-stat dashboard-stat-v2 yellow" href="{{ url('/') }}">
                  <div class="visual">
                      <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                      <div class="number">
                          <span data-counter="counterup" data-value="{{ '0' }}">{{ '0' }}</span>
                      </div>
                      <div class="desc"> Total Promoted </div>
                  </div>
              </a>
          </div>--}}
    </div>
@endsection

@section('script')
    <script src="{{  asset('assets/global/plugins/counterup/jquery.waypoints.min.js') }}"
            type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/counterup/jquery.counterup.min.js') }}"
            type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>
    <script src="{{  asset('assets/pages/scripts/dashboard.min.js') }}" type="text/javascript"></script>
    {{--<script>
        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = "\o/";

            (e || window.event).returnValue = confirmationMessage; //Gecko + IE
            return confirmationMessage;                            //Webkit, Safari, Chrome
        });
    </script>--}}
@endsection