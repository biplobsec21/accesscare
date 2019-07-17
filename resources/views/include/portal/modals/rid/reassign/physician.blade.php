<form method="post" action="{{ route('eac.portal.rid.visit.edit.reassign.save') }}">
	<div class="modal fade" id="reassignRidModal" tabindex="-1" role="dialog" aria-hidden="true">
		@csrf
		{{-- {{ $visit }} --}}
		<input type="hidden" name="visit_id" value="{{ $visit->id }}"/>
		
		<div class="modal-dialog modal-dialog-centered modal-md">
			<div class="modal-content">
				<div class="modal-header p-2">
					
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body p-3">
					<label class="">Assign Physician</label>
					<br>
					<select class="form-control select2" name="physician_id" required="required">
						@if(\App\User::physicians()->count() > 0)
							@foreach(\App\User::physicians() as $val)
								<option value="{{$val->id}}" @if($val->id == $visit->physician_id)  selected @endif>{{ $val->first_name}} {{ $val->last_name}}</option>
							@endforeach
						@endif
					</select>
				</div>
				<div class="modal-footer p-2 d-flex justify-content-between">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
					<button type="submit" class="btn btn-success">Submit
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
