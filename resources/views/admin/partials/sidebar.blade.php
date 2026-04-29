<div class="nav-section">Main</div>
<a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active':'' }}"><i class="sidebar-icon">&#9632;</i> Dashboard</a>
<a href="{{ route('admin.donors.index') }}" class="{{ request()->routeIs('admin.donors.*') ? 'active':'' }}"><i class="sidebar-icon">&#43;</i> Donors</a>
<a href="{{ route('admin.appointments.index') }}" class="{{ request()->routeIs('admin.appointments.*') ? 'active':'' }}"><i class="sidebar-icon">&#9776;</i> Appointments</a>
<div class="nav-section">Records</div>
<a href="{{ route('admin.donations.index') }}" class="{{ request()->routeIs('admin.donations.*') ? 'active':'' }}"><i class="sidebar-icon">&#9679;</i> Record Donation</a>
<a href="{{ route('admin.inventory.index') }}" class="{{ request()->routeIs('admin.inventory.*') ? 'active':'' }}"><i class="sidebar-icon">&#9670;</i> Blood Inventory</a>
<a href="{{ route('admin.blood-requests.index') }}" class="{{ request()->routeIs('admin.blood-requests.*') ? 'active':'' }}"><i class="sidebar-icon">&#9651;</i> Blood Requests</a>
<a href="{{ route('admin.recipients.index') }}" class="{{ request()->routeIs('admin.recipients.*') ? 'active':'' }}"><i class="sidebar-icon">&#9745;</i> Recipients</a>
<a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active':'' }}"><i class="sidebar-icon">&#9741;</i> Reports</a>