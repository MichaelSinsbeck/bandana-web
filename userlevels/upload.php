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

if (!preg_match("#^[a-zA-Z0-9\-]+$#", $levelname)) {
	echo "Error: invalid characters in levelname\n";
	return;
}
if (!preg_match("#^[a-zA-Z0-9\-]+$#", $author)) {
	echo "Error: invalid characters in author\n";
	return;
}

$pos = strpos( $DATA, "BANDANA LEVEL");
if( pos )
{
	$levelcontent = substr( $DATA, $pos );
}

if( isset($levelname) && isset($author) && isset($levelcontent) )
{
	echo "Received level '$levelname' by '$author'.\n";
} else {
	echo "Error: Invalid data: missing level name, author or content!\n";
	return;
}

// check if a file by this user already exists:
if( file_exists( "unauthorized/$author/$levelname.dat" ) || file_exists("authorized/$author/$levelname.dat" ) )
{
	echo "Error: Level already exists!\n";
	return;
}

$result = mkdir( "tmplevels/$author", 0775, true );
$result = file_put_contents( "tmplevels/$author/$levelname.dat", $levelcontent );

// Execute the lua level verification file. pass the current level as input.
$output = shell_exec( "lua levelVerification.lua tmplevels/$author/$levelname.dat 2>&1" );

// check if there were errors (ugly, but command line lua does not seem to give back useful error codes...?):
if( stripos($output, "Error:") )
{
	unlink( "tmplevels/$author/$levelname.dat" );	// there was an error, so remove the file.

	echo( substr($output, stripos($output, "Error:")));
	echo "Error in level file.\n";
	echo "Removed temporary file.\n";
} else {
	$result = mkdir( "unauthorized/$author", 0775, true );

	//echo "Mkdir: $result\n";
	$result = rename( "tmplevels/$author/$levelname.dat", "unauthorized/$author/$levelname.dat" );
	echo "Saved file, marked as 'unauthorized'.\n";

	echo "Password:" . md5(rand()) . "\n";

	// add level file to level list:
	$levelMetadataFile = "metadata/$author/$levelname.dat";
	// Add default rating (3, 3). The 0 means there has been no users who rated the level so far.
	if(!is_dir("metadata/$author")) mkdir("metadata/$author", 0777, true);
	file_put_contents($levelMetadataFile, "$author\t$levelname\t0\t3\t3\n", LOCK_EX );
}
?>
