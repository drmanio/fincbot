<?php
function acquisti($text) {
	if($text=="/acquisti") {
		$url = "https://api.fattureincloud.it/v1/acquisti/lista";
		$request = array("api_uid" => "295254", "api_key" => "58a05f9b8bd43c554f97a3731a1ddb6e", "anno" => 2018);
		$options = array(
		"http" => array(
		"header"  => "Content-type: text/json\r\n",
		"method"  => "POST",
		"content" => json_encode($request)
		),
		);
		$context  = stream_context_create($options);
		$result = json_decode(file_get_contents($url, false, $context), true);
		
		if($text=="/acquisti") {
			$responsef = $result(["lista_documenti"]["nome"]);
		}
	
	}
	else {
		$responsef = "Interrogazione non eseguita. Richiesta errata!";
	}
	return $responsef;
}