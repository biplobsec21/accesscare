@extends('layouts.portal')

@section('title')
 View Pharmacy
@endsection

@section('styles')
 <style>
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
   :root {
    --leftCol: 230px;
    --rightCol: 850px;
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
       <a href="{{ route('eac.portal.pharmacy.list.all') }}">All Pharmacy</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
       {{$pharmacy->name}}
      </li>
     </ol>
    </div>
    <div class="d-none d-sm-block col-sm-auto ml-sm-auto">
     <div class="small">
      <strong>Last Updated:</strong>
      @php
       $time = $pharmacy->updated_at;
       echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
      @endphp
     </div>
    </div>
   </div>
  </nav>
  <h6 class="title small upper m-0">
   @yield('title')
  </h6>
  <h2 class="m-0">
   {{$pharmacy->name}}
  </h2>
  <div class="small d-sm-none">
   <strong>Last Updated:</strong>
   @php
    $time = $pharmacy->updated_at;
    echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
   @endphp
  </div>
 </div><!-- end .titleBar -->
 
 @include('include.alerts')
 
 <div class="viewData">
  <div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
   <a href="{{ route("eac.portal.pharmacy.list.all") }}" class="btn btn-light">
    Pharmacies List
   </a>
   <div>
    <a href="{{ route("eac.portal.pharmacy.edit", $pharmacy->id) }}" class="btn btn-info">
     <i class="far fa-edit"></i>
     Edit Pharmacy
    </a>
   </div>
  </div>
  <div class="row thisone m-0 mb-xl-5">
   <div class="col-sm-3 col-xl-auto mb-2 mb-sm-0 p-0">
    <div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist" aria-orientation="vertical">
     <a class="nav-link {{ $pharmacy->pharmacists  && $pharmacy->pharmacists->count() > 0 ? 'complete'   : 'active'}}" id="xpharmacistsT" data-toggle="pill" href="#xpharmacists" role="tab" aria-controls="xpharmacists" aria-selected="true">
      <span>Pharmacists</span>
     </a>
    
    </div>
   </div>
   <div class="col-sm-9 col-xl p-0">
    <div class="card tab-content wizardContent" id="tabContent">
     <div class="alert-light text-dark pt-3 pl-3 pr-3">
      <div class="row">
       <div class="col-md mb-1 mb-md-3">
        <strong>{{ $pharmacy->name }}</strong>
        <span class="badge badge-{{ $pharmacy->active == '1' ? 'success' : 'secondary' }}">
         {{ $pharmacy->active == '1' ? 'Active' : 'Inactive' }}
        </span>
        <div class="small">
         @if($pharmacy->address)
          {{ $pharmacy->address->addr1 }}
          @if($pharmacy->address->addr2)
           <br/>{{$pharmacy->address->addr2}}@endif
          <br/>{{ $pharmacy->address->city }}, {{ $pharmacy->address->state->name }}
          {{ $pharmacy->address->zipcode }}{{ $pharmacy->address->country ? ', ' . $pharmacy->address->country->abbr : '' }}
         @endif
        </div>
       </div>
       <div class="col-md-4 col-lg-5 col-xl-6 mb-md-3">
        <div class="row">
         <div class="col-auto col-sm col-md-12 col-xl mb-3 mb-md-3 mb-xl-2">
          <small class="upper d-block">Physician</small>
          <a href="{{ route('eac.portal.user.show', $pharmacy->physician_id) }}">
           <strong>{{ $pharmacy->physician->full_name }}</strong>
          </a>
         </div>
         <div class="col-auto col-sm col-md-12 col-xl-auto mb-3 mb-md-0">
          <small class="upper d-block">Created On</small>
          <strong>{{date('Y-m-d', strtotime($pharmacy->created_at)) }}</strong>
         </div>
        </div>
       </div>
      </div>
     </div>
     <div class="tab-pane fade show active" id="xpharmacists" role="tabpanel" aria-labelledby="xpharmacists-tab">
      <div class="card-body">
       <h5 class="mb-3">
        Pharmacists
        <span class="badge badge-dark">{{ $pharmacy->pharmacists ?  $pharmacy->pharmacists->count() : '0'}}</span>
       </h5>
       {{-- dynamic for loop --}}
       @if($pharmacy->pharmacists)
        @foreach($pharmacy->pharmacists as $val)
         <div class="row">
          <div class="col">
           <a href="#">
            {{ $val->name}}
           </a>
           <small class="d-none d-sm-block">
            ({{ $val->email ? $val->email : 'N/A'}})
           </small>
          </div>
          <div class="col-auto">
           <a href="#" class="btn btn-sm btn-danger" onclick="Confirm_Delete('{{ $val->id }}')">
            Remove
           </a>
          </div>
         </div>
        @endforeach
       @else
        "N/A"
       @endif
       {{-- dynamic for loop data end --}}
      </div>
      <div class="card-footer">
       <a href="#" class="btn btn-success window-btn" data-toggle="modal" data-target="#pharmacistaddmodal">
        <i class="fal fa-plus"></i>
        Assign Pharmacist
       </a>
      </div>
     </div>
    </div>
   </div>
  </div><!-- /.row -->
 </div><!-- /.viewData -->
 
 
 <div class="modal fade" id="pharmacistaddmodal" tabindex="-1" role="dialog" aria-hidden="true">
  <form method="post" action="{{ route('eac.portal.pharmacy.assign.pharmacist') }}" enctype="multipart/form-data">
   {{ csrf_field() }}
   <input type="hidden" name="pharmacy_id" value="{{$pharmacy->id}}"/>
   <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
     <div class="modal-header p-2">
      <h5 class="m-0">
       Select Pharmacist </h5>
      
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <i class="fal fa-times"></i>
      </button>
     </div>
     <div class="modal-body p-3">
      <div class="table-responsive">
       <table class="table  table-sm table-striped table-hover" id="pharmacistTBL">
        <thead>
        <tr>
         <th class="no-sort no-search">Select</th>
         <th>Name</th>
         <th>Email</th>
         <th>Phone</th>
         <th>Pharmacy</th>
         <th>Created At</th>
        </tr>
        </thead>
        <tbody></tbody>
       </table>
      </div>
     </div>
     
     <div class="modal-footer p-2 d-flex justify-content-between">
      <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
      <button type="submit" class="btn btn-success">
       Submit
      </button>
     </div>
    </div>
   </div>
  </form>
 </div>

@endsection

@section('scripts')
 <script type="text/javascript">
  $(document).ready(function () {
   $('#pharmacistTBL tfoot th').each(function () {
    if ($(this).hasClass("no-search"))
     return;
    var title = $(this).text();
    $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
   });

   var dataTable = $('#pharmacistTBL').DataTable({
    "paginationDefault": 10,
    "paginationOptions": [10, 25, 50, 75, 100],
    // "responsive": true,
    'order': [[5, 'desc']],
    "ajax": {
     url: "{{route('eac.portal.pharmacy.getpharmacistajaxlist')}}",
     type: "get"
    },
    "processing": true,
    "serverSide": true,
    columnDefs: [{
     targets: 'no-sort',
     orderable: false,
    }],
    "columns": [
     {"data": "select", 'name': 'select'},
     {"data": "name", 'name': 'name'},
     {"data": "email", 'name': 'email'},
     {"data": "phone", 'name': 'phone'},
     {"data": "pharmacy", 'name': 'pharmacy'},
     {"data": "created_at", 'name': 'created_at'},
    ]
   });

   dataTable.columns().every(function () {
    var that = this;

    $('input', this.footer()).on('keyup change', function () {
     if (that.search() !== this.value) {
      that
       .search(this.value)
       .draw();
     }
    });
   });
   $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
    swal({
     title: "Oh Snap!",
     text: "There was an error understanding this request. If this issue persists, <a href="mailto:{{site()->email}}">click her</a> to contact us.",
     icon: "warning",
    });
   };

  }); // end doc ready
  $(".alert").delay(7000).slideUp(200, function () {
   $(this).alert('close');
  });

  function Confirm_Delete(param) {

   swal({
    title: "Are you sure?",
    text: "Want to remove pharmacist",
    icon: "warning",
    buttons: [
     'No, cancel it!',
     'Yes, I am sure!'
    ],
    dangerMode: true,
   }).then(function (isConfirm) {
    if (isConfirm) {
     swal({
      title: 'Successfull!',
      text: 'Content deleted!',
      icon: 'success'
     }).then(function () {
      $.get("{{route('eac.portal.pharmacy.pharmacistremove')}}",
       {
        id: param
       });
      // return false;
      swal.close();

      $(location).attr('href', '{{route('eac.portal.pharmacy.show',$pharmacy->id)}}');
     });
    } else {
     swal("Cancelled", "Operation cancelled", "error");
    }
   })
  }
 </script>
@endsection
