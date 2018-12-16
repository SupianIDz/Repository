@php
	use \Octopy\Support\Syntax;
	use \Octopy\Support\Request;
	use \Octopy\Support\Response;

	$errorID = uniqid('error');

	
	if(!function_exists('cleanpath')) {
		/**
	 	 * @param  string $path
	 	 * @return string
	 	 */
		function cleanpath(string $path) : string
		{
			return str_replace(BASEPATH, '/', $path);
		}
	}

	if(!function_exists('describe')) {
		/**
	 	 * @param  int    $bytes
	 	 * @return string
	 	*/
		function describe(int $bytes) : string
		{
   			if ($bytes < 1024) {
      			return $bytes . 'B';
   			} elseif ($bytes < 1048576) {
      			return round($bytes / 1024, 2) . 'KB';
    		}

		   	return round($bytes / 1048576, 2) . 'MB';
		}
	}
	
@endphp
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">
	<title>{{ htmlspecialchars($title, ENT_SUBSTITUTE, 'UTF-8') }}</title>
	<style type="text/css">
		{{ preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(octopy('Debug.Resource.CSS', 'Debug.css')))  }}
	</style>
	<script type="text/javascript">
		{{ file_get_contents(octopy('Debug.Resource.JS', 'Debug.js')) }}
	</script>
