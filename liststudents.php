<?php

require_once 'HTTP/Request2.php';

if(isset($_POST['submit'])){

$BatchName = $_POST['batch'];

$request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/largepersongroups/'.$BatchName.'/persons');
$url = $request->getUrl();

$headers = array(
    // Request headers
    'Ocp-Apim-Subscription-Key' => 'a6f0b0ef9dda422e9703659b8b230726',
);

$request->setHeader($headers);

$parameters = array(
    // Request parameters
   /* 'start' => '{string}',
    'top' => '1000',*/
);

$url->setQueryVariables($parameters);

$request->setMethod(HTTP_Request2::METHOD_GET);

// Request body
$request->setBody(json_encode($parameters));

try
{
    $response = $request->send();
    $result = $response->getBody();
    echo $result;
    $all_students = (json_decode($result,true));
    for($i=0;$i<sizeof($all_students);$i++) {
            echo $all_students[$i]['name']; 
            //echo $data_from_base[$findFace[$i]['candidates'][0]['personId']];
            //echo $findFace[$i]['candidates'][0]['personId'];
            //echo "\t";
    }
}
catch (HttpException $ex)
{
    echo $ex;
}

$request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/largepersongroups/'.$BatchName.'/train');
$url = $request->getUrl();

$headers = array(
    // Request headers
    'Ocp-Apim-Subscription-Key' => 'a6f0b0ef9dda422e9703659b8b230726',
);

$request->setHeader($headers);

$parameters = array(
    // Request parameters
);

$url->setQueryVariables($parameters);

$request->setMethod(HTTP_Request2::METHOD_POST);

// Request body
$request->setBody(json_encode($parameters));

try
{
    $response = $request->send();
    //echo $response->getBody();
}
catch (HttpException $ex)
{
    echo $ex;
}
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
body{background: #2C3E50;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #4CA1AF, #2C3E50);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #4CA1AF, #2C3E50); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}
.form
     {
    width:340px;
	height:270px;
	background:#e6e6e6; 
	border-radius:8px;
	box-shadow:0 0 40px -10px #000;
	margin:calc(50vh - 220px) auto;
	padding:20px 30px;
	max-width:calc(100vw - 40px);
	box-sizing:border-box;
	font-family:'Montserrat',sans-serif;
	position:relative
	}
h2
{
  margin:10px 0;
  padding-bottom:10px;
  width:180px;
  color:#78788c;
  border-bottom:3px solid #78788c
  }
input
{
 width:100%;
 padding:10px;
 box-sizing:border-box;
 background:none;
 outline:none;
 resize:none;
 border:0;
 font-family:'Montserrat',sans-serif;transition:all .3s;
 border-bottom:2px solid #bebed2
 }
input:focus{border-bottom:2px solid #78788c}
p:before{content:attr(type);
 display:block;margin:28px 0 0;
 font-size:14px;color:#5a5a5a}
 button{float:right;padding:8px 12px;margin:8px 0 0;
 font-family:'Montserrat',sans-serif;
 border:2px solid #78788c;
 background:0;
 color:#5a5a6e;
 cursor:pointer;
 transition:all .3s
 }
button:hover{background:#78788c;color:#fff}
div{content:'Hi';
 position:absolute;
 bottom:-15px;right:-20px;background:#50505a;
 color:#fff;
 width:320px;
 padding:16px 4px 16px 0;
 border-radius:6px;
 font-size:13px;
 box-shadow:10px 10px 40px -14px #000
 }
span{margin:0 5px 0 15px}
</style>
</head>
<body>
<form class="form" action="liststudents.php" method="POST">
  <h2>STUDENT REGISTRATION</h2>
  <p type="Enrollment No:"><input placeholder="Write your name here.." name="batch"/></p>
  <button type="submit" name="submit">Submit</button>
</form>
</body>
</html>