<?php
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
      $chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
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
      $text($result["messaggio"]);
// mi preparo a restitutire al chiamante la mia risposta che è un oggetto JSON
// imposto l'header della risposta     
header("Content-Type: application/json");
// la mia risposta è un array JSON composto da chat_id, text, method
// chat_id mi consente di rispondere allo specifico utente che ha scritto al bot
// text è il testo della risposta
$parameters = array('chat_id' => $chatId, "text" => $text);
// method è il metodo per l'invio di un messaggio (cfr. API di Telegram)
$parameters["method"] = "sendMessage";
// converto e stampo l'array JSON sulla response
echo json_encode($parameters);
