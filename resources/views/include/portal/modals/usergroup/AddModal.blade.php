<form name="" method="POST" action="{{ route('eac.portal.drug.modal.newgroup.save') }}">
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="usergroup">
	  	<div class="modal-content">
		   <div class="modal-header p-2">
		    
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		     <i class="fal fa-times"></i>
		    </button>
		   </div>
			<div class="modal-body p-3">
			  {{ csrf_field() }}
			  <input type="hidden" name="drug_id" value="{{ $drug->id}}">
			   <div class="row thisone m-0 mb-xl-5">
			    <div class="col-sm-7 col-lg-6 col-xl-auto p-0 pl-sm-2">
			       <div class="card-body">
			        <h5 class="mb-3">
			         Please provide Group <strong>details</strong>
			        </h5>
			        <div class="mb-3">
			         <label class="d-block label_required">Group Name</label>
			         <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{old("name")}}" required="required" />
			         <div class="invalid-feedback">
			          {{ $errors->first('name') }}
			         </div>
			        </div>
			        <div class="row">
			         <div class="col-sm col-lg-5 mb-3">
			          <label class="d-block label_required">Type of Group</label>
			          <select name="type_id" id="type_select" class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}" required="required">
			           <option disabled hidden selected value="">-- Select --</option>
			           @foreach(\App\UserType::all()->sortBy('name') as $type)
			            <option value="{{ $type->id }}" {{ (old('type_id') && old('type_id') == $type->id) ? 'selected' : '' }}>{{ $type->name }}</option>
			           @endforeach
			          </select>
			          <div class="invalid-feedback">
			           {{ $errors->first('type_id') }}
			          </div>
			         </div>
			        	<div class="col-sm mb-3">
			          <label class="d-block label_required">Group Leader</label>
			          <select name="parent_id" id="parent_id" class="form-control select2 {{ $errors->has('parent_id') ? ' is-invalid' : '' }}" required="required">
			       				<option disabled hidden selected value="">-- Select --</option>
			       				@foreach($users as $user)
			       					<option value="{{ $user->id }}" data-type="{{ $user->type->id }}" {{ (old('parent_id') && old('parent_id') == $user->id) ? 'selected' : '' }}>{{ $user->full_name }} ({{ $user->email }})</option>
			       				@endforeach
			       			</select>
			       			<div class="invalid-feedback">
			           {{ $errors->first('parent_id') }}
			          </div>
			         </div>
			        </div>        
			        <div class="table-responsive">
			         <table class="table table-sm table-striped table-hover">
			          <thead>
			           <tr>
			            <th>Name</th>
			            <th>Role</th>
			            <th></th>
			           </tr>
			          </thead>
			          <tbody id="memberSection">

			          </tbody>
			         </table>
			        </div>
			        <div class="d-flex justify-content-between mt-3">
			         <a href="#" class="btn btn-link" id="addMemberBtn" onclick="addMember()">
			          <i class="fal fa-plus"></i> Add Existing User
			         </a>
			        </div>
			    </div>
			   </div>
			   </div> 
			</div>
			<div class="modal-footer p-2 d-flex justify-content-between">
			<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
			<button class="btn btn-success " type="submit">
			   <i class="fas fa-check"></i> Save Group
			 </button>
			</div>
		</div>
	</div>
	<table>
	<tr class="group-member group-member-template" >
  <td>
 		<select class="form-control" name="member[0]" >
 			<option disabled hidden selected value="">-- Select --</option>
 			@foreach($users as $user)
 				<option value="{{$user->id}}" data-typeid="{{ $user->type_id }}">{{ $user->full_name }}</option>
 			@endforeach
 		</select>
  </td>
  <td>
 		<select class="form-control" name="role[0]" >
 			<option disabled hidden selected value="">-- Select --</option>
 			@foreach(\App\Role::all()->sortBy('name') as $role)
 				<option value="{{$role->id}}" data-typeid="{{ $role->type_id }}">{{ $role->name }}</option>
 			@endforeach
 		</select>
  </td>
  <td>
			<a class="text-danger remove" href="#">
				<i class="fas fa-times"></i>
			</a>
  </td>
 </tr>
</table>
</div>
</form>


