<?php 
session_start();
$_SESSION["mail"] = $_POST["mail"];
$_SESSION["mailto"] = $_POST["mailto"];

var_dump($_POST["mail"]);

var_dump($_SESSION["mail"]);

var_dump($_POST["mailto"]);

var_dump($_SESSION["mailto"]);

function envoiMail($objet, $mailto, $msg, $cci = true)//:string
{
	require_once 'vendor/autoload.php';
	require_once 'config.php';
	if(!is_array($mailto)){
		$mailto = [ $mailto ];
	}
	// Create the Transport
	$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
	->setUsername($defaultmail)
	->setPassword($mailpwd);
	// Create the Mailer using your created Transport
	$mailer = new Swift_Mailer($transport);
	// Create a message
	$message = (new Swift_Message($objet))
		->setFrom([$defaultmail]);
	if ($cci){
		$message->setBcc($mailto);
	}else{
		$message->setto($mailto);
	}
	if(is_array($msg) && array_key_exists("html", $msg) && array_key_exists("text", $msg))
	{
		$message->setBody($msg["html"], 'text/html');
		// Add alternative parts with addPart()
		$message->addPart($msg["text"], 'text/plain');
	}else if(is_array($msg) && array_key_exists("html", $msg) ){
		$message->setBody($msg["html"], 'text/html');
		$message->addPart($msg["html"], 'text/plain');
	}else if(is_array($msg) && array_key_exists("text", $msg)){
		$message->setBody($msg["text"], 'text/plain');
	}else if(is_array($msg)){
		die('erreur une clé n\'est pas bonne'); 
	}else{
		$message->setBody($msg, 'text/plain');
	}
	
	// Send the message
	return $mailer->send($message);
}
if (isset($_SESSION["mail"]) && isset($_SESSION["mailto"])) {
	echo envoiMail(  "Test Dylan",
            		[$_POST["mailto"], $_POST["mailto"]],
            		["html" => "", "text"=> "Ceci est un test"]
          		 	);
}
	unset($_SESSION["mail"]);

?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Challenge exo swift mailer</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets/style/style.css">
</head>
<body>
	<form method="POST">

		<input type="mail" name="mail" placeholder="E-mail expediteur">

		<input type="mail" name="mailto" placeholder="E-mail destinataire">
		<button type="submit" name="sub">Confirmer</button>

	</form>
</body>
</html>