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
    <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
    <button type="submit" class="btn btn-success">
     Update
    </button>
   </div>
  </form>
 </div>
</div>
</div>
