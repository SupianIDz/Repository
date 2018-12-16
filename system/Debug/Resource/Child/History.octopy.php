@php($storage = config('debugbar.storage'))
<div class="__debugbar_info">
	{{ count($data) }} History
	<font style="float: right;" onclick="__debugbar_delete('all');"><i class="octopy-trash"></i>Delete All History</font>
	<hr class="__debugbar_hr">
</div>
<div class="__debugbar_scroll">
	<table class="__debugbar_table">
		<thead>
			<td style="width: 15%;font-weight: bold;">Date</td>
			<td style="width: 10%;font-weight: bold;">Method</td>
			<td style="width: 33%;font-weight: bold;">URL</td>
			<td style="width: 10%;font-weight: bold;">IP</td>
			<td style="width: 10%;font-weight: bold;">Ajax</td>
			<td style="width: 10%;font-weight: bold;">Status Code</td>
			<td style="font-weight: bold;">Action</td>
		</thead>
		<tbody>
			@foreach($data as $i => $file)
			@php($json = json_decode(file_get_contents($storage . $file)))
			<tr>
				<td>{{ $json->datetime }}</td>
				<td>{{ $json->request->server->REQUEST_METHOD }}</td>
				<td>
					{{ $json->route->target !== '' ? $json->route->target : $json->request->server->REQUEST_URI }}
				</td>
				<td>{{ $json->request->server->REMOTE_ADDR }}</td>
				<td>{{ $json->request->ajax == true ? 'Yes' : 'No' }}</td>
				<td>{{ $json->request->response->status }}</td>
				<td>
					<font onclick="__debugbar_reload('{{ $file }}');"><i class="octopy-search"></i>Show</font>
					- 
					<font onclick="__debugbar_delete('{{ $file }}');"><i class="octopy-trash"></i>Delete</font>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>