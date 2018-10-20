<?php
// This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
require_once 'HTTP/Request2.php';

$request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/facelists/test1');
$url = $request->getUrl();

$headers = array(
    // Request headers
    'Ocp-Apim-Subscription-Key' => '09c1eaffda7c4418b1782bfb28f28b12',
);

$request->setHeader($headers);

$parameters = array(
    // Request parameters
);

$url->setQueryVariables($parameters);

$request->setMethod(HTTP_Request2::METHOD_GET);

// Request body
$request->setBody(json_encode(array("faceListId"=>"test1")));

try
{
    $response = $request->send();
    $face = $response->getBody();
    $faces = (json_decode($face,true));
    for($i=0;$i<sizeof($faces['persistedFaces']);$i++) {
        echo( $faces['persistedFaces'][$i]['persistedFaceId'] );
        echo " ";
    }

}
catch (HttpException $ex)
{
    echo $ex;
}

?>