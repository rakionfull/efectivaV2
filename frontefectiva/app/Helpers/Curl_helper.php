<?php

 

function perform_http_request($method, $url, $data = false) {
   


    // $curl = curl_init();
           
    // switch ($method) {
    //     case "POST":
    //         curl_setopt($curl, CURLOPT_POST, 1);

    //         if ($data) {
    //             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	// 		}
			
    //         break;
    //     case "PUT":
    //         curl_setopt($curl, CURLOPT_PUT, 1);
			
    //         break;
    //     default:
    //         if ($data) {
    //             $url = sprintf("%s?%s", $url, http_build_query($data));
	// 		}
    // }

    // curl_setopt($curl, CURLOPT_URL, $url);
      
  
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //If SSL Certificate Not Available, for example, I am calling from http://localhost URL
    // // curl_setopt($curl, CURLOPT_HEADER, $headers);
  
    // $result = curl_exec($curl);
    // $info=curl_getinfo($curl);
    // curl_close($curl);
   
    // return json_decode($result) ;
    $client = \Config\Services::curlrequest();
    $session = \Config\Services::session();
    $token=null;
   if($session->token){
    $token=$session->token;
   }
    switch ($method) {
        case "POST":
            $datos = [
                'query'  => $data,
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept'     => 'application/json',
                    'Authorization'      => 'Bearer '.$token,
                ]
            ];
            //  var_dump($datos);
            $response = $client->request($method,$url,$datos );
			
            break;
        case "PUT":
            $datos = [
                'query' => $data,
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept'     => 'application/json',
                    'Authorization'      => 'Bearer '.$token,
                ]
            ];
            $response = $client->request($method,$url,$datos );
			
            break;
        case "GET":
            
            // var_dump("estoy en get");
            $response = $client->request($method,$url);
                
        break;
        default:
            if ($data) {
                $url = sprintf("%s?%s", $url, http_build_query($data));
			}
    }

   
        
    //  echo $response->getStatusCode();
     
    echo $response->getBody();
    //  echo $response->header('Content-Type');
    return json_decode($response->getBody());
}