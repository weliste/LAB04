
<?php
//Start authentication for masterUser using appid, user and psw as message parameters
	$url = 'https://login.windows.net/common/oauth2/token';
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
	            "client_id=6d1f09f3-30d3-48ba-a2bc-276644eddf35&grant_type=password&username=reportes@gelcointernational.com&password=Row25050&resource=https://analysis.windows.net/powerbi/api");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));


	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);

	curl_close ($ch);
	$arreglo = json_decode($server_output, true);
	//get the connection token
	$token = $arreglo['access_token'];
	$embeddedToken = "Bearer "  . ' ' .  $token;
    if ($params == ""){
        $uri = "https://api.powerbi.com/v1.0/myorg/groups/".$group."/reports/".$reports;
    }
    else {
        $uri = "https://api.powerbi.com/v1.0/myorg/groups/".$group."/reports/".$reports."?rp:".$params;
    }
    //echo $uri;
	/* ---------------------- Sección 1 -----------------------------------*/
//begin the second stage of the process: bring the report through the embedUrl and then show it with the script
    $curlGetUrl = curl_init();
    curl_setopt_array($curlGetUrl, array(
        CURLOPT_URL => $uri,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: $embeddedToken",
            "Cache-Control: no-cache",
        ),
    ));
    $embedResponse = curl_exec($curlGetUrl);
    $embedError = curl_error($curlGetUrl);
    curl_close($curlGetUrl);
    // Obtengo el Dataset ID
    $arreglo1 = json_decode($embedResponse, true);
    $datasetID = $arreglo1['datasetId'];
    //echo "DatasetId: ", $datasetID." GroupID: ".$group." Token: ".$embeddedToken;

//Start of dataset refresh stage
    if ($update="1"){
        $actDs  = curl_init();
        curl_setopt($actDs, CURLOPT_URL,$url);
        curl_setopt($actDs, CURLOPT_POST, 1);
        curl_setopt($actDs, CURLOPT_URL,"https://api.powerbi.com/v1.0/myorg/groups/".$group."/datasets/".$datasetID."/refreshes");
        curl_setopt($actDs, CURLOPT_HTTPHEADER, array( "Authorization: $embeddedToken", "Cache-Control: no-cache",));
        curl_setopt($actDs, CURLOPT_RETURNTRANSFER, true);
        $respuesta1 = curl_exec ($actDs);
        curl_close ($actDs);  
    }
    //define embed Url to present with JS
    if ($embedError) {
        echo "cURL Error #:" . $embedError;
        } else {
            $embedResponse = json_decode($embedResponse, true);
            $embedUrl = $embedResponse['embedUrl']; 
        }
    
?>
