<?php

if( !isset($_GET["level"]) )
{
	echo "Error: no level name\n";
	return;
}
if( !isset($_GET["author"]) )
{
	echo "Error: no author\n";
	return;
}
if( !isset($_GET["fun"]) )
{
	echo "Error: no fun rating\n";
	return;
}
if( !isset($_GET["difficulty"]) )
{
	echo "Error: no difficulty rating\n";
	return;
}

$levelname = $_GET["level"];
$author = $_GET["author"];
$fun = intval($_GET["fun"]);
$difficulty = intval($_GET["difficulty"]);

if (!preg_match("#^[a-zA-Z0-9\-]+$#", $levelname)) {
	echo "Error: invalid characters in levelname\n";
	return;
}
if (!preg_match("#^[a-zA-Z0-9\-]+$#", $author)) {
	echo "Error: invalid characters in author\n";
	return;
}
if($fun < 1 || $fun > 5)
{
	echo "Error: invalid values for fun rating\n";
	return;
}
if($difficulty < 1 || $difficulty > 5)
{
	echo "Error: invalid values for difficulty rating\n";
	return;
}

$found = false;

$levelMetadataFile = "metadata/$author/$levelname.dat";
$data = file_get_contents($levelMetadataFile);
$array = explode ( "\t", $data );

// Data in the metadate files is stored as:
// author levelname number_of_raters ratingFun ratingDifficulty
$raters = $array[2];
$oldRatingFun = $array[3];
$oldRatingDifficulty = $array[4];
// Add and build average:
$newRatingFun = ($fun + $raters*$oldRatingFun)/($raters+1);
$newRatingDifficulty = ($difficulty + $raters*$oldRatingDifficulty)/($raters+1);

$raters = $raters + 1;

file_put_contents($levelMetadataFile, "$array[0]\t$array[1]\t$raters\t$newRatingFun\t$newRatingDifficulty\n", LOCK_EX );

echo "Sucessfully set ratings:\n\tfun: $fun\n\tdifficulty: $difficulty\n\tfor level: $author/$levelname\n";
echo "New: $newRatingFun $newRatingDifficulty";

