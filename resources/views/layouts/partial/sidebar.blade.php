<div class="fixed-sidebar-left">
    <ul class="nav navbar-nav side-nav nicescroll-bar">
        <li class="navigation-header">
            <span>Main</span> 
            <i class="zmdi zmdi-more"></i>
        </li>

        <li>
            <a href="{{route('home')}}" class="home">
                <div class="pull-left">
                    <i class="zmdi zmdi-home mr-20"></i>
                    <span class="right-nav-text">Home</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        
        <li><hr class="light-grey-hr mb-10"/></li>
        
        @can('Role Management')
        <li>
            <a href="{{route('role.index')}}" class="role">
                <div class="pull-left">
                    <i class="zmdi zmdi-key mr-20"></i>
                    <span class="right-nav-text">Role Management</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        @endcan

        @can('User Management')
        <li>
            <a href="{{route('system-users.index')}}" class="user_management">
                <div class="pull-left">
                    <i class="zmdi zmdi-account mr-20"></i>
                    <span class="right-nav-text">Manage User</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        @endcan

        @can('Company Management')
        <li>
            <a href="{{route('companies.index')}}" class="company_management">
                <div class="pull-left">
                    <i class="fa fa-briefcase mr-20"></i>
                    <span class="right-nav-text">Manage Company</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        @endcan

        @can('Branch Management')
        <li>
            <a href="{{route('branch.index')}}" class="branch_management">
                <div class="pull-left">
                    <i class="fa fa-briefcase mr-20"></i>
                    <span class="right-nav-text">Manage Branch</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        @endcan
        
        @can('Customer Management')
        <li>
            <a href="{{route('customer-management.index')}}" class="customer_management">
                <div class="pull-left">
                    <i class="zmdi zmdi-file-add mr-20"></i>
                    <span class="right-nav-text">Manage Customer</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        @endcan

        @can('Product Management')
        <li>
            <a href="{{route('products.index')}}" class="product_management">
                <div class="pull-left">
                    <i class="zmdi zmdi-cake mr-20"></i>
                    <span class="right-nav-text">Manage Products</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        @endcan

        @can('Order Management')
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" class="sell_management" data-target="#sell_management">
                <div class="pull-left">
                    <i class="zmdi zmdi-money mr-20"></i>
                    <span class="right-nav-text">Manage Orders</span>
                </div>
                <div class="pull-right">
                    <i class="zmdi zmdi-caret-down"></i>
                </div>
                <div class="clearfix"></div>
            </a>
            <ul id="sell_management" class="collapse collapse-level-1 two-col-list">
                <li><a class="all_invoice" href="{{route('order.index')}}">Order List</a></li>
                <li><a class="sell" href="{{route('order.create')}}">Create New Order</a></li>
            </ul>
        </li>
        @endcan

        @can('Report Manager')
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" class="reports" data-target="#reports">
                <div class="pull-left">
                    <i class="zmdi zmdi-chart mr-20"></i>
                    <span class="right-nav-text">Reports</span>
                </div>
                <div class="pull-right">
                    <i class="zmdi zmdi-caret-down"></i>
                </div>
                <div class="clearfix"></div>
            </a>
            <ul id="reports" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a class="daily_report" href="{{route('report.daily')}}">Daily Reports</a>
                </li>
                <li>
                    <a class="monthly_report" href="{{route('report.monthly')}}">Monthly Reports</a>
                </li>
               
            </ul>
        </li>
        @endcan
        

        @can('Settings')
        <li>
            <a href="{{route('site_settings.index')}}" class="settings">
                <div class="pull-left">
                    <i class="zmdi zmdi-settings mr-20"></i>
                    <span class="right-nav-text">Site Settings</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        @endcan
    </ul>
</div>