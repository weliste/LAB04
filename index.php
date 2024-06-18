<?php
	//require_once("jsSerialApi.js");

function sendData(){
	
	echo "<button id='connectBtn' onclick='startSerialCommunication()'>Connect</button>";
    //echo "<button onclick='stopSerialCommunication()'>Disconnect</button>"
    echo "  <button id='sendBtn' onclick='sendData()' disabled='true'>Send</button>";
	

	$tipoMsg = "113";

	$tmp = "$tipoMsg~0008";
/*
	echo "<form name id='form1' method='post' action='/opt/web/php/accesso/awp/index.php/sessione/inviorichieste' enctype='application/x-www-form-urlencoded'>\n";
*/
	echo "<form name='form1' id='form1' method='post' action='index.php' enctype='application/x-www-form-urlencoded'>\n";
	// echo "<input type='hidden'  id='com' 		name='com' 		value='{$com}'>\n";
	// echo "<input type='hidden'  id='idEnte'		name='idEnte' 		value='{$_SESSION['AWP']['id_ente_old']}'>\n";
	// echo "<input type='hidden'  id='idVerifica'	name='idVerifica' 	value='{$_SESSION['AWP']['id_ver']}'>\n";
	// echo "<input type='hidden'  id='richiesta' 	name='richiesta' 	value={$ricCryptToCard}>\n";
	// echo "<input type='hidden'  id='risposta' 	name='risposta' 	value='prova'>\n";
	echo "<input type='hidden'  id='rispostaCom' 	name='rispostaCom' 	value='prova'>\n";
	echo "<input type='hidden'  id='messaggio' 	name='messaggio'	value='{$tmp}'>\n";
	// echo "<input type='hidden'  id='codeid' 	name='codeid' 		value='{$codeid}'>\n";   ///per passarlo quando ricarica la pag...... bah
	// echo "<input type='hidden'  id='tipoMsg'	name='tipoMsg' 		value={$tipoMsg}>\n";
	//echo "<script type='text/javascript'>\n";
	//echo "alert(',,,,,,,,,'+document.getElementById('rispostaCom').value);\n";
	//echo "sendData();\n";
	//echo "document.getElementById('form1').submit();\n";
	//echo "</script>\n";
    //echo "<input type='submit' value='submit'>\n";
	echo "</form >\n";

	echo "<script type='text/javascript'>\n";
	require_once("jsSerialApi.js");
	echo "</script>\n";

}


function hexToStr($hex){
	$string='';
	for ($i=0; $i < strlen($hex)-1; $i+=2){
		$string .= chr(hexdec($hex[$i].$hex[$i+1]));
	}
	return $string;
}


if($_POST){


    foreach  ($_POST  as $key => $value){
        //echo "$key => $value";
    
        $sel["$key"]     = urldecode($value);
    }


	// $codeid		= isset($sel['codeid'])?$sel['codeid']:null;
	// $com		= isset($sel['com'])?$sel['com']:null;
	// $tipoMsg	= isset($sel['tipoMsg'])?$sel['tipoMsg']:null;
	// $risposta	= isset($sel['risposta'])?$sel['risposta']:null;
	$rispostaCom	= isset($sel['rispostaCom'])?$sel['rispostaCom']:null;
	//$richiesta	= isset($sel['richiesta'])?$sel['richiesta']:null;
	$pattern = '/^[a-fA-F0-9]{16,16}$/';

	// $_SESSION['AWP']['id_ente_old']=isset($sel['idEnte'])?$sel['idEnte']:$_SESSION['AWP']['id_ente_old'];
	// $_SESSION['AWP']['id_ver']=isset($sel['idVerifica'])?$sel['idVerifica']:$_SESSION['AWP']['id_ver'];

	if($rispostaCom){
		
		if($rispostaCom == 'prova' || $rispostaCom == null){

			$rc="problemi con activex";
			$fase = 4;
			//$rc= getValue('help.txt',$fase);
		}else{
			//exit;
			//$tmp1=explode('#',$richiesta);


			$rispostaCom=hexToStr($rispostaCom);

            $itemRis= explode('~',$rispostaCom);

            // $data['CNTTOTIN']	= intval($itemRis[5]);
            // $data['CNTTOTOT']	= intval($itemRis[6]);
            // $data['CNTCL']		= intval($itemRis[7]);
            // $data['CNTOT']		= intval($itemRis[9]);
            // $data['CNTNP']		= intval($itemRis[10]);
            // $data['CNTIN']		= intval($itemRis[8]);

            // $message = 'CNTTOTIN:'. $data['CNTTOTIN'] .'<br>
            // CNTTOTOT:'. $data['CNTTOTOT'].'<br>
            // CNTCL:'. $data['CNTCL']	.'<br>
            // CNTOT:'. $data['CNTOT']	.'<br>
            // CNTNP:'. $data['CNTNP']	.'<br>	
            // CNTIN:'. $data['CNTIN']	.'<br>';
            
            //echo $message;


			$response = "########################################<br>
			Id_messaggio: " . $itemRis[0] . "<br>
			L_messaggio: " . $itemRis[1] . "<br>
			DATA_Risposta: " . $itemRis[2] . "<br>
			CODEID: " . $itemRis[3] . "<br>
			ESITO: " . $itemRis[4] . "<br>
			Valore contatore CNTTOTIN: " . $itemRis[5] . "<br>
			Valore contatore CNTTOTOT: " . $itemRis[6] . "<br>
			Valore contatore CNTCL: " . $itemRis[7] . "<br>
			Valore contatore CNTIN: " . $itemRis[8] . "<br>
			Valore contatore CNTOT: " . $itemRis[9] . "<br>
			Valore contatore CNTNP: " . $itemRis[10] . "<br>
			ORA_Risposta: " . $itemRis[11] . "<br>
			Codice_autenticazione: " . $itemRis[12] . "<br>
			Esito_comunicazione: " . $itemRis[13] . "<br>
			########################################<br>";

			echo $response;

			echo "<script type='text/javascript'>\n";
			echo "window.onload = function(){
				document.getElementById('connectBtn').style.display = 'none';
				document.getElementById('sendBtn').style.display = 'none';
			}";
			echo "</script>\n";

			//echo $rispostaCom;
			//die();
        }
    }
}



?>

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>

</head>
<body>
    <!-- <button onclick="startSerialCommunication()">Connect</button>
    <button onclick="stopSerialCommunication()">Disconnect</button>
    <button onclick="sendData()">Send</button> -->
    <?php
        sendData();
    ?>
    <!-- <script type="text/javascript" src='jsSerialApi.js'></script> -->
</body>
</html>