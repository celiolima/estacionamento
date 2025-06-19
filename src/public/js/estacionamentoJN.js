
///-------------------------------------///
///   CAMERA  CONSTATES E FUNÇÕES       ///
///-------------------------------------///

//alert('ta fucionando')
const img_1 = document.getElementById("ESP32-1");
const img_2 = document.getElementById("ESP32-2");
var ws;
var imageFrame;
let urlObject_1, urlObject_2;
window["cam_1_enabler"] = true;
window["cam_2_enabler"] = true;
function hideRedDot() {
    document.getElementById("cam_1_red_dot").style.visibility = "hidden";
    document.getElementById("cam_2_red_dot").style.visibility = "hidden";
}
//setInterval(hideRedDot, 1000);

///-------------------------------------///
///   CHAT  CONSTATES E FUNÇÕES       ///
///-------------------------------------///

const sendBtn = document.querySelector('#enviar_mensagem');
const messages = document.querySelector('#messages');
const messageBox = document.querySelector('#messageBox');

/*   function showMessage(message) {
      messages.textContent += `\n\n${message}`;
      messages.scrollTop = messages.scrollHeight;
      messageBox.value = '';
  } */
//envia menssagem pro socket
/*  sendBtn.onclick = function() {
     if (!ws) {
     showMessage("No WebSocket connection :(");
     return ;
     }

     ws.send(messageBox.value);
     showMessage(messageBox.value);
 } */


///-------------------------------------///
///   PAINEL  CONSTATES E FUNÇÕES       ///
///-------------------------------------///
function switchPress(bt) {
    //botão liga/desliga
    if (bt == 01) {
        if (document.getElementById("bt01").className == "bt00des") {
            wsconnection.send('ressteContadores');//envia bt00off
            console.log("ressteContadores");
            //document.getElementById("bt00").className = "bt00d";
            // document.getElementById("bt00").innerHTML = "ligado";
        }
    }
    //botão liga/desliga
    if (bt == 02) {
        if (document.getElementById("bt02").className == "bt00des") {
            wsconnection.send('resstWIFI');//envia bt00off
            console.log("resstWIFI");
            //document.getElementById("bt00").className = "bt00d";
            // document.getElementById("bt00").innerHTML = "ligado";
        }
    }
};

///-------------------------------------///
///   INICIA SERVIDOR WEBSOCKETS        ///
///-------------------------------------///

