<div class="__debugbar_info">
	{{ count((array)$data->session) }} Sessions Saved
	<hr class="__debugbar_hr">
</div>
<div class="__debugbar_scroll">
	<table class="__debugbar_table">
		<td style="width: 10%;font-weight: bold;">No</td>
		<td style="width: 40%;font-weight: bold;">Key</td>
		<td style="width: 50%;font-weight: bold;">Value</td>
		@php($i = 0)
		@foreach($data->session as $name => $session)
		<tr>
			<td style="width: 10%;">{{ ++$i }}.</td>
			<td style="width: 40%;">
				{{ $name }}
			</td>
			<td style="width: 50%;">{{ $session }}</td>
		</tr>
		@endforeach
	</table>
</div>