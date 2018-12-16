<!-- ROUTE -->
<div class="__debugbar_info">
	Matched Route
	<hr class="__debugbar_hr">
</div>
<table class="__debugbar_table">
	<tr>
		<td class="__debugbar_strong" style="width: 90px;">URI</td>
		<td style="width: 10px;">:</td>
		<td>
			<font class="__debugbar_strong">
				@if(count($data->route->method) > 1)
					ANY
				@else
					{{ implode('', $data->route->method) }}
				@endif
			</font>
			{{ $data->route->target !== '' ? $data->route->target : $data->request->server->REQUEST_URI }}
		</td>
	</tr>
	<tr>
		<td class="__debugbar_strong" style="width: 90px;">Action</td>
		<td style="width: 10px;">:</td>
		<td>
			{{ $data->route->action !== '' ? $data->route->action : '-' }}
		</td>
	</tr>
	<tr>
		<td class="__debugbar_strong" style="width: 90px;">Parameter</td>
		<td style="width: 10px;">:</td>
		<td>{{ isset($data->route->params[0]) ? '1. ' . $data->route->params[0] : '-' }}</td>
	</tr>
	@foreach($data->route->params as $i => $param)
		@if($i == 0)
			@continue
		@endif
		<tr>
			<td></td>
			<td></td>
			<td>{{ ++$i }}. {{ $param }}</td>
		</tr>
	@endforeach
	<tr>
		<td class="__debugbar_strong" style="width: 90px;">Middleware</td>
		<td style="width: 10px;">:</td>
		<td>{{ isset($data->route->middleware[0]) ? '1. ' . $data->route->middleware[0] : '-' }}</td>
	</tr>
	@foreach($data->route->middleware as $i => $middleware)
		@if($i == 0)
			@continue
		@endif
		<tr>
			<td></td>
			<td></td>
			<td>{{ ++$i }}. {{ $middleware }}</td>
		</tr>
	@endforeach
	
	@if($data->route->name != '')
	<tr>
		<td class="__debugbar_strong" style="width: 90px;">Route Name</td>
		<td style="width: 10px;">:</td>
		<td>
			{{ $data->route->name }}
		</td>
	</tr>
	@endif
</table>