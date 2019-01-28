<?php
// includo il file con lo script per fare l'interrogazione generica a Fatture in Cloud
include "acquisti.php";
include "generica.php";
// recupero il contenuto inviato da Telegram
$content = file_get_contents("php://input");
// converto il contenuto da JSON ad array PHP
$update = json_decode($content, true);
// se la richiesta è null interrompo lo script
if(!$update)
{
  exit;
}
// assegno alle seguenti variabili il contenuto ricevuto da Telegram
$message = isset($update['message']) ? $update['message'] : "";
//$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
//$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
//$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
//$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
//$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";

if(($text=="/acquisti") || ($text=="/acquisti consorzio") || ($text=="/acquisti gaion") || ($text=="/acquisti bonifico")) {
	
	$resp = acquisti($text);
	$conta_anno = count($resp);
	$lista = array();
	
	for ($j=0; $j<$conta_anno; $j++) {
		
		$contaresp = count($resp[$j][lista_documenti]);
		for ($i=0; $i<$contaresp; $i++) {
			if ($text=="/acquisti") {
				if ($resp[$j][lista_documenti][$i][prossima_scadenza]!="00/00/0000") {
					$lista[] = "Scadenza: "
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],6,4). "-"
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],3,2). "-"
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],0,2)
						." - " . $resp[$j][lista_documenti][$i][nome] . " : € " 
						. number_format($resp[$j][lista_documenti][$i][importo_totale],2,",",".");
				}
			}
			if ($text=="/acquisti consorzio") {
				if (($resp[$j][lista_documenti][$i][prossima_scadenza]!="00/00/0000") && ($resp[$j][lista_documenti][$i][id_fornitore]=="6")) {
					$lista[] = "Scadenza: "
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],6,4). "-"
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],3,2). "-"
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],0,2)
						." - " . $resp[$j][lista_documenti][$i][nome] . " : € " 
						. number_format($resp[$j][lista_documenti][$i][importo_totale],2,",",".");
				}
			}
			if ($text=="/acquisti gaion") {
				if (($resp[$j][lista_documenti][$i][prossima_scadenza]!="00/00/0000") && ($resp[$j][lista_documenti][$i][id_fornitore]=="12")) {
					$lista[] = "Scadenza: "
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],6,4). "-"
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],3,2). "-"
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],0,2)
						." - " . $resp[$j][lista_documenti][$i][nome] . " : € " 
						. number_format($resp[$j][lista_documenti][$i][importo_totale],2,",",".");
				}
			}
			if ($text=="/acquisti bonifico") {
				if (($resp[$j][lista_documenti][$i][prossima_scadenza]!="00/00/0000") && ($resp[$j][lista_documenti][$i][id_fornitore]!="6") && ($resp[$j][lista_documenti][$i][id_fornitore]!="12")) {
					$lista[] = "Scadenza: "
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],6,4). "-"
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],3,2). "-"
						. substr($resp[$j][lista_documenti][$i][prossima_scadenza],0,2)
						." - " . $resp[$j][lista_documenti][$i][nome] . " : € " 
						. number_format($resp[$j][lista_documenti][$i][importo_totale],2,",",".");
				}
			}
		}
	}
	
	sort($lista);
	$response = implode ("\r\n", $lista);
	
}

else {
	$response = generica($text);
}

// mi preparo a restitutire al chiamante la mia risposta che è un oggetto JSON
// imposto l'header della risposta
header("Content-Type: application/json");
// la mia risposta è un array JSON composto da chat_id, text, method
// chat_id mi consente di rispondere allo specifico utente che ha scritto al bot
// text è il testo della risposta
$parameters = array('chat_id' => $chatId, "text" => $response);
// method è il metodo per l'invio di un messaggio (cfr. API di Telegram)
$parameters["method"] = "sendMessage";
// converto e stampo l'array JSON sulla response
echo json_encode($parameters);
