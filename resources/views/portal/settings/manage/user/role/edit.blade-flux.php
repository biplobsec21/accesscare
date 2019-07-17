@extends('layouts.portal')

@section('title')
 Manage Permissions
@endsection

@section('styles')
 <style>
  #manage-role-table td div.checkmark {
   cursor: pointer;
   height: 35px;
   margin-top: -42px;
  }
  #manage-role-table input:checked ~ div.checkmark {
   background-color: #2196F3;
  }

  #manage-role-table td input {
   position: relative;
   opacity: 0;
   cursor: pointer;
   height: 35px;
   width: 100%;
  }


  #manage-role-table th {
   cursor: pointer;
  }

  #manage-role-table thead th, #manage-role-table tbody th,
  #manage-role-table tbody td {
   padding: 0;
   border: 1px solid rgba(0,0,0,0.25);
  }

  #manage-role-table thead th.table-title {
   text-transform: unset;
   color: black;
   font-weight: 400;
   line-height: inherit;
   font-size: 1.25rem;
  }

  @media screen and (min-width: 1200px) {
   :root {
    --leftCol: 250px;
    --rightCol: 675px;
   }

   .actionBar, .viewData {
    max-width: calc(var(--leftCol) + var(--rightCol));
   }

   .viewData .row.thisone > [class*=col]:first-child {
    max-width: var(--leftCol);
    min-width: var(--leftCol);
   }

   .viewData .row.thisone > [class*=col]:last-child {
    max-width: var(--rightCol);
    min-width: var(--rightCol);
   }
  }

  @media screen and (min-width: 1400px) {
   html {
    --rightCol: 800px;
   }
  }
 </style>
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <div class="row">
    <div class="col-sm-auto">
     <ol class="breadcrumb">
      <li class="breadcrumb-item">
       <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
      </li>
      <li class="breadcrumb-item">
       <a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
      </li>
      <li class="breadcrumb-item">
       <a href="{{ route('eac.portal.settings.manage.user.role') }}">Role Manager</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
       @yield('title')
      </li>
     </ol>
    </div>
    <div class="d-none d-sm-block col-sm-auto ml-sm-auto">
     <div class="small">
      <strong>Last Updated:</strong>
      @php
       $time = $role->updated_at;
       $time->tz = "America/New_York";
       echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
      @endphp
     </div>
    </div>
   </div>
  </nav>
  <h6 class="small upper m-0">
   @yield('title')
  </h6>
  <h2 class="m-0">
   {{$role->name}}
  </h2>
  <div class="small d-sm-none">
   <strong>Last Updated:</strong>
   @php
    $time = $role->updated_at;
    $time->tz = "America/New_York";
    echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
   @endphp
  </div>
 </div><!-- end .titleBar -->
 @if(Session::has('alerts'))
  {!! view('layouts.alert-dismiss', ['type' => Session::get('alerts')['type'], 'message' => Session::get('alerts')['msg']]) !!}
 @endif
 <form method="post" action="{{ route('eac.portal.settings.manage.user.role.save') }}">
  @csrf
  <div class="viewData">
   <div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
    <a href="{{ route('eac.portal.settings.manage.user.role') }}" class="btn btn-light">
     <i class="fa-fw fas fa-arrow-left"></i> Return to Role Manager
    </a>
    <div>
     <button class="btn btn-success" type="submit">Save All Permissions</button>
    </div>
   </div>
   <div class="row thisone m-0 mb-xl-5">
    <div class="col-sm-3 col-xl-auto mb-2 mb-sm-0 p-0">
     <div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist" aria-orientation="vertical">
      @php $i = 0 @endphp
      @foreach($permissions as $area => $sections)
       <a class="nav-link @if($role->hasArea($area)) complete @endif " data-toggle="pill"
          href="#x{{strtolower($area)}}" role="tab" id="x{{strtolower($area)}}T"
          aria-controls="x{{strtolower($area)}}" aria-selected="false">
        @if($role->hasArea($area))
         <strong>{{ucfirst($area)}}</strong>
        @else
         <span>{{ucfirst($area)}}</span>
        @endif
       </a>
       @php $i++ @endphp
      @endforeach
     </div>
    </div>
    <div class="col-sm-9 col-xl p-0">
     <div class="card tab-content wizardContent" id="tabContent">
						@php $i = 0 @endphp
						@foreach($permissions as $area => $sections)
							<div class="tab-pane fade m-2" id="x{{strtolower($area)}}" role="tabpanel"
								 aria-labelledby="x{{strtolower($area)}}-tab">
								<div class="h4 m-4">{{ucfirst($area)}} Permissions</div>
								<table class="table table-sm" id="manage-role-table">
									<thead>
									<tr>
										<th class="table-title"></th>
										<th data-col-control="view" class="text-center">
           <h5 class="text-dark m-0">View</h5>
          </th>
										<th data-col-control="update" class="text-center">
           <h5 class="text-dark m-0">Update</h5>
          </th>
										<th data-col-control="create" class="text-center">
           <h5 class="text-dark m-0">Create</h5>
          </th>
										<th data-col-control="delete" class="text-center">
           <h5 class="text-dark m-0">Delete</h5>
          </th>
									</tr>
									</thead>
									<tbody>
									@foreach($sections as $section => $values)
										<tr>
											<th data-row-control="{{$section}}" class="text-right">{{ucfirst($section)}}</th>
											<td>
												<input name="level[{{$area}}][{{$section}}][view]" data-row="{{$section}}" data-col="view" value="1" type="checkbox" {{$role->can([$area, $section, 'view']) ? 'checked' : ''}}>
												<div class="checkmark"></div>
											</td>
											<td>
												<input name="level[{{$area}}][{{$section}}][update]" data-row="{{$section}}" data-col="update" value="1" type="checkbox" {{$role->can([$area, $section, 'update']) ? 'checked' : ''}}>
												<div class="checkmark"></div>
											</td>
											<td>
												<input name="level[{{$area}}][{{$section}}][create]" data-row="{{$section}}" data-col="create" value="1" type="checkbox" {{$role->can([$area, $section, 'create']) ? 'checked' : ''}}>
												<div class="checkmark"></div>
											</td>
											<td>
												<input name="level[{{$area}}][{{$section}}][delete]" data-row="{{$section}}" data-col="delete" value="1" type="checkbox" {{$role->can([$area, $section, 'delete']) ? 'checked' : ''}}>
												<div class="checkmark"></div>
											</td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>
							@php $i++ @endphp
						@endforeach
					</div>
				</div>
			</div>
			<input type="hidden" name="role_id" value="{{$role->id}}"/>
		</form>
	</div><!-- end .viewData -->
@endsection
@section('scripts')
	<script>
		$(document).on('click', '#manage-role-table th', function (e) {

			if ($(this).data('row-control')) {
				let boxes = $(this).parents('table').find('td input[data-row="' + $(this).data('row-control') + '"]');
				let boxCount = boxes.length;
				let checkCount = boxes.filter(':checked').length;

				if (checkCount === boxCount || checkCount === 0)
					boxes.click();
				else
					$(boxes).each(function () {
						if (!this.checked)
							$(this).click();
					});
			}

			if ($(this).data('col-control')) {
				let boxes = $(this).parents('table').find('td input[data-col="' + $(this).data('col-control') + '"]');
				let boxCount = boxes.length;
				let checkCount = boxes.filter(':checked').length;

				if (checkCount === boxCount || checkCount === 0)
					boxes.click();
				else
					$(boxes).each(function () {
						if (!this.checked)
							$(this).click();
					});
			}
		});
	</script>
@endsection
