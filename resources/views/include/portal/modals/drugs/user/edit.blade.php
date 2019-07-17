<div class="modal fade" id="Modal{{ $assignedUser->id }}" tabindex="-1" role="dialog" aria-hidden="true">
 <form method="post" action="{{ route('eac.portal.drug.modal.user.save') }}" enctype="multipart/form-data">
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $assignedUser->id }}"/>
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
      Change User Role for {{ $drug->name }}
     </h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <div class="alert-secondary p-2 border-bottom">
     {{$assignedUser->user->full_name}}
    </div>
    <div class="modal-body p-3">
     <div class="mb-2">
      <label class="d-block">User Role</label>
      <select class="form-control" name="role_id">
       <option selected="selected"
           value="{{$assignedUser->role_id}}">{{ $assignedUser->getRole() }}</option>
       @foreach($roles as $role)
        @unless($role->id == $assignedUser->role_id)
         <option value="{{$role->id}}">{{$role->name}}</option>
        @endunless
       @endforeach
      </select>
     </div>
     @if(!$assignedUser->roleIsInherited() && $assignedUser->level != " ")
     <div class="row m-0 alert-warning">
      <div class="col-auto p-2 justify-content-center d-flex align-items-center bg-warning text-white">
       <i class="fas fa-exclamation-triangle"></i>
      </div>
      <div class="col p-2 small">
       <strong>Warning:</strong> Changing this user's role will overwrite manually adjusted permissions.
      </div>
     </div>
     @endif
    </div>
    <div class="modal-footer p-2 d-flex justify-content-between">
     <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
     <a href="{{ route('eac.portal.drug.user.delete', $assignedUser->id) }}" class="btn btn-danger">
      <i class="fa-fw far fa-times"></i> Remove
     </a>
     <button type="submit" class="btn btn-success">
      Save
     </button>
    </div>
   </div>
  </div>
 </form>
</div>


<div class="modal fade" id="ALTModal{{ $assignedUser->id }}" tabindex="-1" role="dialog" aria-hidden="true">
 <form method="post" action="{{ route('eac.portal.drug.modal.user.save') }}" enctype="multipart/form-data">
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $assignedUser->id }}"/>
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
      Edit User Permissions for {{ $drug->name }}
     </h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <div class="alert-secondary p-2 border-bottom">
     <div class="row">
      <div class="col-sm">
       {{$assignedUser->user->full_name}}
      </div>
      <div class="col-sm-auto">
       <span class="badge badge-info">
        {{ $assignedUser->getRole() }}
       </span>
      </div>
     </div>
    </div>
    <div class="modal-body p-3">
     <ul class="list-unstyled">
      @if(!$assignedUser->roleIsInherited() && $assignedUser->level != " ")
       @foreach(json_decode($assignedUser->level,true) as $gate => $data)
        <li>
         <label class="d-block">{{ ucfirst($gate) }}</label>
         @foreach($data as $ability => $value)
          <input type="hidden" name="level[{{ $gate }}][{{ $ability }}]" value="0">
          <input type="checkbox" name="level[{{ $gate }}][{{ $ability }}]" @if($value) checked @endif>
         @endforeach
        </li>
       @endforeach
      @else
       <li>Cannot Edit Permission</li>
      @endif
     </ul>
    </div>
    <div class="modal-footer p-2 d-flex justify-content-between">
     <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
     <a href="{{ route('eac.portal.drug.user.delete', $assignedUser->id) }}" class="btn btn-danger">
      <i class="fa-fw far fa-times"></i> Remove
     </a>
     <button type="submit" class="btn btn-success">
      Save
     </button>
    </div>
   </div>
  </div>
 </form>
</div>
