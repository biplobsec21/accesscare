@extends('layouts.portal')

@section('title')
 Website Page Content Manager Details
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
     <a href="{{ route('eac.portal.settings.manage.website.page.index') }}"> Website Page Content Manager 
    </a>
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
  {{ csrf_field() }}
  <div class="row">
   <div class="col-lg-10 col-xl-8">
    @php
     if(Session::has('alerts')) {
      $alert = Session::get('alerts');
      $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
      echo $alert_dismiss;
     }
    @endphp
    <div class="actionBar">
     <a href="{{ route($page['cancelAction']) }}" class="btn btn-warning">
      <i class="far fa-arrow-left"></i> Go back
     </a>
    <a  class="btn btn-success" title="Edit Page" href="{{route('eac.portal.settings.manage.website.page.edit', $rows->id)}} ">
       <i class="far fa-edit" ></i> Edit Page</span>
    </a>
    </div><!-- end .actionBar -->
   </div>
  </div><!-- /.row -->

 <div class="viewData">
   <div class="row">
    <div class="col-lg-10 col-xl-10">
     <div class="mb-3 mb-xl-4">
      <div class="card card-body mb-0">
       <div class="row">
         <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
         <label class="d-block">Content Identifier:</label>
         {{ $rows->name }}
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
         <label class="d-block">Menu: </label>
          @php
            use App\Menu;
            $string="";
            $menu_id = $rows->menu_id;

            // find parent menu
            $parent_id=Menu::where('id',$rows->menu_id)->first();

            if($parent_id){
                
                $parent_menu_id=Menu::where('id',$parent_id->parent_menu)->first();
                if($parent_menu_id){
                     $string .= $parent_menu_id->name;
                     $string .= ' <i class="fas fa-arrow-right"></i> '.$parent_id->name;
                }else{
                     $string .= $parent_id->name;
                }
            }else{
                echo  'Not Assign';
            }

            echo $string;


          @endphp
        </div>
       </div><!-- /.row -->

       <div class="row">
         <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
         <label class="d-block">Title</label>
         {{ $rows->title}}
        </div>
       </div>

       <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 mb-3 p-10 bg-light">
         <label class="d-block">Page Content</label>
         {!! $rows->content !!}
        </div>
       </div><!-- /.row -->
       <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 mb-3 p-10 bg-light">
         <label class="d-block">Meta Description</label>
         {!! $rows->meta_desc  !!} 
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 mb-3 p-10 bg-light">
         <label class="d-block">Meta Keyword</label>
          {!! $rows->meta_keywords !!}

        </div>
       </div>
       <div class="row">
        <div class="col-sm col-md-auto mb-3">
         <label class="d-block">Created At</label>
            {{ $rows->created_at }}
        </div>
       </div><!-- /.row -->
      </div>
      
     </div>
    </div>
   </div><!-- /.row -->
  </div><!-- /.viewData -->

@endsection
@section('scripts')
<script>
$(".alert").delay(2000).slideUp(200, function() {
    $(this).alert('close');
}); 

  </script>
@endsection
