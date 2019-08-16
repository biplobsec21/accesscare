<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="eacApp">
<head>
 <meta charset="utf-8"/>
 <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>
 <!-- CSRF Token -->
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <title>
 @yield('title') | Early Access Care </title>
 <link rel="shortcut icon" href="{{ asset('/images/favicon/favicon.ico') }}"/>
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
 <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"/>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/css/bootstrap-select.css"/>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css"/>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.css"/>
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css"/>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"/>
 @yield('styles')
 <link rel="stylesheet" href="{{ asset('/css/eac-app.css') }}">
 <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.1/css/all.css" integrity="sha384-y++enYq9sdV7msNmXr08kJdkX4zEI1gMjjkw0l9ttOepH7fMdhb7CePwuRQCfwCr" crossorigin="anonymous">
 <link rel="stylesheet" href="{{ asset('css/core.css') }}"/>
 <link rel="stylesheet" href="{{ asset('/css/select2-custom.css') }}">
 <link rel="stylesheet" href="{{ asset('/css/forms.css') }}">
 <link rel="stylesheet" href="{{ asset('/css/portals.css') }}">
 <link rel="stylesheet" href="{{ asset('/css/media.css') }}">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.js"></script>
</head>
<body id="page-top">
 @include('include.portal.head')
 @if(session('is_emulating'))
  <div id="LIA" class="text-center text-lg-left m-0">
   <div class="row align-items-center">
    <div class="col-auto pr-sm-0">
     Signed in as:
    </div>
    <div class="col-sm-auto">
     <ul class="nav mb-1 mb-sm-0">
      @foreach(session('emu_data.history') as $k => $v)
       @php
        $user = \App\User::where('id', '=', $v)->firstOrFail();
       @endphp
       <li class="nav-item m-l-10">
        <a href="{{route('eac.auth.emu.stop')}}">
         <strong>{{$user->full_name}}</strong>
        </a>
       </li>
      @endforeach
      <li class="nav-item m-l-10">
       <a href="{{route('eac.portal.user.show', Auth::user()->id)}}">
        <strong>{{Auth::user()->full_name}}</strong>
       </a>
      </li>
     </ul>
    </div>
    <div class="col-auto ml-auto pl-sm-0">
     <a href="{{route('eac.auth.emu.stop')}}" class="btn btn-sm btn-info">
      Signout of {{Auth::user()->first_name}}
     </a>
    </div>
   </div>
  </div>
 @endif
 <div class="container-fluid flex-grow-1" id="cc_main">
  @yield('precontent')
  <div id="pcont">
   @if (session('confirm'))
    <div class="alert alert-success">
     {!! session('confirm') !!}
    </div>
   @endif
   @if (session('warning'))
    <div class="alert alert-warning">
     {!! session('warning') !!}
    </div>
   @endif
   @if (session('error'))
    <div class="alert alert-danger">
     {!! session('error') !!}
    </div>
   @endif
   @if(\Auth::user()->type->name == 'Physician' && !Auth::user()->certificate && \Auth::user()->status != 'Registering')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
     You have not added your professional documents,
     <a href="{{ route('eac.portal.user.certify')}}">click here to upload.</a>
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
     </button>
    </div>
   @endif
   @yield('content')
   {{-- @include('include/elements') --}}
  </div><!-- /#pcont --><!-- DO NOT REMOVE -->
 </div><!-- /.container-fluid --><!-- DO NOT REMOVE -->
 @include('include.portal.foot') 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.1/tinymce.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
 <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
 <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.js"></script>
 <script src="{{ asset('/js/ui/jquery-ui.js') }}"></script>
 <script src="{{ asset('/js/dataTables-config.js') }}"></script>
 @yield('scripts')
 <script>
  $(function () {
   let activeTab = $('a.dropdown-item.active');
   if (activeTab) {
    let navItem = $('a.dropdown-item.active').parent().parent();
    navItem.children('a').trigger('click');
   }
  })
 </script>
</body>
@SetTab('')
</html>
