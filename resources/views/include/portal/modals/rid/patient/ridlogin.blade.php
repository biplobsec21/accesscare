<div class="modal fade" id="ridLogin{{$rid->id}}" tabindex="-1" role="dialog" aria-labelledby="ridLogin{{$rid->id}}Label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content printArea">
			<div class="modal-header p-2">
				<h5 class="m-0">
					Track Your RID Login Credentials
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="alert-secondary p-2 border-bottom">
				RID #{{$rid->number}}
			</div>
			<div class="modal-body p-3">
				The following information is for patient, patient family and caregiver access. No patient information will be disclosed or displayed upon login. These credentials can be input in the RID Login Portal.
			</div>
			<div class="alert alert-primary text-dark mb-0 border-bottom-0">
				<div class="row">
					<div class="col-lg-7">
						<label class="d-block text-dark">Login/RID Number:</label>
						{{$rid->number}}
					</div>
					<div class="col-lg">
						<label class="d-block text-dark">Password:</label>
						{{$rid->password}}
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="#" class="btn btn-success ml-2" >
					<i class="fa-fw fas fa-envelope"></i> Send Email
				</a>
				<button type="button" class="btn btn-info">Print Information</button>
			</div>
		</div>
	</div>
</div>