</head>
<body onload="init()">
	<div class="header">
		<div class="container">
			<h1>{{ htmlspecialchars($title, ENT_SUBSTITUTE, 'UTF-8'), ($code ? ' #'.$code : '') }}</h1> <p>
				{{ $message }}
				<a href="https://www.google.com/search?q={{ urlencode($title.' '.preg_replace('#\'.*\'|".*"#Us', '', $message)) }}"
				   rel="noreferrer" target="_blank">Search &rarr;</a>
			</p>
		</div>
	</div>

	<div class="container">
		<p style="font-weight: bold;">{{ cleanpath($file) }}#{{ $line }}</p>
		@if (is_file($file))
			{{ Syntax::offset($line - 8, $line + 8)->highlight($file, $line) }}
		@endif
	</div>
	<div class="container">
		<ul class="tabs" id="tabs">
			<li><a href="#backtrace">Backtrace</a></li>
				<li><a href="#server">Server</a></li>
				<li><a href="#request">Request</a></li>
				<li><a href="#response">Response</a></li>
				<li><a href="#files">Files</a></li>
				<li><a href="#memory">Memory</a></li>
			</li>
		</ul>
		<div class="tab-content">
			<div class="content" id="backtrace">
				<ol class="trace">
				@foreach ($trace as $index => $row)
					<li><p>
						
						@if(isset($row['file']) && is_file($row['file']))
							@if(isset($row['function']) && in_array($row['function'], ['include', 'include_once', 'require', 'require_once']))
                				{{ $row['function'].' '. cleanpath($row['file']) }}
               	 			@else
                				{{ cleanpath($row['file']).' : '.$row['line'] }}
                			@endif
						@else
							{ PHP Internal Code }
						@endif

						@if(isset($row['class']))
							&nbsp;&nbsp;&mdash;&nbsp;{{ $row['class'].$row['type'].$row['function'] }}
							@if (! empty($row['args']))
								@php($args_id = $errorID.'args'.$index)
								( <a href="#" onclick="return toggle('{{ $args_id }}');">arguments</a> )
								<div class="args" id="{{ $args_id }}">
									<table cellspacing="0">
										@php
			                    		$params = null;
                      				if (substr($row['function'], -1) !== '}') {
                          				$mirror = isset($row['class']) ? new \ReflectionMethod($row['class'], $row['function']) : new \ReflectionFunction($row['function']);
                          				$params = $mirror->getParameters();
                        			}
                    				@endphp
                    				@foreach ($row['args'] as $key => $value)
											<tr>
												<td>
													<code>
														{{ htmlspecialchars(isset($params[$key]) ? '$'.$params[$key]->name : "#$key", ENT_SUBSTITUTE, 'UTF-8') }}
													</code>
												</td>
												<td>
													<pre>
														@php(print_r($value, true))
													</pre>
												</td>
											</tr>
										@endforeach
										</table>
									</div>
								@else
									()
								@endif
							@endif
							@if (!isset($row['class']) && isset($row['function']))
								&nbsp;&nbsp;&mdash;&nbsp;&nbsp;{{ $row['function'] }}()
							@endif
						</p>
						@if(isset($row['file']) && is_file($row['file']) &&  isset($row['class']))
							{{ Syntax::offset($row['line'] - 5, $row['line'] + 5)->highlight($row['file'], $row['line']) }}
						@endif
					</li>
				@endforeach
				</ol>
			</div>
			<div class="content" id="server">
				@foreach (['_SERVER', '_SESSION'] as $var)
					@if (empty($GLOBALS[$var]) || ! is_array($GLOBALS[$var]))
						@continue
					@endif
					<h3>${{ $var }}</h3>
					<table>
						<thead>
							<tr>
								<th>Key</th>
								<th>Value</th>
							</tr>
						</thead>
						<tbody>
						@foreach ($GLOBALS[$var] as $key => $value)
							<tr>
								<td>{{ htmlspecialchars($key, ENT_IGNORE, 'UTF-8') }}</td>
								<td>
									@if (is_string($value))
										@if($value == '')
											-
											@continue
										@endif
										{{ htmlspecialchars(strip_tags($value), ENT_SUBSTITUTE, 'UTF-8') }}
									@else
										{{ print_r($value, true) }}
									@endif
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endforeach
				@php($constants = get_defined_constants(true))
				@if (! empty($constants['user']))
					<h3>Constants</h3>
					<table>
						<thead>
							<tr>
								<th>Key</th>
								<th>Value</th>
							</tr>
						</thead>
						<tbody>
						@foreach ($constants['user'] as $key => $value)
							<tr>
								<td>{{ htmlspecialchars($key, ENT_IGNORE, 'UTF-8') }}</td>
								<td>
									@if (!is_array($value) && ! is_object($value))
										{{ htmlspecialchars($value, ENT_SUBSTITUTE, 'UTF-8') }}
									@else
										{{ '<pre>'.print_r($value, true) }}
									@endif
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endif
			</div>
			<div class="content" id="request">
				@php($request = Request::instance())
				<table>
					<tbody>
						<tr>
							<td style="width: 10em">Path</td>
							<td>{{ $request->uri() }}</td>
						</tr>
						<tr>
							<td>HTTP Method</td>
							<td><?= $request->method() ?></td>
						</tr>
						<tr>
							<td>IP Address</td>
							<td>{{ $request->ip() }}</td>
						</tr>
						<tr>
							<td style="width: 10em">AJAX Request</td>
							<td>{{ $request->ajax() ? 'Yes' : 'No' }}</td>
						</tr>
						<tr>
							<td>CLI Request</td>
							<td>{{ $request->cli() ? 'Yes' : 'No' }}</td>
						</tr>
						<tr>
							<td>HTTPS</td>
							<td>{{ $request->secure() ? 'Yes' : 'No' }}</td>
						</tr>
						<tr>
							<td>User Agent</td>
							<td>{{ $request->uagent() }}</td>
						</tr>

					</tbody>
				</table>
				@php($empty = true)
				@foreach (['_GET', '_POST', '_COOKIE'] as $var)
					@if (empty($GLOBALS[$var]) || ! is_array($GLOBALS[$var]))
          			@continue
					@endif
					@php($empty = false)
					<h3>${{ $var }}</h3>
					<table style="width: 100%">
						<thead>
							<tr>
								<th>Key</th>
								<th>Value</th>
							</tr>
						</thead>
						<tbody>
						@foreach ($GLOBALS[$var] as $key => $value)
							<tr>
								<td>{{ htmlspecialchars($key, ENT_IGNORE, 'UTF-8') }}</td>
								<td>
									@if (!is_array($value) && ! is_object($value))
										{{ htmlspecialchars($value, ENT_SUBSTITUTE, 'UTF-8') }}
									@else
										{{ print_r($value, true) }}
									@endif
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endforeach
				@if ($empty)
					<div class="alert">
						No $_GET, $_POST, or $_COOKIE Information to show.
					</div>
				@endif
				@php($headers = $request->headers())
				@if (!empty($headers))
					<h3>Headers</h3>
					<table>
						<thead>
							<tr>
								<th>Header</th>
								<th>Value</th>
							</tr>
						</thead>
						<tbody>
						@foreach ($headers as $name => $value)
							@if (empty($value))
               			@continue;
            			@endif
							<tr>
								<td>{{ $name }}</td>
								<td>{{ $value }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endif
			</div>
			@php
				$response = Response::code($code);
			@endphp
			<div class="content" id="response">
				<table>
					<tr>
						<td style="width: 15em">Response Status</td>
						<td>{{ $response->status().' - '.$response->reason($code) }}</td>
					</tr>
				</table>
				@php($headers = $response->headers())
				@if (!empty($headers))
					@php(natsort($headers))
					<h3>Headers</h3>
					<table>
						<thead>
							<tr>
								<th>Header</th>
								<th>Value</th>
							</tr>
						</thead>
						<tbody>
						@foreach ($headers as $name => $value)
							<tr>
								<td>{{ strip_tags($name) }}</td>
								<td>{{ strip_tags($value) }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endif
			</div>
			<div class="content" id="files">
				@php($files = get_included_files())
				<ol>
					@foreach ($files as $file)
						<li>{{ htmlspecialchars(cleanpath($file), ENT_SUBSTITUTE, 'UTF-8')  }}</li>
					@endforeach
				</ol>
			</div>
			<div class="content" id="memory">
				<table>
					<tbody>
						<tr>
							<td>Memory Usage</td>
							<td>{{ describe(memory_get_usage(true)) }}</td>
						</tr>
						<tr>
							<td style="width: 12em">Peak Memory Usage:</td>
							<td>{{ describe(memory_get_peak_usage(true)) }}</td>
						</tr>
						<tr>
							<td>Memory Limit:</td>
							<td>{{ ini_get('memory_limit') }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div> 
	</div>
	<div class="footer">
		<div class="container">
			<p>
				Displayed at {{ date('H:i:s') }} &mdash;
				PHP : {{ substr(phpversion(), 0, 6) }}  &mdash;
				Octopy Framework : {{ \Octopy\Application::VERSION }}
			</p>
		</div>
	</div>
</body>
</html>
