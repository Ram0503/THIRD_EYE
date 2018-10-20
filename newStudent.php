<?php

include 'init/init.php';
require_once 'HTTP/Request2.php';

if(isset($_POST['submit'])){

$StudentName = $_POST['StudentName'];
$BatchName = $_POST['BatchName'];
$temp_id = -1;
$urlOfPic = $_POST['url'];
$enrollmentNo = $_POST['enrollmentNo'];

//add student s1
$request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/largepersongroups/'.$BatchName.'/persons');
$url = $request->getUrl();

$headers = array(
    // Request headers
    'Content-Type' => 'application/json',
    'Ocp-Apim-Subscription-Key' => 'a6f0b0ef9dda422e9703659b8b230726',
);

$request->setHeader($headers);

$parameters = array(
    // Request parameters
);

$url->setQueryVariables($parameters);

$request->setMethod(HTTP_Request2::METHOD_POST);

// Request body
$request->setBody(json_encode(array("name"=>$StudentName)));//use post var instead will be better

try
{
    $response = $request->send();
    $id = $response->getBody();
    $idU = (json_decode($id,true));
    $temp_id = $idU['personId'];
}
catch (HttpException $ex)
{
    echo $ex;
}

$request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/largepersongroups/'.$BatchName.'/persons/'.$temp_id.'/persistedfaces');
$url = $request->getUrl();

$request->setHeader($headers);

$parameters = array(
    // Request parameters
);

$url->setQueryVariables($parameters);

$request->setMethod(HTTP_Request2::METHOD_POST);

// Request body
$request->setBody(json_encode(array("url" => $urlOfPic)));
//use var
try
{
    $response = $request->send();
    $face_id = $response->getBody();
    //echo $face_id;
    $face_id = (json_decode($face_id,true));
    $face_id = $face_id['persistedFaceId'];//save it to database with student name
    $sql = "INSERT INTO students (`username`,`enroll`,`persistedId`,`batch`) VALUES ('$StudentName', '$enrollmentNo', '$temp_id', '$BatchName')";

    if ($conn->query($sql) === TRUE) {
        echo '<script language="javascript"> alert("You are Added") </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();

    echo $face_id;
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
body{background: #2C3E50;
    background: -webkit-linear-gradient(to left, #4CA1AF, #2C3E50);
    background: linear-gradient(to left, #4CA1AF, #2C3E50);

}
.form
     {
        width: 340px;
        height: 580px;
        background: #e6e6e6;
        border-radius: 8px;
        box-shadow: 0 0 40px -10px #000;
        margin: auto;
        margin-top: 10%;
        padding: 20px 30px;
        max-width: calc(100vw - 40px);
        box-sizing: border-box;
        font-family: 'Montserrat',sans-serif;
        position: relative;
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
<form class="form" action="newStudent.php" method="POST">
  <h2>STUDENT REGISTRATION</h2>
  <p type="Student Name:"><input placeholder="Write your name here.." name="StudentName"/></p>
  <p type="Batch Name:"><input placeholder="Write your batch name here.." name="BatchName"/></p>
  <p type="Enrollment No:"><input placeholder="Write your enrollment no here.." name="enrollmentNo"/></p>
  <p type="Url:"><input placeholder="Write your url here.." name="url"/></p>
  <p style="color: red">UPLOAD your image and get URL from this <a target="_blank" href="https://iec2017029.000webhostapp.com/Upload.php">link</a></p>
  <button type="submit" name="submit">Submit</button>
</form>
</body>
</html>