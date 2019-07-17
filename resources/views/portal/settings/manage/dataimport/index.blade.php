@extends('layouts.portal')

@section('title')
Migration Manager
@endsection

@section('content')
<div class="titleBar">
    <div class="row justify-content-between">
        <div class="col-md col-lg-auto">
            <h4 class="m-0">Supporting Content:</h4>
            <h2 class="m-0">
                Data Migration
            </h2>
        </div>
        <div class="col-md col-lg-auto ml-lg-auto">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Data migration
                </li>
            </ol>
            <div class="text-right">
              <!--   <button class="btn btn-secondary btn-sm" id="ShowRightSide" href="{{ route('eac.portal.settings.manage.states.loglist') }}">
                    Changelog
                </button> -->
            </div>
        </div>
    </div>
</div><!-- end .titleBar -->


<div class="actionBar">

    <div class="col-md-6 text-left">
        
        <a href="" class="btn btn-primary btn-lg">
            <i class="fas fa-file-import"></i> Import Data
        </a>
    </div>

</div><!-- end .actionBar -->
 @php
  if(Session::has('alerts')) {
   $alert = Session::get('alerts');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
 @endphp
<div class="viewData">
  {{ csrf_field() }}
  <!-- end .actionBar -->
  <div class="viewData">
   <div class="row">
    
    <div class="col-md-12 col-lg-12 col-xl-122">
     <div class="card m-b-30">
      <div class="card-header bg-secondary p-10">
       <h5>
          Data Migration Credential Form
          {{ config('eac.datamigration_password') }}
       </h5>
      </div>
      <div class="card-body">
        <form method="post" action="{{ route('eac.portal.settings.manage.dataimport.handle_db') }}" enctype='multipart/form-data'>
            {{ csrf_field() }}

       <div class="row h4styled m-b-30">
          <div class="col-md-12">
           <div class="row m-b-30">
            <div class="col">
             <label><i class="far fa-lock fa-fw"></i>Password</label>
             <input name="access_credential" type="password" id="migration_credential" value="{{ old('access_credential') }}"
                    class="form-control m-b-10 {{ $errors->has('access_credential') ? ' is-invalid' : '' }}" placeholder="Enter Password">
             <div class="invalid-feedback">
              {{ $errors->first('access_credential') }}
             </div>         
            </div>
           </div>
          </div>
       </div>
       <br>
    <div class="row h4styled">
      <div class="col-md-6 text-left">
        <button type="submit" href="}" class=" btn btn-success " id="migration_trigger">
         <i class="far fa-check fa-fw"></i> Trigger Migration
        </button>
        <a href="" class=" btn btn-danger" >
         <i class="far fa-times fa-fw"></i> Cancel
        </a>
      </div> 
    </div>
    </form>
      </div>
     </div>
    </div>
   </div>
  </div>
 </form>
</div>

<div class="rightSide">
    right side
</div><!-- end .rightSide -->
@endsection
@section('scripts')
<script>
$(document).ready(function () {
//     $("#migration_trigger").on("click", function () { 

//         let hidden_value = "";
//         // alert(hidden_value);
//         let migration_credential = $("#migration_credential").val();
//         if(hidden_value != migration_credential){
//             alert('Password is wrong!');
//             return false;
//         }else{
//                 // $("#migration_trigger").prop("disabled",true);
//                 $("#migration_trigger").html('<i class="far fa-spinner fa-spin fa-fw"></i>Migration in progress...');

//         }
// /********** Ajax Request for country and state *********/
//         var ajax_state_company = $.ajax({
//             cache: false,
//             contentType: false,
//             processData: false,
//             headers: {
//                 'X-CSRF-Token': '',
//             },
//             type: 'POST',
            // url: "",
//             beforeSend: function () {
//                 // swal({
//                 //     title: "",
//                 //     text: "Request Successfull",
//                 //     button: {text: 'ok'}
//                 // });
//     //                        $( '.'+ attr).show().html('  <i class="fas fa-spinner fa-pulse"></i><label class="text-success">  Image Uploading...</label>');
//             },
//             success: function(data)
//             {

//                 alert(data);
//                 $("#migration_trigger").html('<i class="far fa-check fa-fw"></i>Migration Done');

//              // setTimeout(function() {
//              //      swal.close();
//              //  },500);

//             },
//             error: function (xhr, status, errorThrown) {
//             //Here the status code can be retrieved like;
//               xhr.status;

//             //The message added to Response object in Controller can be retrieved as following.
//              xhr.responseText;
//             if (xhr.status === 0) {
//               alert ('Not connected.\nPlease verify your network connection.');
//             } else if (xhr.status == 404) {
//                 alert ('The requested page not found. [404]');
//             } else if (xhr.status == 500) {
//                 alert ('Internal Server Error [500].');
//             } else if (exception === 'parsererror') {
//                 alert ('Requested JSON parse failed.');
//             } else if (exception === 'timeout') {
//                 alert ('Time out error.');
//             } else if (exception === 'abort') {
//                 alert ('Ajax request aborted.');
//             } else {
//                 alert ('Uncaught Error.\n' + xhr.responseText);
//             }
//             }
//         });

// /********** Ajax Request for pages_companies_ajax_call *********/

//         var ajax_page_company = $.ajax({
//             cache: false,
//             contentType: false,
//             processData: false,
//             headers: {
//                 'X-CSRF-Token': '',
//             },
//             type: 'POST',
//             url: "",
//             beforeSend: function () {
//                 // swal({
//                 //     title: "",
//                 //     text: "Request Successfull",
//                 //     button: {text: 'ok'}
//                 // });
//     //                        $( '.'+ attr).show().html('  <i class="fas fa-spinner fa-pulse"></i><label class="text-success">  Image Uploading...</label>');
//             },
//             success: function(data)
//             {

//                 alert(data);
//                 $("#migration_trigger").html('<i class="far fa-check fa-fw"></i>Migration Done');

//              // setTimeout(function() {
//              //      swal.close();
//              //  },500);

//             },
//             error: function (xhr, status, errorThrown) {
//             //Here the status code can be retrieved like;
//               xhr.status;

//             //The message added to Response object in Controller can be retrieved as following.
//              xhr.responseText;
//             if (xhr.status === 0) {
//               alert ('Not connected.\nPlease verify your network connection.');
//             } else if (xhr.status == 404) {
//                 alert ('The requested page not found. [404]');
//             } else if (xhr.status == 500) {
//                 alert ('Internal Server Error [500].');
//             } else if (exception === 'parsererror') {
//                 alert ('Requested JSON parse failed.');
//             } else if (exception === 'timeout') {
//                 alert ('Time out error.');
//             } else if (exception === 'abort') {
//                 alert ('Ajax request aborted.');
//             } else {
//                 alert ('Uncaught Error.\n' + xhr.responseText);
//             }
//             }
//         });


//     $.when(ajax_state_company, ajax_page_company).then(function (a1, a2) {
//         alert('Both j1 and j2 succeedeed!');
//     }, function (jqXHR, textStatus, errorThrown) {
//         var x1 = j1;
//         var x2 = j2;
//         if (x1.readyState != 4) {
//             x1.abort();
//         }
//         if (x2.readyState != 4) {
//             x2.abort();
//         }
//        alert('Either j1 or j2 failed!');
//     });
//     });


   

});



</script>
@endsection
