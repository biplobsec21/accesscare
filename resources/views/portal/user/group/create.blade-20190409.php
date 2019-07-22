@extends('layouts.portal')

@section('title')
	Create Group
@endsection

@section('content')
	<div class="titleBar">
		<div class="row justify-content-between">
			<div class="col-md col-lg-auto">
				<h2 class="m-0">
					Create Group
				</h2>
			</div>
			<div class="col-md col-lg-auto ml-lg-auto">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active" aria-current="page">
						Create Group
					</li>
				</ol>
			</div>
		</div>
	</div><!-- end .titleBar -->
	<form method="post" action="{{ route('eac.portal.user.group.store') }}">
		{{ csrf_field() }}
		<div class="viewData">
			<div class="row m-b-10">
				<div class="col-xl-12">
					<div class="card m-b-30">
						<div class="card-header bg-secondary p-10">
							<a class="btn btn-warning" href="{{ route('eac.portal.user.group.list') }}">
								All Groups
							</a>
							<button class="btn btn-success">
								Save
							</button>
						</div>
						<div class="card-body p-10">
							<select name="type" class="form-control">
								<option hidden>Type</option>
								<option value="Early Access Care">
									Early Access Care
								</option>
								<option value="Physician">
									Physician
								</option>
								<option value="Pharmaceutical">
									Pharmaceutical
								</option>
							</select>
							<select name="parent_id" class="form-control">
								<option hidden>Parent User</option>
								@foreach($users as $user)
									<option value="{{ $user->id }}">{{ $user->full_name }}</option>
								@endforeach
							</select>
							<select name="group_members[]" class="form-control select2" multiple>
								@foreach($users as $user)
									<option value="{{ $user->id }}">{{ $user->full_name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection

@section('scripts')
	<script>
		$('.select2').select2({
			placeholder: 'Select Members'
		});
	</script>
@endsection



