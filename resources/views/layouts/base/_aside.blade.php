<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="active"> <a href="index.html"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a> </li>
                <li class="list-divider"></li>
                <li class="submenu"> <a href="#"><i class="fas fa-suitcase"></i> <span> Booking </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a class="{{ request()->is('bookings') ? 'active' : '' }}" href="{{route('bookings.index')}}"> All Booking </a></li>
                        <li><a class="{{ request()->is('bookings/edit/*') ? 'active' : '' }}" href="#"> Edit Booking </a></li>
                        <li><a class="{{ request()->is('bookings/create*') ? 'active' : '' }}" href="{{route('bookings.create')}}"> Add Booking </a></li>
                    </ul>
                </li>
                <li class="submenu"> <a href="#"><i class="fas fa-user"></i> <span> Customers </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a class="{{ request()->is('customers') ? 'active' : '' }}" href="{{route('customers.index')}}"> All customers </a></li>
                        <li><a class="{{ request()->is('customers/*/edit') ? 'active' : '' }}" href="#"> Edit Customer </a></li>
                        <li><a class="{{ request()->is('customers/create*') ? 'active' : '' }}" href="{{route('customers.create')}}"> Add Customer </a></li>
                    </ul>
                </li>
                <li class="submenu"> <a href="#"><i class="fas fa-key"></i> <span> Rooms </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a href="all-rooms.html">All Rooms </a></li>
                        <li><a href="edit-room.html"> Edit Rooms </a></li>
                        <li><a href="add-room.html"> Add Rooms </a></li>
                    </ul>
                </li>
                <li class="submenu"> <a href="#"><i class="fas fa-user"></i> <span> Staff </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a href="all-staff.html">All Staff </a></li>
                        <li><a href="edit-staff.html"> Edit Staff </a></li>
                        <li><a href="add-staff.html"> Add Staff </a></li>
                    </ul>
                </li>
                
                <li class="submenu"> <a href="#"><i class="fas fa-user"></i> <span> Employees </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a href="employees.html">Employees List </a></li>
                        <li><a href="leaves.html">Leaves </a></li>
                        <li><a href="holidays.html">Holidays </a></li>
                        <li><a href="attendance.html">Attendance </a></li>
                    </ul>
                </li>
                <li class="submenu"> <a href="#"><i class="far fa-money-bill-alt"></i> <span> Accounts </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a href="invoices.html">Invoices </a></li>
                        <li><a href="payments.html">Payments </a></li>
                        <li><a href="expenses.html">Expenses </a></li>
                        <li><a href="taxes.html">Taxes </a></li>
                        <li><a href="provident-fund.html">Provident Fund </a></li>
                    </ul>
                </li>
                <li class="submenu"> <a href="#"><i class="fas fa-book"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a href="salary.html">Employee Salary </a></li>
                        <li><a href="salary-veiw.html">Payslip </a></li>
                    </ul>
                </li>
                <li class="list-divider"></li>
                <li class="submenu"> <a href="#"><i class="fas fa-laptop"></i> <span> Components </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a href="uikit.html">UI Kit </a></li>
                        <li><a href="typography.html">Typography </a></li>
                        <li><a href="tabs.html">Tabs </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>