<html>
<head>
<title>Authorized levels:</title>
</head>
<body>
<form name="AuthozizationForm" action="authorize.php" method="GET">

<?php

/*var_dump($_GET);
echo "<br>";*/

if( isset($_GET['submit']) )
{
	$pw = file_get_contents( "secret_password" );
	$submittedPW = $_GET['pwd'];
	$pw = preg_replace('/[^A-Za-z0-9\- ]/', '', $pw); // Removes special chars.
	$result = strcmp($pw, $submittedPW);

	if( isset($submittedPW) && $submittedPW == $pw )
	{
		echo "Password accepted.<br>";

		foreach( $_GET as $key => $value )
		{
			if ($value == "authorize")
			{
				echo "Attempting to authorize: $key<br>";
				// extract author and levelname:
				$array = explode( "/", $key );
				$author = $array[0];
				$levelname = $array[1];

				// authorize the file:	
				if( isset($author) && isset($levelname) )
				{
					if( file_exists( "unauthorized/$author/$levelname.dat") )
					{
						// recursively create directory
						if(!is_dir("authorized/$author")) mkdir("authorized/$author", 0777, true);
	
						rename( "unauthorized/$author/$levelname.dat", "authorized/$author/$levelname.dat" );
						echo "unauthoried/$author/$levelname.dat -> authorized/$author/$levelname.dat<br>";
						echo "\tAuthorized $key <br";
					} else {
						echo "File unauthorized/$author/$levelname.dat not found!<br>";
					}
				}
			}
		}
	} else {
		echo "Error: Wrong password!<br>";
	}
	echo "<hr>";
}
?>
<br>
Choose Levels to authorize:<br>
<?php
$userlist = scandir ( "unauthorized" );
foreach ($userlist as $userdir)
{
	if ($userdir != "." && $userdir != "..")
	{
		$filelist = scandir ( "unauthorized/$userdir" );
		foreach ($filelist as $file)
		{
			if (preg_match ( "/\.dat$/" , $file) )
			{
				$file = str_replace( ".dat", "", $file );
				$entry = "$userdir/$file";
				echo "<input type=\"checkbox\" name=\"$entry\" value=\"authorize\"> $entry<br>";
			}
		}
	}
}
?>
<br>
Password: <input type="password" name="pwd">
<input type="submit" name="submit" value="Submit"><br>
</form>
</body>
</html>
