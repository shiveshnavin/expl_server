<?php

	/**
	* Make sure you started your'e sessions!
	* You need to include su.inc.php to make SimpleUsers Work
	* After that, create an instance of SimpleUsers and your'e all set!
	*/
error_reporting(0);

	session_start();
	unset($_SESSION['username']);
unset($_SESSION['password']);

	require_once(dirname(__FILE__)."/api/api.php");


	if( isset($_GET["user"]) )
	{
		$_POST["username"]=$_GET["user"];
	}
 

	if( isset($_GET["password"]) )
	{
		$_POST["password"]=$_GET["password"];
	}
  
 if($_POST["username"]=="admin"&&$_POST["password"]=="CMS@1977"){ 

 	
$_SESSION['username'] = $_POST["username"];
$_SESSION['password'] = $_POST["password"];

 
		header("Location: index.php");
		}
  

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
	  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	  <style type="text/css">

			* {	margin: 0px; padding: 0px; }
			body
			{
				padding: 30px;
				font-family: Calibri, Verdana, "Sans Serif";
				font-size: 12px;
			}
			table
			{
				width: 800px;
				margin: 0px auto;
			}

			th, td
			{
				padding: 3px;
			}

			.right
			{
				text-align: right;
			}

	  	h1
	  	{
	  		color: #FF0000;
	  		border-bottom: 2px solid #000000;
	  		margin-bottom: 15px;
	  	}

	  	p { margin: 10px 0px; }
	  	p.faded { color: #A0A0A0; }

	  </style>
	</head>
	<body>

		<h1>Login</h1>

		<?php if( isset($error) ): ?>
		<p>
			<?php echo $error; ?>
		</p>
		<?php endif; ?>


<form> 
</form>




		<form method="post" action="">
			<p>
				<label for="username">Username:</label><br />
				<input type="text" name="username" id="username" />
			</p>

			<p>
				<label for="password">Password:</label><br />
				<input type="text" name="password" id="password" />
			</p>

			<p>
				<input type="submit" name="submit" value="Login" />
			</p>

		</form>

	</body>
</html>