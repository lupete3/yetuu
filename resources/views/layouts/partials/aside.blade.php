<div class="main-sidebar sidebar-style-2 valider" style="
            .nav-link:hover i {
                color: #4CAF50;
            }
        ">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" style="font-size:12px">
                @if(isset($settings['app_name']))
                {{ $settings['app_name'] }}
                @else
                Dashboard
                @endif
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

            <li class="@if (request()->routeIs('dashboard')) active @endif">
                <a href="{{ route('dashboard') }}" class="nav-link"><i
                        class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
            </li>

            @if (Auth::user()->role == 'super-admin')

            <li class="menu-header">Farmer & Farm Management</li>
            <li class="@if (request()->routeIs('farmers.*')) active @endif">
                <a href="{{ route('farmers.index') }}" class="nav-link"><i
                        class="ion-ios-people"></i><span>Farmers</span></a>
            </li>

            <li class="@if (request()->routeIs('farms.*')) active @endif">
                <a href="{{ route('farms.index') }}" class="nav-link"><i
                        class="fas fa-tractor"></i><span>Farms</span></a>
            </li>

            <li class="menu-header">Sowing Management</li>
            <li class="@if (request()->routeIs('crop-management.*')) active @endif">
                <a href="{{ route('crop-management.index') }}" class="nav-link"><i class="ion-leaf"></i><span>Crop
                        Record</span></a>
            </li>


            <li class="menu-header">Land Plot Management</li>
            <li class="@if (request()->routeIs('fields.*')) active @endif">
                <a href="{{ route('fields.index') }}" class="nav-link"><i class="fas fa-seedling"></i><span>Land
                        Plots</span></a>
            </li>

            <li class="@if (request()->routeIs('field_visits.*')) active @endif">
                <a href="{{ route('field_visits.index') }}" class="nav-link"><i class="ion-map"></i><span>Land Plot
                        Visits</span></a>
            </li>

            <li class="menu-header">Support</li>
            <li class="@if (request()->routeIs('farmer-accompaniements.*')) active @endif">
                <a href="{{ route('farmer-accompaniements.index') }}" class="nav-link"><i
                        class="fas fa-seedling"></i><span>Farmer Support Activities</span></a>
            </li>

            <li class="@if (request()->routeIs('accompaniements.*')) active @endif">
                <a href="{{ route('accompaniements.index') }}" class="nav-link"><i
                        class="fas fa-hand-holding-heart"></i><span>Type of Support/Activity</span></a>
            </li>

            <li class="menu-header">Inputs Distribution Management</li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-truck-loading"></i><span>Supplier</span></a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-seedling"></i><span>Inputs Record</span></a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-box-open"></i><span>Distribution</span></a>
            </li>

            <li class="menu-header">Procurement & Storage and Financial</li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-hand-holding-usd"></i><span>Procurement</span></a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-boxes"></i><span>Inventory</span></a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-file-invoice-dollar"></i><span>Financial
                        Records</span></a>
            </li>

            <li class="menu-header">Harvest Planning & Equipment Maintenance</li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-calendar-alt"></i><span>Harvest Planning</span></a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-wrench"></i><span>Equipment</span></a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-wrench"></i><span>Maintenance Log</span></a>
            </li>

            <li class="menu-header">Advisory Services</li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-comments"></i><span>Advisory Record</span></a>
            </li>

            <li class="menu-header">Government Grants, Subsidies, Farm Insurances</li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-hand-holding-heart"></i><span>Grants</span></a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-percent"></i><span>Subsidies</span></a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-shield-alt"></i><span>Insurance</span></a>
            </li>

            <li class="menu-header">Early Warning Alerts</li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-bell"></i><span>Get Data</span></a>
            </li>

            <li class="menu-header">Training</li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-chalkboard-teacher"></i><span>Training Programs</span></a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-user-check"></i><span>Attendance Records</span></a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-users"></i><span>Groups</span></a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-comment-dots"></i><span>Training Feedback</span></a>
            </li>

            <li class="menu-header">Risk Assessment</li>
            <li>
                <a href="#" class="nav-link"><i class="fas fa-exclamation-triangle"></i><span>Risk Assessment
                        Record</span></a>
            </li>


            {{-- <li class="menu-header">Sowing Management</li>
            <li class="dropdown @if (request()->routeIs('crop-management.*')) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="ion-leaf"></i> <span>Crop
                        Record</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('crop-management.create') }}">Add</a></li>
                    <li><a class="nav-link" href="{{ route('crop-management.index') }}">View</a></li>
                </ul>
            </li> --}}


            {{-- <li class="menu-header">Land Plot Management</li>
            <li class="dropdown @if (request()->routeIs('fields.*')) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-seedling"></i>
                    <span>Land Plots</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('fields.create') }}">Add</a></li>
                    <li><a class="nav-link" href="{{ route('fields.index') }}">View</a></li>
                </ul>
            </li>

            <li class="dropdown @if (request()->routeIs('field_visits.*')) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="ion-map"></i> <span>Land Plot
                        Visits</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('field_visits.create') }}">Add</a></li>
                    <li><a class="nav-link" href="{{ route('field_visits.index') }}">View</a></li>
                </ul>
            </li> --}}

            {{-- <li class="dropdown @if (request()->routeIs('sowing-records.*')) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="ion-leaf"></i> <span>Sowing
                        Record</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('sowing-records.create') }}">Add</a></li>
                    <li><a class="nav-link" href="{{ route('sowing-records.index') }}">View</a></li>
                </ul>
            </li> --}}

            <li class="menu-header">Field staff management</li>

            <li class="@if (request()->routeIs('users.*')) active @endif">
                <a href="{{ route('users.index') }}" class="nav-link"><i
                        class="ion-ios-people"></i><span>Staff</span></a>
            </li>

            <li class="menu-header">Settings</li>

            <li class="dropdown @if (request()->routeIs('countries.*','provinces.*','territories.*')) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="ion-earth"></i>
                    <span>Regions</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('countries.index') }}">Countries</a></li>
                    <li><a class="nav-link" href="{{ route('provinces.index') }}">Provinces</a></li>
                    <li><a class="nav-link" href="{{ route('territories.index') }}">Territories</a></li>
                    <li><a class="nav-link" href="{{ route('localities.index') }}">Localities</a></li>
                </ul>
            </li>

            <li class="@if (request()->routeIs('settings.*')) active @endif">
                <a href="{{ route('settings.index') }}" class="nav-link"><i class="ion-settings"></i><span>App
                        Settings</span></a>
            </li>
            @endif

            @if (Auth::user()->role == 'field_staff')
            <li class="menu-header">Farmer & Farm Management</li>
            <li class="@if (request()->routeIs('farmers.*')) active @endif">
                <a href="{{ route('farmers.index') }}" class="nav-link"><i
                        class="ion-ios-people"></i><span>Farmers</span></a>
            </li>

            <li class="@if (request()->routeIs('farms.*')) active @endif">
                <a href="{{ route('farms.index') }}" class="nav-link"><i
                        class="fas fa-tractor"></i><span>Farms</span></a>
            </li>

            <li class="menu-header">Sowing Management</li>
            <li class="@if (request()->routeIs('crop-management.*')) active @endif">
                <a href="{{ route('crop-management.index') }}" class="nav-link"><i class="ion-leaf"></i><span>Crop
                        Record</span></a>
            </li>


            <li class="menu-header">Land Plot Management</li>
            <li class="@if (request()->routeIs('fields.*')) active @endif">
                <a href="{{ route('fields.index') }}" class="nav-link"><i class="fas fa-seedling"></i><span>Land
                        Plots</span></a>
            </li>

            <li class="@if (request()->routeIs('field_visits.*')) active @endif">
                <a href="{{ route('field_visits.index') }}" class="nav-link"><i class="ion-map"></i><span>Land Plot
                        Visits</span></a>
            </li>
            @endif
        </ul>
    </aside>

</div>
