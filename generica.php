<?php
function generica($text) {

	if($text=="/messaggio" || $text=="/limite_breve" || $text=="/limite_medio" || $text=="/limite_lungo") {
		$url = "https://api.fattureincloud.it/v1/richiesta/info";
		$request = array("api_uid" => "295254", "api_key" => "58a05f9b8bd43c554f97a3731a1ddb6e");
		$options = array(
		"http" => array(
		"header"  => "Content-type: text/json\r\n",
		"method"  => "POST",
		"content" => json_encode($request)
		),
		);
		$context  = stream_context_create($options);
		$result = json_decode(file_get_contents($url, false, $context), true);
		
if($text=="/messaggio")
{
	$responsef = $result["messaggio"];
}
elseif($text=="/limite_breve")
{
	$responsef = $result["limite_breve"];
}
elseif($text=="/limite_medio")
{
	$responsef = $result["limite_medio"];
}
elseif($text=="/limite_lungo")
{
	$responsef = $result["limite_lungo"];
}
	
}
else
{
	$responsef = "Interrogazione non eseguita. Richiesta errata!";
}
	return $responsef;
}
