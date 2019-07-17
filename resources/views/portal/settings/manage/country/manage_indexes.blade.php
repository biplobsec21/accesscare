@extends('layouts.portal')

@section('title')
 Manage Indexes
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
     <a href="{{ url('portal/settings/manage/countries') }}">Country Manager</a>
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
 <form method="post" action="{{route('eac.portal.settings.manage.country.indexes.store')}}" id="country_order_form">
  {{ csrf_field() }}
  <div class="row">
    <ol id="countrySort">
      @foreach($countryList as $country)
        <li class="ui-state-default" id="{{$country->id}}"><i class="fas fa-arrows-v"></i>{{$country->name}}</li>
      @endforeach
    </ol>
    <input name="countries" id="countries" type="hidden"/>
  </div><!-- /.row-->
  <button class="btn btn-success" type="button" id="save_btn">
    <i class="far fa-check"></i> Save Changes
  </button>
 </form>
@endsection
@section('scripts')

<script>
$( function() {
  $( "#countrySort" ).sortable();
  $( "#countrySort" ).disableSelection();
} );


$(document).ready(function () {
  $('#save_btn').click(function () {
    var idsInOrder = $("#countrySort").sortable("toArray");
    $("#countries").val(idsInOrder);
    $("#country_order_form").submit();


  });

});

</script>
@endsection
