$(document).ready(function() {
	octopy('/', 'readdir');
});

window.octopy = function(location, mode) {
	$.ajax({
		headers: {
			'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
		},
		url: '/octopy',
		type: 'POST',
		data: { location : location, mode : mode },
	})
	.done(function(e) {
		if(mode === 'readdir') {
			$('div.repository').html(e);
		} else if(mode === 'download') {
			window.location = '/download';
		}
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});	
}