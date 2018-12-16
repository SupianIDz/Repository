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
	{{ count($data->query) }} Statements Were Executed
	<hr class="__debugbar_hr">
</div>
<div class="__debugbar_scroll">
	<table class="__debugbar_table">
		<td style="width: 10%;font-weight: bold;">No</td>
		<td style="width: 70%;font-weight: bold;">Query</td>
		<td style="width: 10%;font-weight: bold;">Memory Usage</td>
		<td style="font-weight: bold;">Time Elapsed</td>
		@php($i = 0)
		@foreach($data->query as $row)
		<tr>
			<td>{{ ++$i }}.</td>
			<td class="__debugbar_sql">{{ $row->query }}</td>
			<td><i class="octopy-cogs"></i>{{ memory($row->memory) }}</td>
			<td><i class="octopy-clock"></i>{{ round($row->time * 1000, 3) }}ms</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>