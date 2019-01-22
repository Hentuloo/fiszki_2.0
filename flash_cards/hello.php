<?php

	session_start();
    unset($_SESSION['active_user']);
	if ((!isset($_SESSION['hello'])))
	{
		header('Location: index.php');
		exit();
	}
else{
    unset($_SESSION['hello']);
}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Fiszki - twoja nauka słówek!</title>
</head>

<body>
	Dziękujemy za rejestrację w serwisie! W ramach prezętu dostajesz od nas 3 tabele do wykorzystania na własne słówka!<br> Możesz już zalogować się na konto!<br>
	<a href="index.php">Zaloguj się na swoje konto!</a>


</body>
</html>