@extends('layouts.portal')

@section('title')
	View RID
@endsection

@section('styles')
	<style>
		.drug-logo {
			width: 30%;
			height: auto;
		}

		h1 .badge, h2 .badge, h3 .badge, h4 .badge {
			font-size: 14px;
			line-height: 18px;
		}

		@media screen and (min-width: 1200px) {
			:root {
				--leftCol: 230px;
				--rightCol: 675px;
			}

			.actionBar, .viewData > .alert, .masterBox {
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

		@media screen and (min-width: 1300px) {
			:root {
				--rightCol: 790px
			}

			#noteSlider .carousel-inner {
				height: 150px;
			}

			#noteSlider .carousel-inner p {
				font-size: 90%;
				max-height: 125px;
				overflow-y: scroll;
			}
		}

		@media screen and (min-width: 1400px) {
			:root {
				--leftCol: 220px;
				--rightCol: 900px;
			}

			#noteSlider .carousel-inner {
				height: 125px;
			}

			#noteSlider .carousel-inner p {
				max-height: 100px;
			}
		}

		.wizardSteps span.nav-rect {
			cursor: pointer;
			background: #e1e1e1;
			color: #212529;
		}

		.wizardSteps span.nav-rect.active {
			color: #fff;
		}

		.wizardSteps span.nav-rect::before {
			border-radius: 30%;
		}

		.thisone .wizardHead::before {
			content: '';
			background-color: #333E44;
			position: absolute;
			left: var(--leftCol);
			top: 0;
			display: block;
			height: 2.75rem;
			width: var(--rightCol);
		}
		.thisone .wizardHead::after {
			content: '';
			background-color: #f9f9f9;
			position: absolute;
			left: var(--leftCol);
			top: 2.75rem;
			display: block;
			height: 4rem;
			width: var(--rightCol);
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
							<a href="{{ route('eac.portal.rid.list') }}">All RIDs</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							{{$rid->number}}
						</li>
					</ol>
				</div>
				<div class="col-sm-auto ml-sm-auto d-none d-sm-block">
					<div class="small">
						<strong>Last Updated:</strong>
						@php
							$time = $rid->updated_at;
							$time->tz = "America/New_York";
							echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
						@endphp
					</div>
				</div>
			</div>
		</nav>
		{{-- <h6 class="title small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{$rid->number}}
		</h2> --}}
		<div class="small d-sm-none">
			<strong>Last Updated:</strong>
			@php
				$time = $rid->updated_at;
					$time->tz = "America/New_York";
					echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
			@endphp
		</div>
	</div><!-- end .titleBar -->
	@if(Session::has('alerts'))
		{!! view('layouts.alert-dismiss', ['type' => Session::get('alerts')['type'], 'message' => Session::get('alerts')['msg']]) !!}
	@endif
	<div class="viewData">
		@if(false)
			<div class="alert bg-primary text-white p-10 m-0" role="alert">
				<div class="row align-items-center">
					<div class="col-sm col-md-auto">
						<h3 class="m-0">
							<small><i class="far fa-sync-alt m-r-5"></i></small>
							Resupply Available
						</h3>
					</div>
					<div class="col-sm col-md-auto">
						<button type="submit" name="submit" value="fill_rid" class="btn btn-light">Fill Now</button>
					</div>
				</div>
			</div><!-- end alert -->
		@endif
		@if(false)
			<div class="alert bg-dark text-white p-10 m-0" role="alert">
				<div class="row align-items-center">
					<div class="col-sm col-md-auto">
						<h3 class="m-0">
							<small><i class="far fa-redo m-r-5"></i></small>
							Appeal Available
						</h3>
					</div>
					<div class="col-sm col-md-auto">
						<button type="submit" name="submit" value="appeal_rid" class="btn btn-light">
							Appeal Now
						</button>
					</div>
				</div>
			</div><!-- end alert -->
		@endif
		@include('portal.rid.show.master')
		@access('rid.visit.view')
		@if($rid->shipments->count() > 0)
			<div class="row justify-content-center justify-content-lg-start m-0 thisone">
				<div class="col-sm-3 col-xl-auto p-0 mb-2 mb-sm-0">
					<div class="wizardHead bg-dark text-white pt-2 pl-3 pb-2 h4">
						<h4 class="mb-1">
							RID Visits
						</h4>
					</div>
					<div id="tab" role="tablist" aria-orientation="vertical"
					     class="nav wizardSteps symbols flex-row flex-sm-column pl-0 OFF">
						@php $shipment_index = 1; @endphp
						<ul class="list-group list-group-flush flex-row flex-sm-column">
							@foreach($rid->shipmentsSorted() as $shipment)
								<li class="list-group-item">
									<span class="nav-link nav-rect {{$shipment->getTodo() === 'Ready'  ? 'complete' : ''}}"
									   id="xshipT{{$shipment->id}}" data-toggle="pill"
									   href="#xship{{$shipment->id}}"
									   role="tab" aria-controls="xship{{$shipment->id}}"
									   aria-selected="false">
										Shipment #{{$shipment_index}}
									</span>
									@foreach($shipment->visits->sortBy('index') as $visit)
										<a class="nav-link {{$visit->getDocStatus() ? 'complete' : ''}}"
										   id="xdetailsT{{$visit->index}}" data-toggle="pill"
										   href="#xdetails{{$visit->index}}"
										   role="tab" aria-controls="xdetails{{$visit->index}}"
										   aria-selected="false">
											<small class="text-upper">Visit #{{$visit->index == 0 ? 1 : $visit->index}}</small>
										</a>
									@endforeach
									@php $shipment_index ++; @endphp
								</li>
							@endforeach
						</ul>
					</div>
				</div>
				<div class="col-sm-9 col-xl p-0">
					<div class="tab-content wizardContent" id="tabContent">
						@php $shipment_index = 1; @endphp
						@foreach($rid->shipmentsSorted() as $shipment)
							@include('portal.rid.show.shipment')
							@php $shipment_index ++; @endphp
						@endforeach
						@foreach($rid->visits->sortBy('index') as $visit)
							@include('portal.rid.show.visit')
						@endforeach
					</div>
				</div>
			</div>
		@endif
		@endcan
	</div>
@endsection

@section('scripts')
	<script>
        (function ($) {
            $("a.country-tool-tip").tooltip();
            var allPanels = $('.Visit').hide();
            $('.ShowVisit').click(function () {
                allPanels.slideUp();
                if ($(this).attr('aria-expanded') === "true") {
                    $(this).attr('aria-expanded', false);
                } else {
                    $(".ShowVisit[aria-expanded]").attr('aria-expanded', false);
                    $(this).attr('aria-expanded', true);
                }
                let target = $(this).attr('target');
                if ($(target).css('display') === 'none') {
                    $(target).slideDown();
                }
                return false;
            });
        })(jQuery);
        $('.contemporary > .card > .collapse').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                scrollTop: $(this).offset().top - 80
            }, 500);
        });
	</script>
@endsection
