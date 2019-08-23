@php
	$disable=1;
	if($visit->shipment->tracking_number && $visit->shipment->pharmacy_id && ($rid->drug->components->count() == $visit->shipment->regimen->count()) && $visit->getDocStatus()){
		 $disable =0;
	}
@endphp
<div class="modal fade" id="StatusChange" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.rid.visit.edit.status.save') }}">
		@csrf
		<input type="hidden" name="visit_id" value="{{ $visit->id }}"/>
		<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						Change Visit Status </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body p-3">
					<select class="form-control" name="sub_status">
						@foreach(\App\RidVisitStatus::all()->sortBy('index') as $status)
							<option value="{{$status->id}}" @if($rid->status == $status->id) selected @endif>
								{{$status->name}}
							</option>
						@endforeach
					</select>
				</div>
				<div class="modal-footer p-2 d-flex justify-content-between">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
					<button type="submit" class="btn btn-success">Submit
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
