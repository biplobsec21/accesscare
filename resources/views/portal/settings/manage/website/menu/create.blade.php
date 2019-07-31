@extends('layouts.portal')
<style>
  .label_required:after {
   content:"*";
   color:red;
}
</style>
@section('title')
 Create Menu
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
     <a href="{{ route('eac.portal.settings.manage.website.menu.index') }}">Website Menu Manager</a>
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
 <form method="post" action="{{ route($page['storeAction']) }}">
  {{ csrf_field() }}
  <div class="row">
   <div class="col-lg-10 col-xl-8">
    @include('include.alerts')
    <div class="actionBar">
     <a href="{{ route($page['cancelAction']) }}" class="btn btn-warning">
      <i class="far fa-times"></i> Cancel
     </a>
     <button type="submit" href="{{ route($page['storeAction']) }}" class=" btn btn-info" >
      <i class="far fa-check"></i> Apply
     </button>
    </div><!-- end .actionBar -->
   </div>
  </div><!-- /.row -->

  <div class="viewData">
   <div class="row">
    <div class="col-lg-8 col-xl-6">
     <div class="mb-3 mb-xl-4">
      <div class="card card-body mb-0">

       <div class="row">
         <div class="col-sm-8 col-md col-lg-6 mb-3">
         <label class="d-block label_required">Name</label>
         <input name="name" type="text" id="name_" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required="required">
         <div class="invalid-feedback">
          {{ $errors->first('name') }}
         </div>
        </div>
        <div class="col-sm-8 col-md col-lg-6 mb-3">
         <label class="d-block label_required">Slug</label>
         <input name="slug" type="text" id="slug" value="{{ old('slug') }}" readonly="true" class="form-control {{ $errors->has('slug') ||  $errors->has('slug') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('slug') }}
         </div>
        </div>

        
       </div><!-- /.row -->
        @php
          use App\Menu;
          $menu = new Menu();
          $all_menus = $menu->selectBoxMaker($menu_data, true);
        @endphp
       <div class="row">
         <div class="col-sm-8 col-md col-lg-6 mb-3">
         <label class="d-block">Parent Menu</label>
         <select name="parent_menu" id ="menu_" class="form-control {{ $errors->has('form_id') ? ' is-invalid' : '' }}">
                  @if($all_menus)
                  @foreach($all_menus as $amenu)
                      <option value="{{ $amenu['id'] }}">{!! $amenu['value'] !!}</option>
                  @endforeach
                  @endif
              </select>
         <div class="invalid-feedback">
          {{ $errors->first('form_id') }}
         </div>
        </div>

        <div class="col-sm-8 col-md col-lg-6 mb-3">
         <label class="d-block">Route</label>
         <input name="route" type="text" value="{{ old('route') }}" class="form-control {{ $errors->has('route') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('route') }}
         </div>
        </div>
       </div>

       <div class="row">

        <div class="col-sm-8 col-md col-lg-6 mb-3">
         <label class="d-block">Sequence</label>
         <input name="sequence" type="number" value="{{ old('sequence') }}" class="form-control {{ $errors->has('sequence') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('sequence') }}
         </div>
        </div>

        <div class="col-sm col-md-auto mb-3">
         <label class="d-block">Status</label>
         <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active"  data-onstyle="success" data-offstyle="primary" data-width="100" name="active" checked />
        </div>

       </div><!-- /.row -->
      </div>
      <div class="card-footer d-flex justify-content-center">
       <button class="btn btn-success{{ $active == 'dosage' ? 'active after' : ''}}" type="submit" href="{{ route($page['storeAction']) }}">
        <i class="far fa-check"></i> Submit
       </button>
      </div>
     </div>
    </div>
   </div><!-- /.row -->
  </div><!-- /.viewData -->
 </form>

@endsection
@section('scripts')
<script>
$(".alert").delay(2000).slideUp(200, function() {
    $(this).alert('close');
});
$(document).ready(function () {

 // set up slug value

  let name = $("#name_").val().replace(/\s+/g, '-').toLowerCase();
  let menu_name = $("#menu_ option:selected").text().replace(/\s+/g, '-').toLowerCase();

  $("#slug").val(name+"-"+menu_name);

  $("#menu_").change(function(){
    name = $("#name_").val().replace(/\s+/g, '-').toLowerCase();
    menu_name = $("#menu_ option:selected").text().replace(/\s+/g, '-').toLowerCase();
    $("#slug").val(name+"-"+menu_name);

  })

  $('#name_').on('change',function(){
      name = $("#name_").val().replace(/\s+/g, '-').toLowerCase();
      menu_name = $("#menu_ option:selected").text().replace(/\s+/g, '-').toLowerCase();
      $("#slug").val(name+"-"+menu_name);
  });


});

  </script>
@endsection
