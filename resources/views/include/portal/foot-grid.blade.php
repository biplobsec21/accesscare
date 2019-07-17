</div><!-- /#pcont --><!-- DO NOT REMOVE -->
</div><!-- /.container-fluid --><!-- DO NOT REMOVE -->
</div><!-- /#content-wrapper --><!-- DO NOT REMOVE -->
<div class="copyright align-self-end">
	<div class="row align-items-center">
		<div class="col-sm mb-1 mb-sm-0">
			&copy; {{site()->establishment}} {{site()->name}}
		</div>
		<div class="col-sm mb-1 mb-sm-0">
			<ul class="nav justify-content-end mb-0">
				<li class="nav-item">
					<a class="nav-link" href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="https://www.earlyaccesscare.com/aboutus.htm">About Us</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="https://www.earlyaccesscare.com/safety_reporting.htm">Safety Reporting</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="https://www.earlyaccesscare.com/contact.htm">Contact EAC</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="rightSide">
	<button class="toggleRight btn floater" type="button">
		<i class="far fa-times"></i>
	</button>
	<div class="row align-items-center mt-3 ml-0 mr-0">
		<div class="col">
			<h5 class="m-0">
				<i class="far fa-bell text-primary"></i> Notifications
			</h5>
		</div>
		<div class="col-auto ml-auto">
			<a href="{{ route('eac.portal.notifications.read.all',Auth::user()->id) }}" class="btn btn-sm btn-light"
			   tabindex="-1">
				<i class="fa-fw far fa-check text-success"></i> Mark All Read
			</a>
		</div>
	</div>
	<div class="tasklist">
		<div class="notificationlist">
			@php $user = Auth::user() @endphp
			@if($user->notifications()->count() > 0)
				<ul class="list-unstyled">
					@foreach($user->notifications() as $notification)
						<li class="{{ ($notification->read_at) ? 'read': 'unread'}}">
							<a onclick="notificationSingleRead('{{$notification->id}}')"
							   href="{{$notification->subject->view_route}}"
							   class="strong">
								{{ $notification->message }}
								<small class="d-block date">
									{{date('Y-m-d', strtotime($notification->created_at))}}
								</small>
							</a>
						</li>
					@endforeach
				</ul>
			@else
				<p class="text-muted m-0 small">
					<i class="fal fa-info-circle"></i> No information available
				</p>
			@endif
		</div>
	</div>
</div>
</div><!--- /#wrapper -->
<a class="scroll-to-top rounded" href="#page-top">
	<i class="fas fa-angle-up"></i>
