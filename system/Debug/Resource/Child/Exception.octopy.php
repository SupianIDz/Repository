<!-- ROUTE -->
<div class="__debugbar_info">
	Matched Route
	<hr class="__debugbar_hr">
</div>
<table class="__debugbar_table">
	<tr>
		<td class="__debugbar_strong" style="width: 90px;">Exception</td>
		<td style="width: 10px;">:</td>
		<td>{{ $data->exception->title ?? '-' }}</td>
	</tr>
	<tr>
		<td class="__debugbar_strong" style="width: 90px;">Message</td>
		<td style="width: 10px;">:</td>
		<td>{{ $data->exception->message ?? '-' }}</td>
	</tr>
	<tr>
		<td class="__debugbar_strong" style="width: 90px;">Location</td>
		<td style="width: 10px;">:</td>
		<td>
			{{ isset($data->exception->file) ? str_replace(BASEPATH, '/', $data->exception->file) . '#' : '-' }}{{ $data->exception->line ?? '' }}
		</td>
	</tr>
	<tr>
		<td class="__debugbar_strong" style="width: 90px;">Backtrace</td>
		<td style="width: 10px;">:</td>
		<td>
			@if(isset($data->exception->trace))
				1.
				@php($trace = $data->exception->trace[0])
				@if(isset($trace->file) && is_file($trace->file))
					@if(isset($trace->function) && in_array($trace->function, ['include', 'include_once', 'require', 'require_once']))
						{{ $trace->function }} {{ $trace->file }}
					@else
						{{ str_replace(BASEPATH, '/', $trace->file) }} #{{ $trace->line }}
					@endif
				@else
					{PHP Internal Code}
				@endif

				@if(isset($trace->class))
					&mdash;&nbsp;{{ $trace->class . $trace->type . $trace->function }}()
				@endif
			@else
				-
			@endif
		</td>
	</tr>
	@if(isset($data->exception->trace))
	@foreach($data->exception->trace as $i => $trace)
		@if($i == 0)
			@continue
		@endif
		<tr>
			<td></td>
			<td></td>
			<td>
				{{ ++$i }}.
				@if(isset($trace->file) && is_file($trace->file))
					@if(isset($trace->function) && in_array($trace->function, ['include', 'include_once', 'require', 'require_once']))
						{{ $trace->function }} {{ $trace->file }}
					@else
						{{ str_replace(BASEPATH, '/', $trace->file) }} #{{ $trace->line }}
					@endif
				@else
					{PHP Internal Code}
				@endif

				@if(isset($trace->class))
				&mdash;&nbsp;{{ $trace->class . $trace->type . $trace->function }}()
				@endif
			</td>
			
		</tr>
	@endforeach
	@endif
</table>