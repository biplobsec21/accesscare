<!-- new design -->
@extends('layouts.portal')

@section('title')
	Create User Group
@endsection
@section('styles')
	<style>
		.group-member-template {
			display: none;
		}

		@media screen and (min-width: 1200px) {
			:root {
				--leftCol: 230px;
				--rightCol: 675px;
			}

			.actionBar, .instructions {
				max-width: calc(var(--leftCol) + var(--rightCol));
			}

			.viewData .row.thisone > [class*=col]:first-child {
				width: var(--leftCol);
			}

			.viewData .row.thisone > [class*=col]:last-child {
				width: var(--rightCol);
			}
		}
	</style>
@endsection

@section('instructions')
	instruction
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{route('eac.portal.user.group.list')}}">All User Groups</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					@yield('title')
				</li>
			</ol>
		</nav>
		<h2 class="m-0">
			@yield('title')
		</h2>
	</div><!-- end .titleBar -->
	@php
		if(Session::has('alerts')) {
		 $alert = Session::get('alerts');
		 $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
		 echo $alert_dismiss;
		}
	@endphp
	<form name="" method="POST" action="{{ route('eac.portal.user.group.store') }}">
		{{ csrf_field() }}
		<div class="actionBar">
			<a href="{{ url()->previous() }}" class="btn btn-light">
				<i class="far fa-angle-double-left"></i> Go back
			</a>
		</div><!-- end .actionBar -->

		<div class="viewData">
			<div class="instructions mb-3">
				@yield('instructions')
			</div>
			<div class="row thisone m-0 mb-xl-5">
				<div class="col-sm-3 col-xl-auto p-0 pr-sm-2 mb-2 mb-sm-0">
					<div class="wizardSteps nav flex-row flex-sm-column" id="tab" role="tablist"
					     aria-orientation="vertical">
						<a class="nav-link active" id="one-tab" data-toggle="pill" href="#one" role="tab"
						   aria-controls="one" aria-selected="true">
							<span>Group Details</span>
						</a>
						<a class="nav-link" id="xusers-tab" data-toggle="pill" href="#xusers" role="tab"
						   aria-controls="xusers" aria-selected="false">
							<span>Assign Users</span>
						</a>
					</div>
				</div>
				<div class="col-sm-7 col-lg-6 col-xl-auto p-0 pl-sm-2">
					<div class="card tab-content wizardContent" id="tabContent">
						<div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">
							<div class="card-body">
								<h5 class="mb-3">
									Please provide Group <strong>details</strong>
								</h5>
								<div class="mb-3">
									<label class="d-block label_required">Group Name</label>
									<input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
									       name="name" value="{{old("name")}}"/>
									<div class="invalid-feedback">
										{{ $errors->first('name') }}
									</div>
								</div>
								<div class="row">
									<div class="col-sm mb-3">
										<label class="d-block label_required">Group Leader</label>
										<select name="parent_id" id="parent_id"
										        class="form-control select2 {{ $errors->has('parent_id') ? ' is-invalid' : '' }}">
											<option disabled hidden selected value="">-- Select --</option>
											@foreach($users as $user)
												<option value="{{ $user->id }}"
												        data-type="{{ $user->type->id }}" {{ (old('parent_id') && old('parent_id') == $user->id) ? 'selected' : '' }}>{{ $user->full_name }}
													({{ $user->email }})
												</option>
											@endforeach
										</select>
										<div class="invalid-feedback">
											{{ $errors->first('parent_id') }}
										</div>
									</div>
									<div class="col-sm col-lg-5 mb-3">
										<label class="d-block label_required">Type of Group</label>
										<select name="type_id" id="type_select"
										        class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}">
											<option disabled hidden selected value="">-- Select --</option>
											@foreach(\App\UserType::all()->sortBy('name') as $type)
												<option
													value="{{ $type->id }}" {{ (old('type_id') && old('type_id') == $type->id) ? 'selected' : '' }}>{{ $type->name }}</option>
											@endforeach
										</select>
										<div class="invalid-feedback">
											{{ $errors->first('type_id') }}
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer d-flex justify-content-end">
								<a href="#" class="next btn btn-info">
									Continue <i class="fal fa-angle-double-right"></i>
								</a>
							</div>
						</div><!-- /.tab-pane -->
						<div class="tab-pane fade" id="xusers" role="tabpanel" aria-labelledby="xusers-tab">
							<div class="card-body">
								<h5 class="mb-3">
									Group Users
								</h5>
								<div class="table-responsive">
									<table class="table table-sm table-striped table-hover">
										<thead>
										<tr>
											<th>Name</th>
											<th>Role</th>
											<th></th>
										</tr>
										</thead>
										<tbody id="memberSection">
										</tbody>
									</table>
								</div>
								<div class="d-flex justify-content-between mt-3">
									<a href="#" class="btn btn-link" id="addMemberBtn" onclick="addMember()">
										<i class="fal fa-plus"></i> Add Existing User
									</a>
									<a href="{{ route('eac.portal.user.create') }}" target="_blank"
									   class="btn btn-secondary">
										<i class="fa-fw fal fa-user-plus"></i> Add New User
									</a>
								</div>
							</div>
							<div class="card-footer d-flex justify-content-end">
								<button class="btn btn-success " type="submit">
									<i class="fas fa-check"></i> Save Group
								</button>
							</div>
						</div><!-- /.tab-pane -->
					</div>
				</div>
			</div>
		</div><!-- /.viewData -->
	</form>
	<table>
		<tr class="group-member group-member-template">
			<td>
				<span class="read" style="display: none"></span>
				<select class="form-control update" name="member[0]">
					<option disabled hidden selected value="">-- Select --</option>
					@foreach($users as $user)
						<option value="{{$user->id}}" data-typeid="{{ $user->type_id }}">{{ $user->full_name }}</option>
					@endforeach
				</select>
			</td>
			<td>
				<span class="read" style="display: none"></span>
				<select class="form-control update" name="role[0]">
					<option disabled hidden selected value="">-- Select --</option>
					@foreach(\App\Role::all()->sortBy('name') as $role)
						<option value="{{$role->id}}" data-typeid="{{ $role->type_id }}">{{ $role->name }}</option>
					@endforeach
				</select>
			</td>
			<td>
				<a class="text-info view update" href="#">
					<i class="fas fa-eye"></i>
				</a>
				<a class="text-info edit read" href="#" style="display: none">
					<i class="fas fa-edit"></i>
				</a>
				<a class="text-danger remove" href="#">
					<i class="fas fa-times"></i>
				</a>
			</td>
		</tr>
	</table>
