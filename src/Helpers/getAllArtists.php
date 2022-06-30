<?php

namespace App\Helpers;

class GetArtists {

  public function index () { 
    $url = "https://www.moat.ai/api/task/";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = array(
      "Basic: ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ==",
      "Content-Type: application/json"
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = json_decode(curl_exec($curl));
    curl_close($curl);
    
    $items = [];
    foreach($response as $item) {
      $items[$item[0]->name] = $item[0]->id;
    }

    return $items;
  }
}
