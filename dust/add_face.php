<?php
// This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
require_once 'HTTP/Request2.php';

$request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/facelists/test1/persistedFaces');
$url = $request->getUrl();

$headers = array(
    // Request headers
    'Content-Type' => 'application/json',
    'Ocp-Apim-Subscription-Key' => '09c1eaffda7c4418b1782bfb28f28b12',
);

$request->setHeader($headers);

$parameters = array(
    // Request parameters
    'userData' => '',
    'targetFace' => '',
);

$url->setQueryVariables($parameters);

$request->setMethod(HTTP_Request2::METHOD_POST);

// Request body
$request->setBody(json_encode(array("url"=>"https://images.performgroup.com/di/library/GOAL/47/46/cristiano-ronaldo-real-madrid_1owg123m78bl16jripie1ghkl.jpg?t=-1780920495&quality=90&w=1280")));

try
{
    $response = $request->send();
    echo $response->getBody();
}
catch (HttpException $ex)
{
    echo $ex;
}

?>