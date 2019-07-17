@if($template_url == 'not_found')

	<div class="">
		<strong class="d-block label_required">Blank File </strong>
		<input class="form-control" type="file" name="template_file" required="required" />
	</div>

@else
	<div class="">
		<strong class="d-block label_required">Template</strong>
		<div class="input-group">
			<input disabled="" class="form-control" placeholder="{{ $template_name }}">
			<input type="hidden" name="file_id" value="{{ $file_id}}"/>
			<input type="hidden" name="template_id" value="{{$template_id}}"/>
			<div class="input-group-append">
				<a href="{{ $template_url }}" class="btn btn-primary">
					<i class="far fa-file-pdf fa-2x"></i>
				</a>
			</div>
		</div>
	</div>
@endif
