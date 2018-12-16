@php
	if(!function_exists('memory')) {
		function memory($byte) {
			if ($byte < 1024) {
                return ' ' .$byte . 'B';
            } elseif ($byte < 1048576) {
                return ' ' . round($byte / 1024, 2) . 'KB';
            }

            return ' ' . round($byte / 1048576, 2) . 'MB';
		}
	}
@endphp
<div class="__debugbar_info">
	{{ count($data->view) }} Templates Were Rendered
	<hr class="__debugbar_hr">
</div>
<div class="__debugbar_scroll">
	<table class="__debugbar_table">
		<td style="width: 10%;font-weight: bold;">No</td>
		<td style="width: 30%;font-weight: bold;">Name</td>
		<td style="width: 40%;font-weight: bold;">Location</td>
		<td style="width: 10%;font-weight: bold;">Memory Usage</td>
		<td style="font-weight: bold;">Time Elapsed</td>
		@foreach($data->view as $i => $row)
			<tr>
				<td>{{ ++$i }}.</td>
				<td>
					{{ basename($row->template) }}
				</td>
				<td>{{ $row->template }}</td>
				<td><i class="octopy-cogs"></i>{{ memory($row->memory) }}
				<td><i class="octopy-clock"></i>{{ round($row->time * 1000, 3) }}ms</td>
			</tr>
		@endforeach
	</table>
</div>