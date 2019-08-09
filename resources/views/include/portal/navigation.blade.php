<ul class="nav navbar-nav">
	<li class="nav-item">
		<a href="{{route('eac.portal.getDashboard')}}" class="nav-link">
			<i class="fa-fw text-primary fad fa-chart-bar"></i>
			<span>Dashboard</span>
		</a>
	</li>
 @if(\Auth::user()->type->name == 'Early Access Care')
	<li class="nav-item dropdown">
		<a href="{{route('eac.portal.rid.list')}}" class="nav-link">
			<i class="fa-fw text-primary fad fa-medkit"></i>
			<span>RIDs</span>
		</a>
	</li>
	<li class="nav-item dropdown">
		<a href="{{route('eac.portal.drug.list')}}" class="nav-link">
			<i class="fa-fw text-primary fad fa-prescription-bottle-alt"></i>
			<span>Drugs</span>
		</a>
	</li>
	<li class="nav-item dropdown">
		<a href="#" id="DD3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
		   class="nav-link dropdown-toggle">
			<i class="fa-fw text-primary fad fa-user-md"></i>
			<span>Users</span>
		</a>
		<div class="dropdown-menu" aria-labelledby="DD3">
			<a href="{{route('eac.portal.user.list')}}" class="dropdown-item @IndexTab('users')">
				<span>All Users</span>
			</a>
			<a href="{{route('eac.portal.user.group.list')}}" class="dropdown-item @IndexTab('user_groups')">
				<span>User Groups</span>
			</a>
   <a href="{{ route('eac.portal.settings.manage.user.role') }}" class="dropdown-item @IndexTab('user_roles')">
    <span>Role Manager</span>
   </a>
		</div>
	</li>
	<li class="nav-item dropdown">
		<a href="{{route('eac.portal.company.list')}}" class="nav-link">
			<i class="fa-fw text-primary fad fa-hospitals"></i>
			<span>Companies</span>
		</a>
	</li>
	<li class="nav-item dropdown">
		<a href="#" id="DD4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
		   class="nav-link dropdown-toggle">
			<i class="fa-fw text-primary fad fa-warehouse-alt"></i>
			<span>Shipping</span>
		</a>
		<div class="dropdown-menu" aria-labelledby="DD4">
			<a href="{{route('eac.portal.pharmacist.list.all')}}" class="dropdown-item @IndexTab('pharmacist')">
				<span>Pharmacist</span>
			</a>
			<a href="{{route('eac.portal.pharmacy.list.all')}}" class="dropdown-item @IndexTab('pharmacies')">
				<span>Pharmacies</span>
			</a>
			<a href="{{route('eac.portal.depot.list.all')}}" class="dropdown-item @IndexTab('depots')">
				<span>Depots</span>
			</a>
			<a href="{{route('eac.portal.lot.list.all')}}" class="dropdown-item @IndexTab('lots')">
				<span>Lots</span>
			</a>
		</div>
	</li>
	<li class="nav-item">
		<a href="#" class="nav-link">
			<i class="fa-fw text-primary fad fa-files-medical"></i>
			<span>Reports</span>
		</a>
	</li>
	<li class="nav-item">
		<a href="{{route('eac.portal.settings')}}" class="nav-link @IndexTab('supporting')">
			<i class="fa-fw text-primary fad fa-tools"></i>
			<span>Supporting Content</span>
		</a>
	</li>
 @endif
</ul>
<hr class="m-3" />
<ul class="nav navbar-nav">
 <li class="nav-item">
  <a href="#" class="nav-link">
   <i class="fa-fw fad fa-flag text-danger"></i>
   <span>Safety Reporting</span>
  </a>
 </li>
 <li class="nav-item">
  <a href="#" class="nav-link">
   <i class="fa-fw fad fa-info-circle text-primary"></i>
   <span>About Us</span>
  </a>
 </li>
 <li class="nav-item">
  <a href="#" class="nav-link">
   <i class="fa-fw fad fa-phone fa-rotate-180 text-primary"></i>
   <span>Contact EAC</span>
  </a>
 </li>
</ul>