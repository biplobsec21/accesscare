<div class="modal fade" id="DOBModal{{ $rid->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.rid.patient.DOB') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="rid_id" value="{{ $rid->id }}"/>
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
						Edit Patient Date of Birth
					</h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
				<div class="modal-body p-3">
     <div class="row m-0 mb-3">
      <div class="col p-0">
       <small class="text-upper">Month</small>
 						<select class="form-control" name="patient_dob[month]">
        <option disabled hidden selected value="">-- Select --</option>
 							<option value="1" @if(date('m', strtotime($rid->patient_dob)) == "1") selected @endif >January
 							</option>
 							<option value="2" @if(date('m', strtotime($rid->patient_dob)) == "2") selected @endif >February
 							</option>
 							<option value="3" @if(date('m', strtotime($rid->patient_dob)) == "3") selected @endif >March
 							</option>
 							<option value="4" @if(date('m', strtotime($rid->patient_dob)) == "4") selected @endif >April
 							</option>
 							<option value="5" @if(date('m', strtotime($rid->patient_dob)) == "5") selected @endif >May
 							</option>
 							<option value="6" @if(date('m', strtotime($rid->patient_dob)) == "6") selected @endif >June
 							</option>
 							<option value="7" @if(date('m', strtotime($rid->patient_dob)) == "7") selected @endif >July
 							</option>
 							<option value="8" @if(date('m', strtotime($rid->patient_dob)) == "8") selected @endif >August
 							</option>
 							<option value="9" @if(date('m', strtotime($rid->patient_dob)) == "9") selected @endif >September
 							</option>
 							<option value="10" @if(date('m', strtotime($rid->patient_dob)) == "10") selected @endif >October
 							</option>
 							<option value="11" @if(date('m', strtotime($rid->patient_dob)) == "11") selected @endif >November
 							</option>
 							<option value="12" @if(date('m', strtotime($rid->patient_dob)) == "12") selected @endif >December
 							</option>
 						</select>
      </div>
      <div class="col p-0">
       <small class="text-upper">Day</small>
 						<input type="number" class="form-control border-left-0 border-right-0" name="patient_dob[day]" placeholder="Day" value="{{ date('d', strtotime($rid->patient_dob)) }}" />
      </div>
      <div class="col p-0">
       <small class="text-upper">Year</small>
 						<input type="number" class="form-control dob_year" name="patient_dob[year]" placeholder="Year" value="{{ date('Y', strtotime($rid->patient_dob)) }}" />
       <span id="dob_year_invalid" class="text-danger">Year must have 4 digits</span>
      </div>
					</div>
				</div>
    <div class="modal-footer p-2 d-flex justify-content-between">
     <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
					<button type="submit" id="btnYSubmit" class="btn btn-success">
						Save
					</button>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">	
	$('#dob_year_invalid').hide();

			$(".dob_year").keyup(function() {
			  var year_length = $(".dob_year").val().length;
			    if (year_length < 4) {
			    $("#dob_year_invalid").show();
			    $('#btnYSubmit').attr("disabled", true);
				  }
				  else{
				  	$('#dob_year_invalid').hide();
				  	$('#btnYSubmit').removeAttr("disabled");

				  }
			});
</script>
