@foreach($data as $row)
	@if($row->type === 'directory')
	@php
		$path = $row->path;
		if(preg_match('/\.\./', $path)) {
			$path = dirname(str_replace('..', '', $path));
		}
	@endphp
	<li>
		<a href="javascript:;" onclick="octopy('{{ $path }}', 'readdir');" class="grey-text text-darken-3 clearfix">
			<div class="row">
				<span class="file-name col m8 s9"><i class="{{ $row->icon }}"></i> {{ $row->name }}</span>
				<span class="file-size col m2 s2 text-right">{{ $row->size }}</span>
				<span class="file-modified col m2 hide-on-small-only text-right">{{ $row->time }}</span>
			</div>
		</a>
	</li>
	@else
	<li>
		<a href="javascript:;" onclick="octopy('{{ $row->path }}', 'download');" class="grey-text text-darken-3 clearfix">
			<div class="row">
				<span class="file-name col m8 s9">
				<i class="{{ $row->icon }}"></i> {{ $row->name }}</span>
				<span class="file-size col m2 s2 text-right">{{ $row->size }}</span>
				<span class="file-modified col m2 hide-on-small-only text-right">{{ $row->time }}</span>
			</div>
		</a>
	</li>
	@endif
@endforeach