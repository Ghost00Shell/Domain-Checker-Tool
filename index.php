<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DOMAIN TOOL</title>
<meta charset="UTF-8">
<meta name="viewport" content="width:device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@900&display=swap" rel="stylesheet">

<style>
    *{
        font-weight: 500;
    }
.bg-font{
    font-family: 'Titillium Web', sans-serif;
}
</style>
</head>
    <body>

<header>
<nav class="navbar navbar-expand-sm navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand bg-font" href="javascript:void(0)">DomainTool</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
       
      </ul>
      <form class="d-flex" action="<?php htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input class="form-control me-2" type="search" placeholder="Enter Domain.." name="domain" aria-label="Search">
        <button class="btn btn-outline-success bg-font" type="submit">Check</button>
      </form>
    </div>
  </div>
</nav>
</header>


    <div class="mt-4 p-5 bg-primary text-white rounded bg-font">
<h2>Domain Checker Tool</h2>
</div><br>




<div class="col container">
<form action="<?php htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" class="">
<div class="mb-3">
<label name="domain" class="form-label">Enter Domain Name:</label>
<input type="text" placeholder="Enter Domain Name" name="domain" class="form-control"/>
<small><i>Required Format: "www.example.com" or "example.com".</i></small>
</div>
<input type="submit" class="btn btn-primary bg-font" value="SEARCH DOMAIN">
</form>
</div>




<?php

//CHECK IF REQUEST METHOD IS POST AND DOMAIN INPUT IS NOT VALID
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["domain"]) && is_string($_POST["domain"])){
 require ("API.php");
    //USER INPUT DOMAIN
$domain = filter_var($_POST["domain"], FILTER_SANITIZE_URL);
if(preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i', $domain)){
    echo '<br/><div class=" container alert alert-danger">
    Correct The Domain Input (Recommended Format: website.com)</div>';
    return;
  }




//URL FROM THE OUTLET (Replace The Url If Outlet is Different From api.whoapi.com)
$url = "http://api.whoapi.com/?apikey=".API_KEY."&r=whois&domain=".$domain."&ip=";
 
//INITIALIZING...
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $url);

//GETTING API RESULT DATA (JSON)
$result = json_decode(curl_exec($curl), true);

curl_close($curl);


//CHECK IF DOMAIN IS REGISTERED
$d_status1 = $result["registered"];

if(true == $d_status1){
$d_status = "Registered";
}else{
   $d_status = "Not Registered"; 
}


//MAIN OUTPUT

echo'
<div class="container p-5 my-5 border">
<h3>Overview Of '.$domain.'</h3>
</div>



<div class="container p-5 my-5 border">
<div class="container">
<h4>Domain Status: <div class="btn btn-success">'.$d_status.'</div></h4>
</div><br/>

<div class="container">
<h4>Whois Server: <div class="btn btn-success">'.$result["whois_server"].'</div></h4>
</div><br/>

<div class="container">
<h4>Date Registered: <div class="btn btn-success">'.$result["date_created"].'</div></h4>
</div><br/>

<div class="container">
<h4>Expiring Date: <div class="btn btn-success">'.$result["date_expires"].'</div></h4>
</div><br/>

<div class="container">
<h4>Date Updated: <div class="btn btn-success">'.$result["date_updated"].'</div></h4>
</div><br/>

<div class="container">
<h4>Date Updated: <div class="btn btn-success">'.$result["date_updated"].'</div></h4>
</div><br/>

<div class="container">
<h4>Nameservers: <div class="btn btn-success">'.$result["nameservers"][0].'</div> <div class="btn btn-danger">'.$result["nameservers"][1].'</div></h4>
</div><br/>


<div class="container">
<h4>Registrar: <div class="btn btn-success">'.$result["contacts"][0]["organization"].'</div></h4>
</div><br/>

<div class="container">
<h4>Country: <div class="btn btn-success">'.$result["contacts"][1]["country"].'</div></h4>
</div><br/>

<div class="container">
<h4>Email: <div class="btn btn-success">'.$result["contacts"][1]["email"].'</div></h4>
</div>
</div>
<br/>
';


}

?>

<div class="p-5 my-5 bg-light border" style="width:100%;color:white;">

</div>

<center>Domain Checker By Vincent @wildfoster</center><br/>
</body>
</html>
