
<html>
<head>
	<title>Github update script</title>
</head>
<body>
Updated
	<?php
		//chdir(dirname(__FILE__));
		$result = shell_exec("git pull");
		//$result = shell_exec("whoami");
		echo "<pre>$result</pre>" ;
	?>
</body>
</html>
