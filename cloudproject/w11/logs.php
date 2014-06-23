<?php
set_time_limit( 0);
ob_implicit_flush( 1);
$c = 'heroku logs 2>&1 3>&1'; 
$in = popen( $c, 'r');
echo "date,time,dyno,connect(ms),service(ms),bytes\n"; $H = is_file( '../state.json') ? json_decode( array_shift( file( '../state.json')), true) : array();
while ( $in && ! feof( $in)) {
	$line = trim( fgets( $in)); if ( ! $line) continue;
	//echo "line#$line\n";
	$L = explode( ' ', $line); $time = array_shift( $L); if ( ! count( $L)) continue; 
	if ( strpos( $L[ 0], 'heroku[router]') !== 0) continue;
	$L2 = explode( 'T', $time);  $date = array_shift( $L2); 
	$L3 = explode( '+', array_shift( $L2)); $time = array_shift( $L3); 
	if ( ! $time) continue;
	// try to parse
	$line = str_replace( '"', '', $line); $L = explode( ' ', $line); $h = array();
	foreach ( $L as $one) {
		$L2 = explode( '=', $one); if ( count( $L2) != 2) continue;
		$k = array_shift( $L2); $v= array_shift( $L2);
		$h[ $k] = $v;
	}
	if ( ! isset( $h[ 'dyno']) || ! $h[ 'dyno'] || ! isset( $h[ 'bytes'])) continue;
	$dyno = $h[ 'dyno']; $bytes = $h[ 'bytes'];
	$connect = str_replace( 'ms', '', $h[ 'connect']);
	$service = str_replace( 'ms', '', $h[ 'service']);
	$h = compact( explode( ',', 'date,time,dyno,bytes,connect,service'));
	$H[ "$date $time"] = $h; echo implode( ',', array_values( $h)) . "\n"; 
}
ksort( $H); fclose( $in);
$out = fopen( '../state.json', 'w'); fwrite( $out, json_encode( $H)); fclose( $out);
$out = fopen( '../state.csv', 'w'); fwrite( $out, "date,time,dyno,connect(ms),service(ms),bytes\n"); 
foreach ( $H as $k => $h) fwrite( $out, implode( ',', array_values( $h)) . "\n"); 
fclose( $out);

?>