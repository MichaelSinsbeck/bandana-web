<?php
	$DATA = $HTTP_RAW_POST_DATA;

	if(preg_match( "/Name: ([^\n]+)/", $DATA, $results ))
	{
		$levelname = $results[1];
	}

	if(preg_match( "/Creator: ([^\n]+)/", $DATA, $results ))
	{
		$creator = $results[1];
	}

	$pos = strpos( $DATA, "BANDANA LEVEL");
	if( pos )
	{
		$levelcontent = substr( $DATA, $pos );
	}

	if( isset($levelname) && isset($creator) && isset($levelcontent))
	{
		echo "Received level '$levelname' by '$creator'.\n";
	} else {
		echo "Invalid data: missing level name, creator or content!\n";
	}
	$result = mkdir( "tmplevels/$creator", 0775, true );
	$result = file_put_contents( "tmplevels/$creator/$levelname.dat", $levelcontent );
?>
