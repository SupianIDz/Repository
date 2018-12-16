<div class="__debugbar_info">
	HTTP Request
	<hr class="__debugbar_hr">
</div>
<div class="__debugbar_scroll">
	@if(!empty((array)$data->request->data))
		<h3>Request Query</h3>
		<table class="__debugbar_table">
			@foreach($data->request->data as $key => $value )
				@if($key == 'OCTOPY_CSRF')
					@continue
				@endif
				<tr>
					<td style="width: 250px;"><font class="__debugbar_strong">{{ $key }}</font></td>
					<td style="width: 10px;">:</td>
					<td>{{ $value }}</td>
				</tr>
			@endforeach
		</table>
	@endif
	@if(!empty((array)$data->request->response->header))
		<h3>Response Header</h3>
		<table class="__debugbar_table">
			@foreach($data->request->response->header as $key => $value )
				<tr>
					<td style="width: 250px;">
						<font class="__debugbar_strong">{{ str_replace('-', ' ', $key) }}</font>
					</td>
					<td style="width: 10px;">:</td>
					<td>{{ $value }}</td>
				</tr>
			@endforeach
		</table>
	@endif
	<h3>Request Header</h3>
	<table class="__debugbar_table">
		@foreach($data->request->header as $key => $value )
			<tr>
				<td style="width: 250px;">
					<font class="__debugbar_strong">{{ str_replace('-', ' ', $key) }}</font>
				</td>
				<td style="width: 10px;">:</td>
				<td>{{ $value !== '' ? $value : '-' }}</td>
			</tr>
		@endforeach
	</table>
	<h3>Request Server</h3>
	<table class="__debugbar_table">
		@foreach($data->request->server as $key => $value )
			<tr>
				<td style="width: 250px;">
					<font class="__debugbar_strong">{{ str_replace('_', ' ', $key) }}</font>
				</td>
				<td style="width: 10px;">:</td>
				<td>{{ $value !== '' ? $value : '-' }}</td>
			</tr>
		@endforeach
	</table>
</div>