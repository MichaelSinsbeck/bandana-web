<?php

// get list of all folders:
$userlist = scandir ( "unauthorized" );

$startID = 0;
$endID = 100000;
$currentID = 0;

foreach ($userlist as $userdir)
{
	if ($userdir != "." && $userdir != "..")
	{
		$filelist = scandir ( "unauthorized/$userdir" );
		foreach ($filelist as $file)
		{
			if (preg_match ( "/\.dat$/" , $file) )
			{
				if ($currentID >= $startID )
				{
					$metadata = file_get_contents("metadata/$userdir/$file");
					echo $metadata;
					//echo "$userdir\t$file\n";
				}
				$currentID = $currentID + 1;
				if ($currentID > $endID) break;
			}
		}
	}
	if ($currentID > $endID) break;
}
?>
