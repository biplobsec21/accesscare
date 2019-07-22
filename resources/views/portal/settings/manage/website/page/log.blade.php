@extends('layouts.portal')

@section('title')
 Change Log
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.settings.manage.website.page.index') }}"> Website Content Manager</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
     @yield('title')
    </li>
   </ol>
  </nav>
  <h2 class="m-0">
   Website Content Manager  <small>@yield('title')</small>
  </h2>
 </div><!-- end .titleBar -->
 @php
  if(Session::has('alerts')) {
   $alert = Session::get('alerts');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
 @endphp
 <div class="actionBar">
  <a href="{{ route($page['createButton']) }}" class="btn btn-success">
   <i class="fal fa-prescription"></i> Add New
  </a>
  <a href="{{ route($page['listAll']) }}" class="btn btn-primary">
   <i class="fal fa-list"></i> Return to List
  </a>
 </div><!-- end .actionBar -->

 <div class="viewData">
  <div class="card mb-1 mb-md-4">
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover">
     <thead>
      <tr>
       <th>
        Content Identifier
       </th>
       <th>
       Titile
       </th>
       <th>
        Menu Name
       </th>
       <th class="text-center">
        Changes
       </th>
       <th>
        Last Updated
       </th>
       <th class="no-sort"></th>
      </tr>
     </thead>
     <tbody>
      @if($logData)
       @foreach($logData as $val)
        <tr data-id="{{$val->id}}">
         @php $dosages= \App\Page::where('id','=',$val->id)->firstOrFail(); @endphp
        
         <td>
          {{  $dosages && isset($dosages->name) ? $dosages->name : ''  }}
         </td>
         <td>
          {{  $dosages && isset($dosages->title) ? $dosages->title : ''  }}
         </td>
         <td>
          {!!   $wbinstance->has_parent_menu($dosages)   !!}
         </td>
         <td class="text-center">
          <span class="badge badge-secondary">{{ $val->total_action }}</span>
         </td>
         <td>{{  $dosages && isset($dosages->updated_at) ? $dosages->updated_at : ''  }}</td>
         <td>
          <a href="{{ route($page['logsviewr'],$val->id) }}">
           <i class="far fa-search-plus" aria-hidden="true"></i> <span class="sr-only">View</span>
          </a>
         </td>
        </tr>
       @endforeach
      @endif

     </tbody>
    </table>
   </div>
  </div>
 </div>
</div><!-- end .viewData -->
@endsection
@section('scripts')
<script>
 $(document).ready(function () {

  $("#-datatble-").on("click", function () {
   
  });

 });

  
 function ConfirmDelete(param){
    
 }
</script>
@endsection


