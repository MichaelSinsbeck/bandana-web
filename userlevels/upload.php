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

	echo shell_exec("lua levelVerification.lua tmplevels/$author/$levelname.dat 2>&1") . "\n";
?>
