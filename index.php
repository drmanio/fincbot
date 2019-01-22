<?php
      $url = "https://api.fattureincloud.it/v1/acquisti/lista";
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
      $text = $result["messaggio"];
      print_r ($text);
?>
