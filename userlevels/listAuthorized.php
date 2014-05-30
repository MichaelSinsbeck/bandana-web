<?php

// get list of all folders:
$userlist = scandir ( "authorized" );

$startID = 0;
$endID = 100000;
$currentID = 0;

foreach ($userlist as $userdir)
{
	if ($userdir != "." && $userdir != "..")
	{
		$filelist = scandir ( "authorized/$userdir" );
		foreach ($filelist as $file)
		{
			if (preg_match ( "/\.dat$/" , $file) )
			{
				if ($currentID >= $startID )
				{
					echo "$userdir\t$file\n";
				}
				$currentID = $currentID + 1;
				if ($currentID > $endID) break;
			}
		}
	}
	if ($currentID > $endID) break;
}
?>
