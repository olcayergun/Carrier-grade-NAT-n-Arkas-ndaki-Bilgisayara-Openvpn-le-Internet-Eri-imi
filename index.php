<?php 
$parameter = $_SERVER['QUERY_STRING'];

// Define the URL and data 
$url = 'http://10.0.0.180/led'; 
$data = ['state' => $parameter]; 

// Prepare POST data 
$options = [ 
	'http' => [ 
		'method' => 'POST', 
		'header' => 'Content-type: application/x-www-form-urlencoded', 
		'content' => http_build_query($data), 
	], 
]; 

// Create stream context 
$context = stream_context_create($options); 

// Perform POST request 
$response = file_get_contents($url, false, $context); 

// Display the response 
//echo $response; 
echo "<script>window.close();</script>";