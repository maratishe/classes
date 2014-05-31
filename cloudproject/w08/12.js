
$( 'body').append( '<div>CLICKME</div>');
$( 'div').click( function() {
	// hide the button
	$( 'div').fadeOut( 'slow', function() { $( 'body').append( 'waiting...'); })
	// send post request
	$.post( 'index.php', { key: 'value'}, function( v) { 
		$( 'body').empty().append( 'OK(' + v + ')');
	})
	
})

