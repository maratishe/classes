<?php
set_time_limit( 6);
ob_implicit_flush( 1);
if ( count( $argv) != 2) die( 'bad argument');
$url = $argv[ 1] . '?rand=' . mt_rand( 100, 100000);
$c = 'wget -O web.txt ' . $argv[ 1] . ' 2>&1 3>&1'; `rm -Rf web.txt`;
$in = popen( $c, 'r'); $line = ''; // open a command line pipe
while ( $in && ! feof( $in)) {
	$line2 = trim( fgets( $in)); if ( ! $line2) continue;
	$line = $line2;
}
if ( $in) fclose( $in); `rm -Rf web.txt`; // remove the temp file again
if ( ! $line) die( 'bad data');
// parse the last line
$L = explode( '(', $line); if ( count( $L) != 2) die( 'bad data');
$L = explode( ' ', $L[ 1]); $number = array_shift( $L);
if ( ! is_numeric( $number)) die( 'bad data');
$unit = strtolower( array_shift( $L));
if ( strpos( $unit, 'k') === 0) $number *= 1000;
if ( strpos( $unit, 'm') === 0) $number *= 1000000;
die( "$number");

?>