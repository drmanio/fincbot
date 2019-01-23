<?php
      
$result = array();
      
for($i = 2018; $i <= date("Y"); $i++) {
      
      $url = "https://api.fattureincloud.it/v1/acquisti/lista";
      $request = array("api_uid" => "295254", "api_key" => "58a05f9b8bd43c554f97a3731a1ddb6e", "anno"=> $i);
      $options = array(
            "http" => array(
                  "header"  => "Content-type: text/json\r\n",
                  "method"  => "POST",
                  "content" => json_encode($request)
                  ),
            );
      $context  = stream_context_create($options);
      $result[] = json_decode(file_get_contents($url, false, $context), true);
      
}

print_r($result);

?>
