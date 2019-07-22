@extends('layouts.portal')

<style type="text/css">
	.remove-interval,#add-interval{
		cursor: pointer;
	}
</style>
@section('title')
	Drug Supply
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
							<a href="{{ route('eac.portal.drug.list') }}">All Drugs</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route('eac.portal.drug.show', $drug_id) }}">{{$drugname}}</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							@yield('title')
						</li>
					</ol>
				</div>
			</div>
		</nav>
		<h6 class="title small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{$drugname}}
		</h2>
	</div><!-- end .titleBar -->
	<form action="{{ route('eac.portal.drug.drugsupplyadd') }}" method="post" id="supply_form">
		{{ csrf_field() }}
		<input type="hidden" name="drug_id" value="{{$drug_id}} ">
		@if(count($supply_info) > 0)
			<input type="hidden" id="drug_supply_data" value="{{ $supply_info }}">
		@endif
		<div class="row">
			<div class="col-lg-9 col-xl-8">
				<div class="actionBar">
					<a href="{{ route('eac.portal.drug.show', $drug_id) }}" class="btn btn-primary">
						<i class="fal fa-external-link"></i> View Drug
					</a>
				</div><!-- end .actionBar -->
			</div>
		</div><!-- /.row-->

	

		<div class="viewData">
			<div class="row">
				<div class="col-lg-9 ">
					<div class="mb-3 mb-xl-4">
						<div class="card mb-0">
							<ul class="list-group list-group-flush">
								@if(count($supply_info) > 0)
 								<?php 
 									$cnt = 0; 
 									foreach ($supply_info as $info) {
 								?>
  								<li class="list-group-item p-0 supply-interval">
           <div class="row m-0 align-items-start">
            <div class="col p-2 pl-sm-3 pr-sm-3 pr-md-4 pb-md-3 pl-md-4">
    									<div class="row m-0">
    										<div class="mb-2 mb-sm-0 col-sm-auto col-md-5 col-lg-6 col-xl-7 pl-0 pr-0 pr-sm-3" style="max-width:300px">
    											<label class="d-block">
    												Supplies
    											</label>
               <div class="row">
                <div class="col-auto col-md">
                 <select class="form-control" name="supply_start[{{$cnt}}]">
                  <option value="{{$info->supply_start}}">{{$info->supply_start}}</option>
                 </select>
                </div>
                <div class="col-auto p-0">
                 <small class="text-upper">thru</small>
                </div>
                <div class="col-auto col-md">
                 <select class="form-control" name="supply_end[{{$cnt}}]">
                  <option value="Ongoing">Ongoing</option>
                  @for($i = 1; $i <= config('eac.drug.maxIntervalLength'); $i++)
                   <option value="{{$i}}" {{ $info->supply_end == $i  ? 'selected="selected"' : '' }} >{{$i}}</option>
                  @endfor
                 </select>
                </div>
               </div>
    										</div>
    										<div class="col-sm-auto col-md pl-0 pl-sm-3 pr-0">
    											<label class="d-block">
    												Send
    											</label>
               <div class="row">
                <div class="col-auto">
                 <select class="form-control" name="supply_qty[{{$cnt}}]">
                  @foreach(config('eac.drug.supplyLengths') as $i)
                   <option value="{{$i}}"{{ $info->supply_qty == $i  ? 'selected="selected"' : '' }}>{{$i}}</option>
                  @endforeach
                 </select>
                </div>
                <div class="col-auto p-0">
                 <small class="text-upper">Day Supply</small>
                </div>
               </div>
    										</div>
    									</div>
            </div>
            <div class="col-auto p-2 pl-sm-3 pr-sm-3 pt-md-3 pr-md-4 pb-md-3 pl-md-4">
  											<a  class="small text-danger remove-interval">
  												<i class="far fa-ban"></i> Delete
  											</a>
            </div>
           </div>
  								</li>
  							<?php
  								$cnt++; 
  								} 
  							?>
 							@else
  							<li class="list-group-item p-0 supply-interval">
  								<div class="row m-0 align-items-start">
           <div class="col p-2 pl-sm-3 pr-sm-3 pr-md-4 pb-md-3 pl-md-4">
            <div class="row m-0">
             <div class="mb-2 mb-sm-0 col-sm-auto col-md-5 col-lg-6 col-xl-7 pl-0 pr-0 pr-sm-3" style="max-width:300px">
              <label class="d-block">
               Supplies
              </label>
              <div class="row">
               <div class="col-auto col-md">
                <select class="form-control" name="supply_start[0]">
                 <option value="1">1</option>
                </select>
               </div>
               <div class="col-auto p-0">
                <small class="text-upper">thru</small>
               </div>
               <div class="col-auto col-md">
                <select class="form-control" name="supply_end[0]">
                 <option value="Ongoing">Ongoing</option>
                 @for($i = 1; $i <= config('eac.drug.maxIntervalLength'); $i++)
                  <option value="{{$i}}">{{$i}}</option>
                 @endfor
                </select>
               </div>
              </div>
             </div>
             <div class="col-sm-auto col-md pl-0 pl-sm-3 pr-0">
              <label class="d-block">
               Send
              </label>
              <div class="row">
               <div class="col-auto">
                <select class="form-control" name="supply_qty[0]">
                 @foreach(config('eac.drug.supplyLengths') as $i)
                  <option value="{{$i}}">{{$i}}</option>
                 @endforeach
                </select>
               </div>
               <div class="col-auto p-0">
                <small class="text-upper">Day Supply</small>
               </div>
              </div>             
             </div>
            </div>
           </div>
           <div class="col-auto p-2 pl-sm-3 pr-sm-3 pt-md-3 pr-md-4 pb-md-3 pl-md-4">
            <a  class="small text-danger remove-interval">
             <i class="far fa-ban"></i> Delete
            </a>
           </div>
          </div>
 								</li>
								@endif
							</ul>
							<span class="pl-5 text-danger" id="errormsg"></span>
							<span class="pl-5 text-warning" id="warningMsg"></span>
						</div>
						<div class="card-footer d-flex justify-content-center">
							<a class="btn btn-primary text-white" id="add-interval">
								<i class="fa-fw far fa-file-medical"></i> Add More
							</a>
							<button class="ml-3 btn btn-success" id="save_btn" type="button">
								<i class="far fa-check"></i> Save Changes
							</button>
						</div>
					</div>
				</div>
			</div><!-- /.row -->
		</div><!-- /.viewData -->
	</form>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function () {

			$('#add-interval').click(function () {			
				$("#errormsg").text("");
				$("#warningMsg").text("");
				let $prev_interval = $('.supply-interval').last();
				let $prev_end = $prev_interval.find("select[name*='supply_end']").val();
				if($prev_end == 'Ongoing'){
						$("#warningMsg").html("Change  <strong>THRU</strong> option value <i>Ongoing to number </i>  ");
					
						return false;
				}	
				let $intervals = $prev_interval.parent().append($prev_interval.clone());


				if($prev_end != 'Ongoing'){
						$intervals.find("select[name*='supply_start']").last().html('<option value="' + (parseInt($prev_end)+1) + '">' + (parseInt($prev_end)+1) + '</option>');
				}else{
									$intervals.find("select[name*='supply_start']").last().html('<option value="' + $prev_end + '">' + $prev_end + '</option>');
				}

				let $new_start = $intervals.find("select[name*='supply_start']").last();
				$new_start.attr('name', $new_start.attr('name').slice(0, $new_start.attr('name').indexOf('[')) + '[' + ($('.supply-interval').length - 1) + ']');
				
				let $new_end = $intervals.find("select[name*='supply_end']").last();
				$new_end.attr('name', $new_end.attr('name').slice(0, $new_end.attr('name').indexOf('[')) + '[' + ($('.supply-interval').length - 1) + ']');
				
				let $new_qty = $intervals.find("select[name*='supply_qty']").last();
				$new_qty.attr('name', $new_qty.attr('name').slice(0, $new_qty.attr('name').indexOf('[')) + '[' + ($('.supply-interval').length - 1) + ']');
			});

			$(document).on('change', "select[name*='supply_end']", function () {
				let $new_end = $(this).val();
				$(this).closest('.supply-interval').next().find("select[name*='supply_start']").html('<option value="' + ($new_end != 'Ongoing' ? (parseInt($new_end)+1) : $new_end) + '">' + ($new_end != 'Ongoing' ? (parseInt($new_end)+1) : $new_end) + '</option>');
			});

			$(document).on('click', 'a.remove-interval', function () {
				if ($('.supply-interval').length > 1)
					$(this).closest('.supply-interval').remove();
			});

			$('#save_btn').click(function () {
				$("#errormsg").text("");
				let $intervals = $('.supply-interval');
				let $lastEndValue = $intervals.last().find("select[name*='supply_end']").val();
				let $i=0;
				//validation check if there is multiple ongoing option selected
					$('.supply-interval').find('option:selected').each(function($key,$val) {
		  							// console.log(	$(this).val());
		  							if($(this).val() == 'Ongoing'){
		  								 $i++;
		  							}
		  							console.log($key);
					});
					if($i > 1){
							$("#errormsg").text("Only last supply thru entry must be ONGOING!");
							return false;
					}

					// validation check for order/sequence of supply and thru
					// 	$('.supply_start').find('option:selected').each(function() {
					// 		    alert();
		  	// 						console.log(	$(this).val());
		  							
					// });


				if ($lastEndValue !== 'Ongoing') {
					$("#errormsg").text("Last supply thru entry must be ONGOING!");
				} else {
					$("#supply_form").submit();
				}

			});


		})
		;
	</script>
@endsection
