<?php
      $url = "https://api.fattureincloud.it/v1/acquisti/lista";
      $request = array("api_uid" => "295254", "api_key" => "58a05f9b8bd43c554f97a3731a1ddb6e", "anno"=> 2018);
      $options = array(
          "http" => array(
              "header"  => "Content-type: text/json\r\n",
              "method"  => "POST",
              "content" => json_encode($request)
          ),
      );
      $context  = stream_context_create($options);
      $result2018 = json_decode(file_get_contents($url, false, $context), true);
      
      $url = "https://api.fattureincloud.it/v1/acquisti/lista";
      $request = array("api_uid" => "295254", "api_key" => "58a05f9b8bd43c554f97a3731a1ddb6e", "anno"=> 2019);
      $options = array(
          "http" => array(
              "header"  => "Content-type: text/json\r\n",
              "method"  => "POST",
              "content" => json_encode($request)
          ),
      );
      $context  = stream_context_create($options);
      $result2019 = json_decode(file_get_contents($url, false, $context), true);

      $result = array();
      $result[] = $result2018[lista_documenti];
      $result[] = $result2019[lista_documenti];

      print_r($result);
?>
