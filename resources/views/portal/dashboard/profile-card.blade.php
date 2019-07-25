@if(\Auth::user()->hasDefaultPassword())
	<div class="bg-white border border-light p-3 h-100">
		<h4 class="strong">
			<a href="{{ route('eac.portal.user.create') }}">Modify Password</a>
		</h4>
		<p class="flex-grow-1 mb-3">
			Temporary password assigned, please update your password information </p>
	</div>
@elseif(!\Auth::user()->certificate && \Auth::user()->type->name == 'Physician')
	<div class="bg-white border border-light p-3 h-100">
		<h4 class="strong">
			<a href="{{ route('eac.portal.user.edit', \Auth::user()->id) }}">Professional Documents</a>
		</h4>
		<p class="flex-grow-1 mb-3">
			Please upload your medical documentation </p>
		<a href="{{ route('eac.portal.user.edit', \Auth::user()->id) }}" class="btn btn-sm btn-primary">Upload Documents</a>
	</div>
@else
	<div class="card">
		<div class="card-body">
			<h5 class="text-xl-center">
				<i class="fa-fw fas fa-user-md text-dark"></i>
				<a class="text-dark" href="{{ route('eac.portal.user.show', \Auth::user()->id) }}">Account Settings</a>
			</h5>
			<p class="text-muted mb-0 small text-xl-center">
				Manage professional documents and company address </p>
		</div>
		<a href="{{ route('eac.portal.user.show', \Auth::user()->id) }}" class="btn btn-dark btn-block btn-lg d-flex justify-content-between align-items-center">
			My Account
			<i class="fa-fw fas fa-user-md"></i>
		</a>
	</div>
@endif
