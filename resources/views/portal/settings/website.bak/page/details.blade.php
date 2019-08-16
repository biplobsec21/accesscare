@extends('layouts.public')

@section('title')
 Preview Website Content
@endsection
@section('frameshow')
 <div class="static-box">
  <div class="container">
   <div class="card card-body mb-0 pt-2 pb-2 pl-3 pr-3 bg-transparent">
    <div class="row m-0">
     <div class="col p-0">
      <h6 class="upper text-warning m-0">Previewing Website Content</h6>
     </div>
     <div class="col-auto pl-2 pr-0">
      <a href="#" class="removeStaticBox text-warning small">
       <i class="fas fa-times"></i> Remove Frame
      </a>
     </div>
    </div>
    <div class="row align-items-md-center m-0">
     <div class="col-auto col-sm-12 col-md-auto pl-0">
      <a href="{{ route($page['cancelAction']) }}" class="btn btn-secondary btn-sm">
       <i class="fal fa-angle-double-left"></i> Go back
      </a>
      <a class="btn btn-warning btn-sm" title="Edit Page" href="{{route('eac.portal.settings.manage.website.page.edit', $rows->id)}} ">
       <i class="far fa-edit" ></i> Edit Page</span>
      </a>
     </div>
     <div class="col p-0">
      <div class="row">
       <div class="col col-sm col-lg-3">
        <label class="d-block">Content Name</label>
        {{ $rows->name }}
       </div>
       @if($rows->title)
        <div class="d-none d-sm-block col-sm">
         <label class="d-block">Title</label>
         {{ $rows->title}}
        </div>
       @endif
       <div class="col-auto col-sm col-lg-3 col-xl-2 text-sm-right">
        <label class="d-block">Created At</label>
        {{date('Y-m-d', strtotime($rows->created_at)) }}
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
 <p class="text-center mt-1 mb-0">
  <a href="#" class="removeStaticBox">
   <i class="fas fa-arrow-down"></i> Show Frame
  </a>
 </p>
@endsection
@section('content')
 <div class="container">
  {{ csrf_field() }}
  <div class="viewData">
    {!! $rows->content !!}
  </div><!-- /.viewData -->
 </div>
@endsection
@section('scripts')
<script>
$(".alert").delay(2000).slideUp(200, function() {
    $(this).alert('close');
}); 

  </script>
@endsection
