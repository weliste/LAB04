let port, ports, textEncoder, writer, writableStreamClosed = -1;

function translateConvertedChar2ClearChar(inputString) {
	var campoOut = "";
	var byteOut = "";
	var arr = new Array();
	var campoWorking = inputString;

	if (inputString == null || inputString == "") {
		return campoOut;
	}

	for (i = 0; i < inputString.length; i++) {
		codice = inputString.charCodeAt(i);
		byteOut = d2h(codice);
		byteOut = byteOut.toUpperCase();

		if (byteOut == 1 || byteOut == 2 || byteOut == 3 || byteOut == 4 || byteOut == 5 || byteOut == 6 || byteOut == 7 || byteOut == 8 || byteOut == 9 || byteOut == 'A' || byteOut == 'B' || byteOut == 'C' || byteOut == 'D' || byteOut == 'E' || byteOut == 'F') {


			byteOut = '0' + byteOut;

		}
		if (byteOut == 100) {
			byteOut = '00';
		}

		campoOut = campoOut + byteOut;
	
		arraylen = arr.push(byteOut);
	}
	return campoOut;
}

function sendData(){
    let txt = document.getElementById("messaggio").value;
    console.log("Messaggio: " + txt);
    writeSerialData(txt)
}


navigator.serial.addEventListener('connect', e => {
  alert("connected");
});

 // Richiedi l'accesso alla porta seriale
async function requestSerialPort() {
  if ("serial" in navigator) {
    console.log("Web Serial API is supported.");
    try {
        port = await navigator.serial.requestPort();
        await port.open({ baudRate: 19200 }); // Configura la velocità di baud rate appropriata
        let settings = {};

        if (localStorage.dtrOn == "true") settings.dataTerminalReady = true;
        if (localStorage.rtsOn == "true") settings.requestToSend = true;
        if (Object.keys(settings).length > 0) await port.setSignals(settings);
        
        textEncoder = new TextEncoderStream();
        writableStreamClosed = textEncoder.readable.pipeTo(port.writable);
        writer = textEncoder.writable.getWriter();
        
        return port;
        
    } catch (error) {
        console.error("Errore durante la richiesta della porta seriale:", error);
    }
  } else {
    console.error("Web Serial API not supported.");
  }
}

// Leggi dati dalla porta seriale
async function readSerialData(port) {
    const reader = port.readable.getReader();
    let app = '';
    let ricev = '';
    while (true) {
        try {
            const { value, done } = await reader.read();
		console.log("Conferma lettura da porta: "+ done);
            if (done) break;
           console.log("");
            let arr = value;
            
            for (x = 0; x < arr.length; x++) {
                if (arr[x] == 0) {
                    arr[x] = 256;
                }
                //conversione dei singoli byte da charcode a carattere
                ricev = String.fromCharCode(arr[x]);
                app = app + ricev;
            }
            
            console.log("Ricevuto:" + app);
            
            
            let translate = translateConvertedChar2ClearChar(app);
            console.log("translate: " + translate)
            document.getElementById("rispostaCom").value=translate;
            document.getElementById('form1').submit();
            //------------------------------------------
            
        } catch (error) {
          console.error("Errore durante la lettura dati seriali:", error);
          break;
        }
    }

    reader.releaseLock();
}

// Scrivi dati sulla porta seriale
async function writeSerialData(data) {
  try {
    await writer.write(data + "\n");
    console.log("Dati seriali inviati con successo.");
  } catch (error) {
    console.error("Errore durante l'invio dati seriali:", error);
  } 
}

function stopSerialCommunication(){
    writer.releaseLock();
}

// Esempio di utilizzo
async function startSerialCommunication() {
  port = await requestSerialPort();

  if (port) {
    console.log("Porta selezionata")
    await readSerialData(port); 
    conaole.log("Lettura su porta selezionata!");
    await writeSerialData(port, "Dati da inviare sulla porta seriale");
    conaole.log("Scrittura su porta selezionata!");
  }
  else {
    console.log("Porta non trovata!")
  }
}

function h2d(h) { return parseInt(h, 16); }

function d2h(d) { return d.toString(16); }

const connBtn = document.getElementById('connectBtn');
connBtn.addEventListener('click', () => {
  connBtn.disabled = true;
  const sendBtn = document.getElementById('sendBtn');
  sendBtn.disabled = false;
});


