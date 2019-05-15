<?php 
session_start();

$token = substr(uniqid(), 1, 12);
var_dump($token);

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
if (isset($_SESSION["mail"]) && $_SESSION["mail"] == "ok") {
	echo envoiMail(  "Test Dylan",
            		["tavares.dylan03@gmail.com"],
            		["html" => "", "text"=> "Ceci est un test votre token est : ".$token]
          		 	);
	echo 'Votre surprise est envoyé !!!';
	fopen($token, 'w');
	unset($_SESSION["mail"]);
					
}else{
	$_SESSION["mail"] = "ok";
	echo 'Rafaîchir la page pour votre surprise';
}
	
	

?>