function initWs(url, port) {
    const WS_URL = 'wss://' + url + ':' + port;
    //ws = new WebSocket('ws://fbestacionamento.steautomacaoesistemas.com.br:50521');
    ws = new WebSocket(WS_URL);
    ws.onopen = () => {
        console.log(`Connected to ${WS_URL}`);
        ws.send("WEB_CLIENT");
    };
    ws.onmessage = async (message) => {
        console.log('Na conexão:', message.data);
        //var res = JSON.parse(message.data);
        //console.log(`messagem:`,res);

        ///-------------------------------------///
        ///   PAINEL MENSAGENS                  ///
        ///-------------------------------------///

        try {

            //console.log(`messagem:`,message.data);
            var res = JSON.parse(message.data);
            if (res.painel) {
                console.log(`messagem painel:`, res.painel[0]);
                if (res.painel[0].total_car_mes) {
                    var total_car_mes = res.painel[0].total_car_mes;
                    document.getElementById("carMes").innerHTML = total_car_mes;
                }
                if (res.painel[0].total_car) {
                    var total_car = res.painel[0].total_car;
                    document.getElementById("carTot").innerHTML = total_car;
                }
                if (res.painel[0].total_mot_mes) {
                    var total_mot_mes = res.painel[0].total_mot_mes;
                    document.getElementById("motMes").innerHTML = total_mot_mes;
                }
                if (res.painel[0].total_mot) {
                    var total_mot = res.painel[0].total_mot;
                    document.getElementById("motTot").innerHTML = total_mot;
                }
            }

            if (res.devices) {
                console.log(`messagem devices:`, res.devices[0]);
                //if (res.devices[0].ecarro) {
                if (res.devices[0].ecarro) {
                    var c_entrv = res.devices[0].ecarro;
                    document.getElementById("ecar").innerHTML = c_entrv;
                }
                if (res.devices[0].scarro) {
                    var c_sairv = res.devices[0].scarro;
                    document.getElementById("scar").innerHTML = c_sairv;
                }
                if (res.devices[0].pcarro) {
                    var c_perv = res.devices[0].pcarro;
                    document.getElementById("pcar").innerHTML = c_perv;
                }
                if (res.devices[0].emoto) {
                    var c_entrMv = res.devices[0].emoto;
                    document.getElementById("emot").innerHTML = c_entrMv;
                }
                if (res.devices[0].smoto) {
                    var c_sairMv = res.devices[0].smoto;
                    document.getElementById("smot").innerHTML = c_sairMv;
                }
                if (res.devices[0].pmoto) {
                    var c_perMv = res.devices[0].pmoto;
                    document.getElementById("pmot").innerHTML = c_perMv;
                }

                //botão liga/desliga

                /*   if(res.devices[0].state=="liga" || res.devices[0].state=="1" )
                    {
                        document.getElementById("bt00").className = "bt00lig";
                        document.getElementById("bt00").innerHTML = "ligado";
                        console.log(res);             
                    } 
                    if(res.devices[0].state=="desliga" || res.devices[0].state=="0")
                    {
                        document.getElementById("bt00").className = "bt00des";
                        document.getElementById("bt00").innerHTML = "Desligado";
                        console.log(res);       
                    }  */
            }

        } catch (err) {
            console.log("ERR:" + err.message);
        }

        ///-------------------------------------///
        ///   CAMERAS MENSSAGENS                ///
        ///-------------------------------------///
        console.log("message: ", message.data);
        if (message.data == "Sem Cadastro") {
            console.log("string", message.data)
            document.getElementById("cam_1_autorizacao").style.color = "red";
            document.getElementById("cam_1_autorizacao").innerHTML = message.data;
        }
        if (message.data == "Autorizado") {
            console.log("string", message.data)
            document.getElementById("cam_1_autorizacao").style.color = "gren";
            document.getElementById("cam_1_autorizacao").innerHTML = message.data;
        }


        ///-------------------------------------///
        ///   CAMERA                            ///
        ///-------------------------------------///


        const arrayBuffer = message.data;
        var blobObj = new Blob([arrayBuffer]);
        const buf = await blobObj.arrayBuffer();
        var uint8 = new Uint8Array(buf.slice(12, 13));
        var currentCam = uint8[0];
        console.log("current Cam: ", currentCam);
        if (currentCam == 1) {
            imageFrame = img_1;
            document.getElementById("cam_1_red_dot").style.visibility = "visible";
            document.getElementById("cam_2_red_dot").style.visibility = "none";
            if (!window["cam_1_enabler"]) return;
            if (urlObject_1) {
                URL.revokeObjectURL(urlObject_1);
            }
            urlObject_1 = URL.createObjectURL(blobObj);
            imageFrame.src = urlObject_1;
        }
        if (currentCam == 2) {
            imageFrame = img_2;
            document.getElementById("cam_2_red_dot").style.visibility = "visible";
            document.getElementById("cam_1_red_dot").style.visibility = "none";
            if (!window["cam_2_enabler"]) return;
            if (urlObject_2) {
                URL.revokeObjectURL(urlObject_2);
            }
            urlObject_2 = URL.createObjectURL(blobObj);
            imageFrame.src = urlObject_2;
        }


        ///-------------------------------------///
        ///   CHAT MENSSAGENS                  ///
        ///-------------------------------------///

        // showMessage(message.data);			

    }
    ws.onclose = () => {
        console.log('Connection close!');
        setTimeout(function timeout() {
            console.log('tentando conexão');
            init();
        }, 1000);
        //ws = null;
    }
}
///-------------------------------------///
///   CHAT MENSSAGENS                  ///
///-------------------------------------///
//envia menssagem pro socket
/* sendBtn.onclick = function() {
    if (!ws) {
    showMessage("No WebSocket connection :(");
    return ;
    }

    ws.send(messageBox.value);
    showMessage(messageBox.value);
} */
//init();





