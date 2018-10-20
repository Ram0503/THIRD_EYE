<?php
require_once 'HTTP/Request2.php';
//adding face of person after getting personid
$request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/largepersongroups/test2/persons/a3aaefa8-6d78-4749-a8c0-5968310bbd26/persistedfaces');
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
$request->setBody(json_encode(array("url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/20180610_FIFA_Friendly_Match_Austria_vs._Brazil_Casemiro_850_1575.jpg/1200px-20180610_FIFA_Friendly_Match_Austria_vs._Brazil_Casemiro_850_1575.jpg")));
//use var
try
{
    $response = $request->send();
    $face_id = $response->getBody();
    $face_id = (json_decode($face_id,true));
    $face_id = $face_id['persistedFaceId'];
    echo $face_id;
}
catch (HttpException $ex)
{
    echo $ex;
}
// {"persistedFaceId":"5f55ff09-2250-4661-babc-c506d0127e8a"} ronaldo
// {"persistedFaceId":"b0207669-2775-4590-ab2b-2ab4d7fda7f1"} casemiro
?>