@endsection

@section('scripts')
	<script>
        function setWizardStep(n) {
            $('.wizardSteps a.nav-link:nth-child(' + (n + 1) + ')').click();
        }

        $(document).ready(function () {
            $("a.next").click(function () {
                let currentLink = $('.nav-link.active');
                setWizardStep(currentLink.index() + 1);
            });

            $("#parent_id").on('change', function () {

                let $type_id = $('option:selected', this).attr('data-type');
                let $groupSection = $("#type_select");

                $groupSection.val($type_id);
                $('#addMemberBtn').removeClass("disabled");
                let $memberSection = $(".group-member");
                $memberSection.find('select').each(function () {
                    $(this).val($(this).find("option:first").val());
                });
                $memberSection.find('option').each(function () {
                    if ($(this).data('typeid') === $type_id)
                        $(this).show();
                    else
                        $(this).hide();
                });
            });
            // On start, filter the selects for relevant data
            $(".group-member").find('option').each(function () {
                if ($(this).data('typeid') === $("#type_select").val())
                    $(this).show();
                else
                    $(this).hide();
            });
            // On remove button click, remove a group member
            $(document).on('click', 'a.remove', function (e) {
                $(this).closest('.group-member').remove();
                let $count = 0;
                $('#memberSection').find('.group-member').each(function () {
                    $(this).find('select[name^="member"]').attr('name', 'member[' + $count + ']');
                    $(this).find('select[name^="role"]').attr('name', 'role[' + $count + ']');
                    $count++;
                });
            });

            // On edit button click, edit a group member
            $(document).on('click', 'a.edit', function (e) {
                let $member = $(this).closest('.group-member');
                $member.find('.read').hide();
                $member.find('.update').show();
            });

            // On view button click, view a group member
            $(document).on('click', 'a.view', function (e) {
                let $member = $(this).closest('.group-member');
                $member.find('.read').show();
                $member.find('.update').hide();
            });

            // On edit all button click, edit all group members
            $(document).on('click', 'a.view-all', function (e) {
                let $member = $(this).closest('.card-body');
                $member.find('.read').hide();
                $member.find('.update').show();
            });


            // On view all button click, view all group members
            $(document).on('click', 'a.view-all', function (e) {
                let $member = $(this).closest('.card-body');
                $member.find('.read').show();
                $member.find('.update').hide();
            });

            // On input change, change a group member
            $(document).on('change', '.update', function (e) {
                $(this).parent().find('.read').text($(this).find("option:selected").text());
            });

            // On Type Change
            $("#type_select").change(function () {
                let $type_id = $(this).val();
                let $memberSection = $(".group-member");
                $memberSection.find('select').each(function () {
                    $(this).val($(this).find("option:first").val());
                });
                $memberSection.find('option').each(function () {
                    if ($(this).data('typeid') === $type_id)
                        $(this).show();
                    else
                        $(this).hide();
                });
            });
        });

        function addMember() {
            let $template = $('.group-member.group-member-template');
            let $memberSection = $("#memberSection");
            $memberSection.append($template.prop('outerHTML'));
            let $newMember = $memberSection.find(".group-member:last");
            $newMember.removeClass('group-member-template');
            const $count = $memberSection.find(".group-member").length - 1;
            $newMember.find('select[name^="member"]').attr('name', 'member[' + $count + ']');
            $newMember.find('select[name^="role"]').attr('name', 'role[' + $count + ']');
        }
	</script>
@endsection



