<?php
require_once 'HTTP/Request2.php';

//adding a person contetn not image

$request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/largepersongroups/test2/persons');
$url = $request->getUrl();

$headers = array(
    // Request headers
    'Content-Type' => 'application/json',
    'Ocp-Apim-Subscription-Key' => '09c1eaffda7c4418b1782bfb28f28b12',
);

$request->setHeader($headers);

$parameters = array(
    // Request parameters
);

$url->setQueryVariables($parameters);

$request->setMethod(HTTP_Request2::METHOD_POST);

// Request body
$request->setBody(json_encode(array("name"=>"test")));//use post var instead will be better

try
{
    $response = $request->send();
    $id = $response->getBody();
    $idU = (json_decode($id,true));
    $temp_id = $idU['personId'];
    echo $temp_id;
}
catch (HttpException $ex)
{
    echo $ex;
}
//24115bdc-2858-4dfd-9133-cd8e93a32baf ronaldo
//a3aaefa8-6d78-4749-a8c0-5968310bbd26 casemiro
?>