</a>
</div><!-- /#DONOTREMOVE"> --><!-- DO NOT REMOVE -->
<code>/foot-grid.blade.php</code>
<script>
	$(document).on("click", ".table tr td:last-child .btn", function () {
		$("tr.selected").removeClass("selected");
		$(this).parents("tr").addClass("selected");
	});
	$(function () {
		$("body").tooltip({selector: '[data-toggle=tooltip]'});
	});

	function readnotification(nid) {
		$url = 'eac.portal.rid.readnotification';
		$.ajax({
			type: 'POST',
			url: "{{ route('eac.portal.rid.readnotification') }}",
			data: {
				'nid': nid
			},
			success: function (data) {
				window.location.reload();
			}
		});
	}

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function () {

		$('.select2').select2({
			placeholder: "-- Select --"
		});

		$('.datepicker').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			beforeShow: function (input, inst) {
				var rect = input.getBoundingClientRect();
				setTimeout(function () {
					inst.dpDiv.css({top: rect.top + 40, left: rect.left + 0});
				}, 0);
			}
		});
		$('.radio-group .radio').click(function () {
			$(this).parent().find('.radio').removeClass('selected');
			$(this).addClass('selected');
			var val = $(this).attr('data-value');
			//alert(val);
			$(this).parent().find('input').val(val);
		});

		var dragula_obj = dragula([$(".drag_container")[0]]);

		tinymce.init({
			selector: '.editor',
			menubar: false,
			plugins: 'code autolink directionality visualblocks visualchars image link media codesample table charmap hr advlist lists wordcount imagetools help',
			toolbar: 'formatselect charmap | bold italic strikethrough | link image media | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat | autolink directionality visualchars hr advlist lists wordcount imagetools | table tabledelete tableprops | codesample visualblocks code',
			image_advtab: true,
			powerpaste_word_import: 'clean',
			powerpaste_html_import: 'clean',
			content_css: [
				'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css',
				'https://pro.fontawesome.com/releases/v5.8.1/css/all.css',
				'http://v2adev.earlyaccesscare.com/css/core.css',
				'http://v2adev.earlyaccesscare.com/css/public.css'
			]
		});
		tinymce.init({
			selector: '.basic-editor',
			menubar: false,
			plugins: 'code autolink link hr lists',
			toolbar: 'bold italic strikethrough | link | alignleft aligncenter alignright alignjustify | numlist bullist | hr lists | code',
			image_advtab: true,
			powerpaste_word_import: 'clean',
			powerpaste_html_import: 'clean',
			content_css: [
				'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css',
				'https://pro.fontawesome.com/releases/v5.8.1/css/all.css',
				'http://v2adev.earlyaccesscare.com/css/core.css',
				'http://v2adev.earlyaccesscare.com/css/public.css'
			]
		});


		// Toggle the side navigation
		$(".sidebarToggle").on('click', function (e) {
			e.preventDefault();
			$(".sidebar").toggleClass("toggled");
			$(".sidebar").toggleClass("slideout");
			$("body").toggleClass("hack");
			document.cookie = "sidebar_class=" + ($(".sidebar").hasClass("toggled") ? "toggled" : "");
		});

		$(".toggleRight").on('click', function (e) {
			e.preventDefault();
			$("body").toggleClass("ShowASide");
			$(".rightSide").toggleClass("show");
		});

		$(".overlay, .sidebarToggle").on('click', function (e) {
			e.preventDefault();
			$("body").removeClass("ShowASide");
			$("body").removeClass("hack");
			$("body").removeClass("ShowNotifications");
			$(".rightSide").removeClass("show");
			$(".slideDown").removeClass("show");
		});

		$('.SObasic').DataTable({
			responsive: false,
			paginationOptions: [10, 25, 50, 75, 100],
			order: [0, "asc"],
			columnDefs: [{
				targets: 'no-sort',
				orderable: false,
			}],
			fnDrawCallback: function () {
				jQuery("input[data-toggle='toggle']").bootstrapToggle();
			}
		});

		$('.resourcesDT').DataTable({
			info: false,
			columnDefs: [{
				targets: 'no-sort',
				orderable: false,
			}]
		});

		$('.sortsearch').DataTable({
			responsive: true,
			info: false,
			paging: false,
			columnDefs: [{
				targets: 'no-sort',
				orderable: false,
			}]
		});

		$('.cusGem').DataTable({
			dom: 'rt<"justify-content-between d-flex align-items-center border-top border-light pt-2 mt-1"lfp>',
			responsive: true,
			columnDefs: [{
				targets: 'no-sort',
				orderable: false,
			}]
		});

		// Scroll to top button appear
		$(document).on('scroll', function () {
			var scrollDistance = $(this).scrollTop();
			if (scrollDistance > 100) {
				$('.scroll-to-top').fadeIn();
			} else {
				$('.scroll-to-top').fadeOut();
			}
		});

		// Smooth scrolling using jQuery easing
		$(document).on('click', 'a.scroll-to-top', function (event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: ($($anchor.attr('href')).offset().top)
			}, 1000, 'easeInOutExpo');
			event.preventDefault();
		});
	});

	function notificationSingleRead($id) {

		var notificationid = $id;
		console.log(notificationid);
		$.ajax({
			url: "{{route('eac.portal.notifications.read.single')}}",
			method: "POST",
			data: {'notificationid': notificationid},
			success: function (data) {
				console.log(data);
			},
			error: function (errMsg) {
				console.log(errMsg);
			}
		});


	}

	$(document).ready(function () {
		$('.v-active').show();
		$('.v-inactive').hide();

		// keep the tab active and show after submitting form
		var pageHref = jQuery(location).attr('href');

		$('a[data-toggle="pill"]').on('click', function (e) {
			var activeTabId = this.id;
			var getAreaControl = $(this).attr("aria-controls");

			localStorage.setItem('activeTab', activeTabId);
			localStorage.setItem('activeArea', getAreaControl);
			localStorage.setItem('page', pageHref);

			let selector = ':nth-child(' + $(this).index() + ')';
			$('.wizardSteps').each(function () {
				$('.nav-link[aria-selected="true"]').attr('aria-selected', false);
				$('.nav-link.active').removeClass('active');
				$('.wizardSteps').children(selector).addClass('active show').attr('aria-selected', true);
			});
		});

		var activeTab = localStorage.getItem('activeTab');
		var activeArea = localStorage.getItem('activeArea');
		var pageName = localStorage.getItem('page');

		if (activeTab && pageName === pageHref) {
			$('.wizardSteps').find('a:first').removeClass('active show');
			var aRc = $('.wizardSteps').find('a:first').attr("aria-controls");
			$("#" + aRc).removeClass('active show');

			$('#' + activeTab).addClass('active');
			$('#' + activeArea).addClass('active show');
		} else {
			$('.wizardSteps').find('a:first').addClass('active show');
			var aRc = $('.wizardSteps').find('a:first').attr("aria-controls");
			$("#" + aRc).addClass('active show');

		}

		//if Url has a hash and there is a tab with the hash value, open that tab
		if (window.location.hash !== "") {
			$('a[href="' + window.location.hash + '"]').click()
		}
	});

	function showactiveOrAll(param) {
		// alert();
		if (param == 1) {
			$('.v-active').show();
			$('.v-inactive').hide();
		}
		if (param == 0) {
			$('.v-active').show();
			$('.v-inactive').show();
		}
	}
</script>
