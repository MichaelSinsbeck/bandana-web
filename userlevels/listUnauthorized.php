<?php

// get list of all folders:
$userlist = scandir ( "unauthorized" );

foreach ($userlist as $userdir)
{
	if ($userdir != "." && $userdir != "..")
	{
		echo "$userdir\n";
		$filelist = scandir ( "unauthorized/$userdir" );
		foreach ($filelist as $file)
		{
			echo "\t$file\n";
		}
	}
}
?>
