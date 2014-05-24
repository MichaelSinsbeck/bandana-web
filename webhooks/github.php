
<html>
<head>
	<title>Github update script</title>
</head>
<body>
Updating...
	<?php
		//chdir(dirname(__FILE__));
		$result = shell_exec("/usr/bin/git pull 2>&1");
		//$result = shell_exec("whoami");
		echo "<pre>$result</pre>" ;
		//echo shell_exec("whoami");
	?>
</body>
</html>
