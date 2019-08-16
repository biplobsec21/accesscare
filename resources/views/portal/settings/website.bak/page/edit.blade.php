@extends('layouts.portal')

@section('title')
 Edit Content
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
     <a href="{{ route('eac.portal.settings.manage.website.page.index') }}">Website Content Manager
    </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
     @yield('title')
    </li>
   </ol>
  </nav>
  <h6 class="m-0 small">
   @yield('title')
  </h6>
  <h2 class="m-0">
   {{$rows->name}}
  </h2>
 </div><!-- end .titleBar -->
 <form method="post" action="{{ route($page['updateAction'],request()->route('id')) }}">
  {{ csrf_field() }}
  <div class="row">
   <div class="col-lg-10 col-xl-8">
    @include('include.alerts')
    <div class="actionBar">
     <a href="{{ route($page['cancelAction']) }}" class="btn btn-warning">
      <i class="fa-fw far fa-times"></i> Cancel
     </a>
     <button type="submit" href="{{ route($page['updateAction'],request()->route('id')) }}" class=" btn btn-info" >
      <i class="fa-fw far fa-check"></i> Apply
     </button>
     <a href="{{route('eac.portal.settings.manage.website.page.detail', $rows->id)}}" class="btn btn-primary">
      <i class="fa-fw far fa-external-link"></i> Preview Page
     </a>
    </div><!-- end .actionBar -->
   </div>
  </div><!-- /.row -->

  <div class="viewData">
   <div class="mb-3 mb-xl-4">
    <div class="card card-body mb-0">
     <div class="row">
      <div class="order-1 col mb-3 mb-sm-4">
       <label class="d-block label-required">Content Name</label>
       <input name="name" type="text" id="name_" value="{{ old('name') ? old('name') : $rows->name }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
       <div class="invalid-feedback">
        {{ $errors->first('name') }}
       </div>
      </div>
      <div class="order-lg-2 d-none d-lg-block col-lg mb-3 mb-sm-4">
       <label class="d-block label_required">Slug</label>
       <input name="slug" type="text" id="slug" readonly="true" value="{{ old('slug') ? old('slug') : $rows->name }}" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}">
       <div class="invalid-feedback">
        {{ $errors->first('slug') }}
       </div>
      </div>
      <div class="order-3 order-sm-2 order-lg-3 col-sm mb-3 mb-sm-4">
       @php
        use App\Menu;
        $menu = new Menu();
        $all_menus = $menu->selectBoxMaker($menu_data, true);
       @endphp
       <label class="d-block">Menu</label>
       <select name="menu_id" id="menu_" class="form-control {{ $errors->has('form_id') ? ' is-invalid' : '' }}">
        <option value="0">Select Menu</option>
        @if($all_menus)
         @foreach($all_menus as $amenu)
          @if($amenu['id'] != '001aefrgth')
           <option value="{{ $amenu['id'] }}" {{ $rows->menu_id == $amenu['id'] ? 'selected="selected"' : '' }}>{!! $amenu['value'] !!}</option>
          @endif
         @endforeach
        @endif
       </select>
      </div>
      <div class="order-2 order-lg-4 col-auto mb-3 mb-sm-4">
       <label class="d-block">Status</label>
       <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" data-width="100" name="active" {{ !empty($rows) && ($rows->active == '1' ) ? 'checked'  : '' }} />
      </div>
     </div><!-- /.row -->
     <div class="mb-3 mb-sm-4">
      <label class="d-block">Title</label>
      <input name="title" type="text" value="{{ old('title') ? old('title') : $rows->title }}" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
      <div class="invalid-feedback">
       {{ $errors->first('title') }}
      </div>
     </div>

     <div class="mb-3 mb-sm-4">
      <label class="d-block">Page Body</label>
      <textarea class="form-control editor" name="content" rows="15">{{ old('content') ? old('content') : $rows->content }}</textarea>
     </div><!-- /.row -->
     <div class="row">
      <div class="col-lg mb-3 mb-sm-4">
       <label class="d-block">Meta Description</label>
       <textarea class="form-control " name="meta_desc" >{{ old('meta_desc') ? old('meta_desc') : $rows->meta_desc }}</textarea>
      </div>
      <div class="col-lg mb-3 mb-sm-4">
       <label class="d-block">Meta Keyword</label>
       <textarea class="form-control " name="meta_keywords">{{ old('meta_keywords') ? old('meta_keywords') : $rows->meta_keywords }}</textarea>
      </div>
     </div>
    </div>
    <div class="card-footer d-flex justify-content-center">
     <button class="btn btn-success" type="submit" href="{{ route($page['updateAction'],request()->route('id')) }}">
      <i class="far fa-check"></i> Update
     </button>
    </div>
   </div>
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
  let menu_name = "";
  if($("#menu_ option:selected").text() === 'Select Menu'){
  menu_name = "no-menu";
  }else{
  menu_name = $("#menu_ option:selected").text().replace(/\s+/g, '-').toLowerCase();
  }


  $("#slug").val(name+"-"+menu_name);

  $("#menu_").change(function(){
 name = $("#name_").val().replace(/\s+/g, '-').toLowerCase();

 if($("#menu_ option:selected").text() === 'Select Menu'){
   menu_name = "no-menu";
 }else{
   menu_name = $("#menu_ option:selected").text().replace(/\s+/g, '-').toLowerCase();
 }

 $("#slug").val(name+"-"+menu_name);

  })

  $('#name_').on('change',function(){
   name = $("#name_").val().replace(/\s+/g, '-').toLowerCase();
   if($("#menu_ option:selected").text() === 'Select Menu'){
  menu_name = "no-menu";
   }else{
  menu_name = $("#menu_ option:selected").text().replace(/\s+/g, '-').toLowerCase();
   }
   $("#slug").val(name+"-"+menu_name);
  });

});
</script>
  </script>
@endsection
