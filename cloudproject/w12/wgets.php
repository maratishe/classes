<?php
set_time_limit( 0);
ob_implicit_flush( 1);
if ( count( $argv) != 3) die( 'bad argument');
function tsystem() {	// epoch of system time
	$list = @gettimeofday();
	return ( double)( $list[ 'sec'] + 0.000001 * $list[ 'usec']);
}
$c = 'php wget.php ' . $argv[ 1] . ' 2>/dev/null 3>/dev/null'; $startime = tsystem(); 
$count = round( $argv[ 2]); while ( $count--) {
	$in = @popen( $c, 'r'); 
	if ( $in && ! feof( $in)) $number = trim( fgets( $in));
	if ( $in) fclose( $in);
	if ( ! $number || ! is_numeric( $number)) continue;
	echo ( tsystem() - $startime) . ',' . $number . "\n";
}


?>