<div class="{{ $file_id }}_1">
    <span onclick="show_hide('{{ $file_id }}', '1')">
        <i class="far fa-edit text-success"></i>
        </span> &nbsp;
	<a href="{{ url('uploads/templates/'.$file_name) }}" target="_blank">
		<i class="far fa-file-pdf"></i> {{ $file_name}}
	</a>
</div>

<div class="{{ $file_id }}_2" style="display:none">
    <span onclick="show_hide('{{ $file_id }}', '2')">
        <i class="far fa-times text-danger"></i>
    </span> &nbsp
	<input type="file"/>
</div>