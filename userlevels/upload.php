<?php
	$DATA = $HTTP_RAW_POST_DATA;

	if(preg_match( "/Name: ([^\n]+)/", $DATA, $results ))
	{
		$levelname = $results[1];
	}

	if(preg_match( "/Creator: ([^\n]+)/", $DATA, $results ))
	{
		$author = $results[1];
	}

	$pos = strpos( $DATA, "BANDANA LEVEL");
	if( pos )
	{
		$levelcontent = substr( $DATA, $pos );
	}

	if( isset($levelname) && isset($author) && isset($levelcontent))
	{
		echo "Received level '$levelname' by '$author'.\n";
	} else {
		echo "Error: Invalid data: missing level name, author or content!\n";
	}
	$result = mkdir( "tmplevels/$author", 0775, true );
	$result = file_put_contents( "tmplevels/$author/$levelname.dat", $levelcontent );

	$output = shell_exec( "lua levelVerification.lua tmplevels/$author/$levelname.dat 2>&1" );

	// check if there were errors (ugly, but command line lua does not seem to give back useful error codes...?):
	if( stripos($output, "Error:") )
	{
		unlink( "tmplevels/$author/$levelname.dat" );
		echo( substr($output, stripos($output, "Error:")));
		echo "Error in level file.\n";
		echo "Removed temporary file.\n";
	} else {
		$result = mkdir( "unauthorized/$author", 0775, true );
		//echo "Mkdir: $result\n";
		$result = rename( "tmplevels/$author/$levelname.dat", "unauthorized/$author/$levelname.dat" );
		echo "Saved file, marked as 'unauthorized'.\n";
		echo "Password:" . md5(rand()) . "\n";
	}
?>
