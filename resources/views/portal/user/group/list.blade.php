@extends('layouts.portal')

@SetTab('users')

@section('title')
	User Groups
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{route('eac.portal.user.list')}}">All Users</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					@yield('title')
				</li>
			</ol>
		</nav>
		<h2 class="m-0">
			@yield('title')
		</h2>
	</div><!-- end .titleBar -->

	<div class="actionBar">
		<a href="{{ route('eac.portal.user.group.create') }}" class="btn btn-success">
			<i class="fa-fw fas fa-users-class"></i> Add User Group
		</a>
	</div><!-- end .actionBar -->

	<div class="viewData">
		<div class="card mb-1 mb-md-4">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover" id="routeTBL">
					<thead>
					<tr>
						<th>Group Name</th>
						<th>Type</th>
						<th>Group Leader</th>
						<th class="no-search no-sort">Members</th>
						<th>Created At</th>
						<th class="no-search no-sort"></th>
					</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
					<tr>
						<th>Group Name</th>
						<th>Type</th>
						<th>Group Leader</th>
						<th class="no-search no-sort">Members</th>
						<th>Created At</th>
						<th class="no-search no-sort"></th>
					</tr>
					</tfoot>
				</table>
			</div>
			{{--@include('include.portal.modals.usergroup.ViewModal')--}}
		</div>
	</div><!-- end .viewData -->
@endsection

@section('scripts')
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script>
		$(document).ready(function () {
			$('#routeTBL tfoot th').each(function () {
				if ($(this).hasClass("no-search"))
					return;
				var title = $(this).text();
				$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
			});
			var dataTable = $('#routeTBL').DataTable({
				"paginationDefault": 10,
				"paginationOptions": [10, 25, 50, 75, 100],
				// "responsive": true,
				columnDefs: [{
					targets: 'no-sort',
					orderable: false,
				}],
				'order': [[0, 'asc']],
				"ajax": {
					url: "{{ route('eac.portal.user.grouplist.ajaxlist') }}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				"columns": [
					{
						"data": "name",
						'name': 'name',
						searchable: true,
						orderable: true,
					},
					{
						"data": "type",
						'name': 'type',
						searchable: true
					},
					{
						"data": "parent",
						'name': 'parent',
						searchable: true,
						orderable: true,
					},
					{
						"data": "members",
						'name': 'members',
						searchable: false
					},
					{
						"data": "created_at",
						"name": "created_at",
						orderable: true,
						searchable: true
					},
					{
						"data": "ops_btns",
						orderable: false,
						searchable: false
					}
				]
			});
			dataTable.columns().every(function () {
				var that = this;
				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that
							.search(this.value)
							.draw();
					}
				});
			});
			$.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
				swal({
					title: "Oh Snap!",
					text: "Something went wrong on our side. Please try again later.",
					icon: "warning",
				});
			};
		}); // end doc ready
		$(".alert").delay(2000).slideUp(200, function () {
			$(this).alert('close');
		});
		$( '#ViewModal' ).on( 'show.bs.modal', function (e) {
			$('.g-name').html('');
			$('.g-type').html('');
			$('.g-member').html('');
			$('.g-leader').html('');
			$('.g-url').attr('href','');
		    var target = e.relatedTarget;
		    // get values for particular rows
		    var tr = $( target ).closest( 'tr' );
		    var tds = tr.find( 'td' );
		    // set edit url
		    var id = tds[5].innerText;
			var url = '{{ route("eac.portal.user.group.edit", ":slug") }}';
			url = url.replace(':slug', id);
		    $('.g-name').html(tds[0].innerText);
		    $('.g-type').text(''+tds[1].innerText+'');
		    $('.g-member').html(tds[0].innerHTML.replace(tds[0].innerText, '').replace('<div style="display:none">', '').replace('</div>', ''));
		    $('.g-leader').html(tds[2].innerHTML);
			$('.g-url').attr('href',url);
		    // console.log(tds[0].innerText);
		    // console.log(tds[1].innerText);
		    // console.log(tds[5].innerText);
		    // console.log(tds[0].innerHTML);
		    // var html = tds[0].innerHTML;
		    // var arr = html.split('<div style="display:none">');
		    // var final=arr[1].split('</div>');
		    //  $('.g-member').html(final[0]);

		});
	</script>
@endsection
