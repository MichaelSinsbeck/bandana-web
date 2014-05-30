<?php

// get list of all folders:
$list = scandir ( string "unauthorized" );

foreach ($list as $dir)
{
	echo "$dir\n";
}
?>
