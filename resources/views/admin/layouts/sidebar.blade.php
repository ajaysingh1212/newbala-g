<aside class="main-sidebar sidebar-dark-primary elevation-4">

<a href="#" class="brand-link">
<span class="brand-text font-weight-light">TTD Booking</span>
</a>

<div class="sidebar">

<nav class="mt-2">

<ul class="nav nav-pills nav-sidebar flex-column"
data-widget="treeview"
role="menu">

<li class="nav-item">

<a href="{{ route('dashboard') }}"
class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

<i class="nav-icon fas fa-tachometer-alt"></i>
<p>Dashboard</p>

</a>

</li>



@canany(['user-list','role-list','permission-list'])

<li class="nav-item has-treeview">

<a href="#" class="nav-link">

<i class="nav-icon fas fa-users"></i>

<p>
User Management
<i class="right fas fa-angle-left"></i>
</p>

</a>

<ul class="nav nav-treeview">

@can('user-list')

<li class="nav-item">

<a href="{{ route('admin.users.index') }}"
class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>
<p>Users</p>

</a>

</li>

<li class="nav-item">

<a href="{{ route('admin.users.access-control') }}"
class="nav-link {{ request()->routeIs('admin.users.access-control') ? 'active' : '' }}">

<i class="far fa-shield-alt nav-icon"></i>
<p>User Access Control</p>

</a>

</li>

@endcan


@can('role-list')

<li class="nav-item">

<a href="{{ route('admin.roles.index') }}"
class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>
<p>Roles</p>

</a>

</li>

@endcan


@can('permission-list')

<li class="nav-item">

<a href="{{ route('admin.permissions.index') }}"
class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>
<p>Permissions</p>

</a>

</li>

@endcan

</ul>

</li>

@endcanany

<!-- Booking Management -->
<li class="nav-item has-treeview {{ request()->routeIs('admin.booking_types.*', 'admin.bank_accounts.*', 'admin.bookings.*') ? 'menu-open' : '' }}">

<a href="#" class="nav-link {{ request()->routeIs('admin.booking_types.*', 'admin.bank_accounts.*', 'admin.bookings.*') ? 'active' : '' }}">

<i class="nav-icon fas fa-calendar-alt"></i>

<p>
Booking Management
<i class="right fas fa-angle-left"></i>
</p>

</a>

<ul class="nav nav-treeview">

<li class="nav-item">

<a href="{{ route('admin.booking_types.index') }}"
class="nav-link {{ request()->routeIs('admin.booking_types.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>
<p>Booking Types</p>

</a>

</li>

<li class="nav-item">

<a href="{{ route('admin.bank_accounts.index') }}"
class="nav-link {{ request()->routeIs('admin.bank_accounts.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>
<p>Bank Accounts</p>

</a>

</li>

<li class="nav-item">

<a href="{{ route('admin.bookings.index') }}"
class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>
<p>Bookings</p>

</a>

</li>

</ul>

</li>

</ul>

</nav>

</div>

</aside>
