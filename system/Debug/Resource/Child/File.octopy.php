<div class="__debugbar_info">
	{{ count($data->file) }} Files Loaded
	<hr class="__debugbar_hr">
</div>
<div class="__debugbar_scroll">
	<table class="__debugbar_table">
		<td style="width: 10%;font-weight: bold;">No</td>
		<td style="width: 30%;font-weight: bold;">Name</td>
		<td style="width: 60%;font-weight: bold;">Location</td>
		@foreach($data->file as $i => $view)
		<tr>
			<td style="width: 10%;">{{ ++$i }}.</td>
			<td style="width: 30%;">{{ basename($view) }}</td>
			<td style="width: 60%;">{{ $view }}</td>
		</tr>
		@endforeach
	</table>
</div>