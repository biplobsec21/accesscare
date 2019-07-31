@extends('layouts.portal')

@section('title')
  Edit Company
@endsection

@section('styles')
 <style>
  .viewData .row {
   border: 1px solid blue;
  }
  .viewData .row > [class*=col] {
   border: 1px dashed gray;
  }
  .viewData form {
   border: 2px solid hotpink!important;
  }
  form {
   border: 2px solid black;
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
       <a href="{{ route('eac.portal.company.list') }}">All Companies</a>
      </li>
      <li class="breadcrumb-item">
       <a href="{{ route('eac.portal.company.show', $company->id) }}">{{ $company->name }}</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
       @yield('title')
      </li>
     </ol>
    </div>
    <div class="d-none d-sm-block col-sm-auto ml-sm-auto">
     <div class="small">
      @if(!is_null($company->updated_at))
       <strong>Last Updated:</strong>
       @php
        $time = $company->updated_at;
        
        echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
       @endphp
      @endif
     </div>
    </div>
   </div>
  </nav>
  <h6 class="title small upper m-0">
   @yield('title')
  </h6>
  <h2 class="m-0">
   {{ $company->name }} <small>({{ $company->abbr }})</small>
  </h2>
  <div class="small d-sm-none">
   @if(!is_null($company->updated_at))
    <strong>Last Updated:</strong>
    @php
     $time = $company->updated_at;
     
     echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
    @endphp
   @endif
  </div>
 </div><!-- end .titleBar -->

 <form name="" method="POST" action="{{ route('eac.portal.company.update') }}">
  {{ csrf_field() }}
  <div class="actionBar">
   <a href="{{ route('eac.portal.company.show', $company->id) }}" class="btn btn-secondary">
    <i class="fal fa-angle-double-left"></i> View Company
   </a>
 	 @if($company->status == 'Approved')
    <div class="ml-auto d-flex-inline">
    <a href="{{ route('eac.portal.company.suspend', $company->id) }}" class="btn btn-danger">
     <i class="fal fa-ban"></i> Suspend Company
    </a>
   </div>
 	 @elseif($company->status == 'Pending')
 		 <div class="ml-auto d-flex-inline">
 			 <a href="{{ route('eac.portal.company.approve', $company->id) }}" class="btn btn-success">
 				 <i class="fal fa-check"></i> Approve Company
 			 </a>
 		 </div>
 	 @elseif($company->status == 'Not Approved')
 		 <div class="ml-auto d-flex-inline">
 			 <a href="{{ route('eac.portal.company.reactivate', $company->id) }}" class="btn btn-success">
 				 <i class="fas fa-redo"></i> Reactivate Company
 			 </a>
 		 </div>
   @endif  
  </div><!-- end .actionBar -->

 <div class="viewData">
  <div class="row">
   <div class="col-md col-lg-4 col-xl-3">
    <div class="card card-body mb-5">
     <h5 class="text-gold mb-2">
      Company Information
     </h5>
     <div class="row">
      <div class="col-sm col-lg-12 mb-3">
       <label class="d-block">Company Name</label>
       <input type="text" class="form-control" name="name" value="{{ $company->name }}">
      </div>
      <div class="col-sm col-md-3 col-lg-12 mb-3">
       <label class="d-block">Abbreviation</label>
       <input type="text" class="form-control" name="abbr" value="{{ $company->abbr }}">
      </div>      
      <div class="col-md col-lg-12 mb-3">
       <label class="d-block">Company Website</label>
       <input type="text" class="form-control" name="website" value="{{ $company->site ? $company->site : '' }}">
      </div>
     </div>
     <div class="mb-2">
      <label class="d-block">Street Address</label>
      <input type="text" class="form-control mb-1" name="addr1" placeholder="Street name" value="{{ $company->address->addr1 }}">
      <input type="text" class="form-control mb-2" name="addr2" placeholder="" value="{{$company->address->addr2}}">
     </div>
     <div class="row">
      <div class="col-sm col-lg-12 mb-2">
       <label class="d-block">City</label>
       <input type="text" class="form-control" name="city" value="{{ $company->address->city }}">
      </div>
      @if($company->address->state_province != NULL)
      <div class="col-sm col-lg-12 col-xl mb-2">
       <label class="d-block">State</label>
        <select class="select2 form-control{{ $errors->has('company_state') ? ' is-invalid' : '' }}" name="company_state">
          <option disabled hidden selected value="">-- Select --</option>
          @foreach($state as $state)
           <option value="{{$state->id}}" {{ $company->address->state->id == $state->id? 'selected' : ''  }}>{{$state->abbr}}</option>
          @endforeach
         </select>
      </div>
      @endif
   
      <div class="col-sm col-lg-12 col-xl mb-2">
       <label class="d-block">Zip</label>
       <input type="text" class="form-control" name="zipcode" value="{{ $company->address->zipcode }}">
      </div>
     </div>
     <div class="mb-2">
      <label class="d-block">Country</label>
      <!-- <input type="text" class="form-control" name="address_country" value="{{ $company->address->country->name }}"> -->
      <select class="form-control" name="country">
       <option disabled hidden selected value="">-- Select --</option>
       @foreach($countries as $countries)
        <option value="{{$countries->id}}" {{ $company->country_id == $countries->id? 'selected' : ''  }}>{{$countries->name}}</option>
       @endforeach
      </select>
     </div>
     <div class="row m-1">
      <input type="hidden" name="company_id" value="{{$company->id}}">
      <input type="hidden" name="address_id" value="{{$company->address_id}}">
      <button class="btn btn-success btn-block" type="submit">
       <i class="far fa-check"></i> Update
      </button>
     </div><!-- /.row -->
    </form>
   </div>

   <form name="" method="POST" action="{{ route('eac.portal.company.update') }}">
    {{ csrf_field() }}
    <div class="card card-body mb-5">
     <h5 class="text-gold mb-2">
      Company Contacts
     </h5>
     <div class="mb-2">
      <label>Main</label>
      <div class="input-group mb-2" title="Main Phone">
       <div class="input-group-prepend">
        <span class="input-group-text">
         <i class="fas fa-phone"></i> <span class="sr-only">Main Phone</span> 
        </span>
       </div>
       <input type="text" class="form-control pl-1" name="phone_main" @if($company->phone_main) value="{{ $company->phone->number }}" @endif>
      </div>
      <div class="input-group" title="Main Email">
       <div class="input-group-prepend">
        <span class="input-group-text">
         <i class="fas fa-at"></i> <span class="sr-only">Main Email</span> 
        </span>
       </div>
       <input type="text" class="form-control pl-1" name="email_main" @if($company->email_main) value="{{ $company->email_main }}" @endif>
      </div>
     </div>
     @foreach($company->departments as $department)
      <div class="mb-2">
       <label>{{ $department->name }}</label>      
       <div class="input-group mb-2" title="{{ $department->name }} Phone">
        <div class="input-group-prepend">
         <span class="input-group-text">
          <i class="fas fa-phone"></i> <span class="sr-only">{{ $department->name }} Phone</span>
         </span>
        </div>
        <input type="text" required class="form-control" name="phone" @if($department->phone_id) value="{{ $department->phone->number }}" @endif>
       </div>
       <div class="input-group" title="{{ $department->name }} Email">
        <div class="input-group-prepend">
         <span class="input-group-text">
          <i class="fas fa-at"></i> <span class="sr-only">{{ $department->name }} Email</span>
         </span>
        </div>
        <input type="email" required class="form-control" name="email" @if($department->email) value="{{ $department->email }}" @endif>
       </div>
       <div class="input-group text-center mt-3" >
        <!-- <a title="#" href="#" data-toggle="modal" data-target="#editDept">
         <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit</span>
        </a> -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editDept{{$department->id}}">
         <i class="far fa-edit" aria-hidden="true"></i>
        </button>
         &nbsp;
        <button type="button" onclick="Confirm_Delete('{{$department->id}}')" href="#" class="btn btn-danger">
         <i class="far fa-trash" aria-hidden="true"></i> <span class="sr-only">Delete</span>
        </button>
       </div>
      </div>
     @endforeach
     <div class="mt-5">
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNewDept">
       Add Department
      </button>
     </div>
    </div>
   </form>
   @foreach($company->departments as $department)
    <div class="modal fade" id="editDept{{$department->id}}" tabindex="-1" role="dialog" aria-labelledby="editDeptLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
       <div class="modal-header p-2">
        <h5 class="m-0">
         Edit Department
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <i class="fal fa-times"></i>
        </button>
       </div>
       <form method="post" action="{{ route('eac.portal.company.department.update') }}">
        {{ csrf_field() }}
        <input type="hidden" name="company_id" value="{{ $company->id }}"/>
        <input type="hidden" name="department_id" value="{{ $department->id}}"/>
        <input type="hidden" name="phone_id" value="{{ $department->phone_id}}"/>
        <input type="hidden" name="country_id" value="{{ $company->country_id}}"/>
        <div class="modal-body p-3">
         <div class="mb-3">
          <label class="d-block">Department Name</label>
          <input type="text" class="form-control" name="name" value="{{ $department->name }}">
         </div>
         <div class="row">
          <div class="col-sm mb-3">
           <label class="d-block">Phone Number</label>
           <input type="number" class="form-control" name="phone" @if($department->phone_id) value="{{ $department->phone->number }}" @endif>
          </div>
          <div class="col-sm mb-3">
           <label class="d-block">Email Address</label>
           <input type="email" class="form-control" name="email" value="{{ $department->email }}">
          </div>
         </div><!-- /.row -->
        </div>
        <div class="modal-footer p-2 d-flex justify-content-between">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         <button type="submit" class="btn btn-success">
          Update
         </button>
        </div>
       </form>
      </div>
     </div>
    </div>
   @endforeach
   </div>
   <div class="col-xl">
    <div class="card card-body mb-5">
     <h5 class="text-gold mb-2">Assigned Users</h5>
     <div class="table-responsive">
      <table class="table SObasic table-sm table-striped table-hover">
       <thead>
        <tr>
         <th>Name</th>
         <th>Email</th>
         <th>Company</th>
         <th></th>
        </tr>
       </thead>
       <tbody>
        @foreach(App\User::all() as $user)
         @if($user->company_id == $company->id || !($user->company_id))
         <tr>
          <td>
           <a href="{{ route('eac.portal.user.show', $user->id) }}">
            {{$user->full_name}}
           </a>
          </td>
          <td>
           {{$user->email}}
          </td>
          <td>
           @if($user->company_id)
            @if($user->company_id == $company->id)
             {{ $user->company->name }}
            @else
             {{ $user->company->name }}
            @endif
           @endif
          </td>
          <td class="text-center">              
           @if($user->company_id)
            @if($user->company_id == $company->id)
             <a href="{{ route('eac.portal.company.user.remove', [$company->id, $user->id]) }}" class="btn btn-danger btn-sm btn-block" title="Remove User">
              <i class="fal fa-minus"></i> Unassign
             </a>
            @else
             <small class="text-muted">N/A</small>
            @endif
           @else
            <a href="{{ route('eac.portal.company.user.add', [$company->id, $user->id]) }}" class="btn btn-outline-success btn-sm btn-block" title="Add User">
             <i class="fal fa-plus"></i> Assign
            </a>
           @endif
          </td>
         </tr>
         @endif
        @endforeach
       </tbody>
      </table>
     </div>
    </div>
   </div><!-- /.row -->

  </div>
 </div><!-- end .editData -->

 <div class="modal fade" id="addNewDept" tabindex="-1" role="dialog" aria-labelledby="addNewDeptLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
      Add New Department
     </h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <form method="post" action="{{ route('eac.portal.company.department.create') }}">
     {{ csrf_field() }}
     <input type="hidden" name="company_id" value="{{ $company->id }}"/>
     <div class="modal-body p-3">
      <div class="mb-3">
       <label class="d-block">Department Name</label>
       <input type="text" class="form-control" name="name">
      </div>
      <div class="row">
       <div class="col-sm mb-3">
        <label class="d-block">Phone Number</label>
        <input type="number" class="form-control" name="phone">
       </div>
       <div class="col-sm mb-3">
        <label class="d-block">Email Address</label>
        <input type="email" class="form-control" name="email">
       </div>
      </div><!-- /.row -->
     </div>
     <div class="modal-footer p-2 d-flex justify-content-between">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      <button type="submit" class="btn btn-success">
       Save
      </button>
     </div>
    </form>
   </div>
  </div>
 </div>

 
@endsection

@section('scripts')

<script type="text/javascript">
  
  function Confirm_Delete(param)
{

 swal({
  title: "Are you sure?",
  text: "Want to delete it",
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
    $.get("{{route('eac.portal.company.department.delete')}}",
      {
       id: param
      });
    // return false;
    swal.close();
    var redirect_url = '<?php echo route('eac.portal.company.edit', $company->id); ?>';
    $(location).attr('href', redirect_url); // <--- submit form programmatically
   });
  } else {
   swal("Cancelled", "Operation cancelled", "error");
  }
 })
}
</script>
@endsection
