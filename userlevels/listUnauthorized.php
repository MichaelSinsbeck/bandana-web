<?php

// get list of all folders:
$userlist = scandir ( "unauthorized" );

foreach ($userlist as $userdir)
{
	if ($userdir != "." && $userdir != "..")
	{
		echo "User: $userdir\n";
		$filelist = scandir ( "unauthorized/$userdir" );
		foreach ($filelist as $file)
		{
			if (preg_match ( ".dat" , $file) )
			{
				echo "\t$file\n";
			}
		}
	}
}
?>
