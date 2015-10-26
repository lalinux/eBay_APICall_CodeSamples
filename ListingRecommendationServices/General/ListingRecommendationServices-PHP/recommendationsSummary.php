<?php

error_reporting(E_ALL);  // Turn on all errors, warnings and notices for easier debugging

//Seller Authorization Token
$userAuthToken= 'Authorization:TOKEN AgAAAA**AQAAAA**aAAAAA**h4U+VQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFkYClDpOFogidj6x9nY+seQ**DAsAAA**AAMAAA**1n0K+TNjYPBF8ub+5yP8SCrdsAu/gLD3Av0k4QL0M9p+3PSyBvhH4I/Rh8Ak6myxkStmgeefyeYMletFPBqakSzjPkAxN09muQmkIoxObI4NGd7uTU7+rt/y/jBztIS6IK0xfsLuV5oBEomj5z2QYBYpp/Rmi/+7Fv7n8aP9wjHCtctB6VH3tecY4rpIRU6OFKk5qvwa1kBrtP8CBXkg8EKT47cHk7naYODkGuQZPWbtibSqnRG5zoEKFIKN0Sx0VVcAlmlFJCsGzr3nlZ1XM3xVtkBhbgAHmjFQhGur0bRnPnMwxGz4CYdMV9sz216J5vlGdmbW+ziYUJG7bAJncm3/BZDzI6QBirsk7k3SUgydtECAaF1gj+A8Y0tz9eCCxbqCvTovjE/jEZw6KT4FBpDCSSUkEs0EEVi+Z0JIsvU6hXB0JKHPIquYaE+oNylji56k+0GwWj1zYjSu1v4HfbvD0CPyvS7ssmsVOzBWl6eyII+KDPBlv45T46vHXUMgdpyyK8raIseFmmgrd7sfsS/L5LbJs3bS3VIR560qUJGMEbd/h43Uj7/3TDAbFpCcEDavDFrhjmmtxZq+fSdsD6b9xzBV4ZoA6UyMXHWvmHk6mcUxMj+Mei+Dmdl51ucMndaig5JLq1RrD3JoYWhFNVgmZRsGVNy8SXef+rGgniatx+qoneUCNIevHxF9HEWvIO0CsWsrjgjjoqAOoDx/kJnt5L6Joprg/mwYbyCEZrWRIa90vaBZq2zGqcANfnii';

//Endpoint URL to Use
$url = "https://svcs.ebay.com/services/selling/listingrecommendation/v1/item/recommendationsSummary";

//Initializle cURL
$connection = curl_init();

//Set Endpoint URL
curl_setopt($connection,CURLOPT_URL,$url);

//Set HTTP Method
curl_setopt($connection, CURLOPT_HTTPGET, true);

//Create Array Of Required Headers
$headers = array();
$headers[] = $userAuthToken;
$headers[] = 'X-EBAY-GLOBAL-ID:EBAY-US';

//set the headers using the array of headers
curl_setopt($connection,CURLOPT_HTTPHEADER,$headers);

//set it to return the transfer as a string from curl_exec
curl_setopt($connection,CURLOPT_RETURNTRANSFER,1);

//stop CURL from verifying the peer's certificate
curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);

//Execute the Request
$response = curl_exec($connection);

//Close the Connection
curl_close($connection);

//Check If Response is OK
if (stristr($response, 'HTTP 404') || $response == '')
	die('<P>Error sending request, Please check the Request, Please check the user Token');


$data=json_decode($response,true);
if ($data === NULL) die('Error parsing json');

?>
<!-- Print The Version In Table Format -->
<table border='1px'>
<?php

	foreach ($data["recommendationsSummary"] as $arrayRow){
	
		echo '<tr><th style="background-color:#E6E6FA; border-radius:20px">Recommendation_Summary</th></tr>';


		echo '<tr><td> <b>'.$arrayRow['siteId'].'</b></td></tr>';
	
	//Check If Recommendation Array is Available, It is only returned if there are Recommendations and Live Item's available
 	if(isset($arrayRow["recommendation"])){
	foreach ($arrayRow["recommendation"] as $arrayRow1){
			
		echo '<tr><th style="background-color:#E6E6FA; border-radius:20px">Recommendation</th></tr>';
		

	foreach($arrayRow1 as $arrayColKey1 => $arrayColValue1){

		echo '<tr><td> <b>'.$arrayColKey1.'</b> => '. $arrayColValue1 . '</td></tr>';

	}
		}

	echo '</tr>';
}
else
{echo "Seller Does not Have Any Live Items To Check For Recommendations";}
}
echo '</table>';
?>




