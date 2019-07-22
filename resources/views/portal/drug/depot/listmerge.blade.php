@extends('layouts.portal')
@SetTab('depots')

@section('title')
	 Merge Depots
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{route('eac.portal.depot.list.all')}}">All Depots</a>
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
 @php
  if(Session::has('alerts_merge')) {
   $alert = Session::get('alerts_merge');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
 @endphp
 <form method="post" action="{{ route('eac.portal.depot.list.mergeselect') }}">
  {{ csrf_field() }}
 	<div class="actionBar">
   <a href="{{ route('eac.portal.depot.list.all') }}" class="btn btn-success">
    <i class="fa-fw fas fa-warehouse-alt"></i> List  Depots
   </a>
   <button class="btn btn-primary" type="submit">
    <i class="far fa-check"></i> Merge Selected
   </button>
 	</div><!-- end .actionBar -->
 	<div class="viewData">
   <div class="card mb-1 mb-md-3">
    <div class="table-responsive">
     <table class="table  table-sm table-striped table-hover" id="depotListTBL">
 					<thead>
  					<tr>
        <th class="no-sort">Primary</th>
        <th class="no-sort">Merge</th>
        <th>Name</th>
  						<th>Lots</th>
  						<th>Address</th>
  						<th>Country</th>
  						<th>Created At</th>
  					</tr>
 					</thead>
 					<tbody>
  					@foreach($depots as $depot)
  						<tr>
         <td><input type="radio" name="primary" value="{{ $depot->id }}" /></td>
         <td><input type="checkbox" name="merge[]" value="{{ $depot->id }}" /></td>
  							<td>{{ $depot->name }}</td>
  							<td>{{ $depot->lots->count() }}</td>
  							<td>{!! $depot->address->strDisplayShort() !!}</td>
  							<td>@php try{ echo $depot->address->country->name; } catch (\Exception $e) {} @endphp</td>
  							<td>{{ $depot->created_at }}</td>
  							{{-- <td class="text-right">
                 <a title="Edit Depot" href="{{ route('eac.portal.depot.edit', $depot->id) }}">
  									<i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Depot</span>
  								</a>
  							</td> --}}
  						</tr>
  					@endforeach
 					</tbody>
 				</table>      
    </div>      
 	</div>
  <div class="  col-sm-10 col-md-3 col-lg-3">
  </div>
 	</div><!-- end .viewData -->
 </form>
@endsection

@section('scripts')
<script type="text/javascript">
    $('#depotListTBL').DataTable({
      responsive: false,
      paginationOptions: [10, 25, 50, 75, 100],
      order: [2, "desc"],
      columnDefs: [{
        targets: 'no-sort',
        orderable: false,
      }],
      fnDrawCallback: function () {
        jQuery("input[data-toggle='toggle']").bootstrapToggle();
      }
    });
</script>
@endsection
