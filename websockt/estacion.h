

#include <FS.h>          //this needs to be first, or it all crashes and burns...
#include <ESP8266WiFi.h> //https://github.com/esp8266/Arduino
// needed for library
#include <DNSServer.h>
#include <ESP8266WebServer.h>
#include <WiFiManager.h> //https://github.com/tzapu/WiFiManager
#include <ArduinoJson.h> //https://github.com/bblanchon/ArduinoJson
#include <WebSocketsServer.h>
#include <Hash.h>
// #include <Wire.h>//
#include <LiquidCrystal_I2C.h>       //
#include <ESP8266HTTPUpdateServer.h> //      //Biblioteca que cria o servico de atualizacão via wifi (ou Over The Air - OTA)
#define DBG_OUTPUT_PORT Serial
#define butEnt1 12 // Botão de ajuste mais no digital A1
#define butEnt2 13 // Botão de ajuste menos no digital A2
#define butC 14    // Botão de ajuste menos no digital A2
#define fotE 0     // Saída para fotE  no A3 (será usado como digital)
#define fotS 2     // Saída para fotS  no A4 (será usado como digital)

// define seus valores padrão aqui, se houver valores diferentes em config.json, eles são substituídos.
// comprimento deve ser tamanho máximo + 1
char usuario[40] = "admin";
char porta[6] = "9090";
char senha[33] = "admin";
// default custom static IP
char static_ip[16] = "192.168.0.244";
char static_gw[16] = "192.168.0.1";
char static_sn[16] = "255.255.255.0";

// int porta = atoi( port );
// printf("Sum = %d\n", sum );
// int port = porta.toInt();
ESP8266WebServer server(9090);
////////////////////////////////////////////////////////////webSocket
WebSocketsServer webSocket = WebSocketsServer(81);
int wsClientNumber[5] = {-1, -1, -1, -1, -1};
int lastClientIndex = 0;
const int max_ws_client = 5;
String menssagem;
//////////////////////////////////////////////////////////////webSocket

// flag for saving data
bool shouldSaveConfig = false;
// boolean  t_Entr,t_Entr2,t_EntrC,t_Entr2C,t_Centro,t_Carro;
int c_entr, c_said, c_perm, c_entrM, c_saidM, c_permM;
int senEntrada, senSaida, senCentro;
int carroEntrada = 0, carroSaida = 0, motoEntrada = 0, motoSaida = 0, travaEntrada = 0, travaSaida = 0;
String req;

WiFiManager wifiManager;
LiquidCrystal_I2C disp(0x27, 16, 2);    //         // set the LCD address to 0x27 for a 16 chars and 2 line display
ESP8266HTTPUpdateServer atualizadorOTA; //      //Este e o objeto que permite atualizacao do programa via wifi (OTA)

// função de retorno de chamada nos informando sobre a necessidade de salvar a configuração
void saveConfigCallback()
{
    Serial.println("Should save config");
    shouldSaveConfig = true;
}
// INICIO FUNÇAO RESSETA ESP
void reset_config()
{

    // Reset das definicoes de rede
    wifiManager.resetSettings();
    delay(1500);
    ESP.reset();
}

/// FUNÇÃO DE RESSET DOS CONTADORES
void resset()
{

    Serial.println("Contadores Ressetados");
    Serial.println();

    disp.setCursor(0, 0);           // Posiciona cursor na coluna 1, linha 2
    disp.print("                "); // Imprime mensagem
    disp.setCursor(0, 1);           // Posiciona cursor na coluna 1, linha 2
    disp.print("                "); // Imprime mensagem

    // Aciona  buzzer
    disp.setCursor(0, 1);     // Posiciona cursor na coluna 1, linha 2
    disp.print("Resset ok!"); // Imprime mensagem
    delay(1000);
    disp.setCursor(0, 1);           // Posiciona cursor na coluna 1, linha 2
    disp.print("                "); // Imprime mensagem

    c_entr = 0x00;  // limpa flag c_ent
    c_said = 0x00;  // limpa flag c_tSai
    c_perm = 0x00;  // limpa flag c_perm
    c_entrM = 0x00; // limpa flag c_ent
    c_saidM = 0x00; // limpa flag c_tSai
    c_permM = 0x00; // limpa flag c_perm

    carroEntrada = 0;
    carroSaida = 0;
    motoEntrada = 0;
    motoSaida = 0;
    travaEntrada = 0;
    travaSaida = 0;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    disp.setCursor(0, 0);
    disp.print("EC");
    disp.print(c_entr);
    disp.setCursor(5, 0);
    disp.print("SC");
    disp.print(c_said);
    disp.setCursor(10, 0);
    disp.print("PC");
    disp.print(c_perm);

    disp.setCursor(0, 1);
    disp.print("EM");
    disp.print(c_entrM);
    disp.setCursor(5, 1);
    disp.print("SM");
    disp.print(c_saidM);
    disp.setCursor(10, 1);
    disp.print("PM");
    disp.print(c_permM);
    delay(3000);

    /*
    String header = "HTTP/1.1 301 OK\r\nLocation: /\r\nCache-Control: no-cache\r\n\r\n";
    server.sendContent(header);
    server.send_P(200, "text/html", INDEX_HTML);
    Serial.println("Sucesso resset ");
    return;*/
}

//////////////////////////////////////////////////////////////////////////////////
/// INICIO PAGINA PUPBLIC
static const char PROGMEM PUBLIC_HTML[] = R"rawliteral(
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
<meta charset='utf-8' />
<title>Controle de Estacionamento WEB</title>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>

<style type='text/css'>
  div > h2 {color: #00979C;}
  body {font-family: Arial;margin: 0px;}
  h5{margin-top: 10px;margin-bottom: 0px;color: #00979C;font-size: 23px;text-align: center};  
  .mostEsq{border-radius:0.4rem;color:#fff;margin: 6px;line-height:2.0rem;font-size:1.2rem;width:90%;text-align: right;} 
  .mostDir{border-radius:0.4rem;color:#fff;margin: 6px;background-color:#1fa3ec;line-height:2.0rem;font-size:1.4rem;width:93%;text-align: center;}
  .header{width: 100%;height: 70px;border: 10px;background-color: #F6F9F9;margin-top: 0px;}
  .quadrado{border-style: solid;border-color: #00979C;background-color: #F6F9F9;width: 380px;height: 195px;text-align: center;display: inline-block;margin-bottom: 5px;}

  .bt00d {border-radius:0.4rem;width: 185px; height: 23%;margin: 2px; cursor: pointer; float: right; background-color:#999999;}
  .bt00e {border-radius:0.4rem;width: 185px; height: 23%;margin: 2px;cursor: pointer; float: left;background-color:#999999;}
  .quadradoResset{border-style: solid;border-color: #00979C;background-color: #F6F9F9; width: 130px; height: 60px;text-align: center;display: inline-block;margin-bottom: 5px;}
  .rodape{ width: 100%;height:60px; background-color: #F6F9F9; }
  .rodape address{ background-color: #F6F9F9;width: 100%; height:35px; color:#999999;font-size:13px;font-weight:bold;font-style:normal;padding:15px 0 0; border-bottom:1px solid #CCC; text-shadow:#FFF 1px 1px 1px;}
  
    .alarme{border-style: solid;border-color: #00979C;background-color: #F6F9F9;width: 110px;height: 110px;text-align: center;margin: 5px; margin-top: 0px;}
    .bt00des {height: 65%; cursor: pointer; background-color:#999999;}
    .bt00lig {height: 65%; cursor: pointer; background-color:#ADFF85;}

</style>
<script>

      var wsconnection;
      window.onbeforeunload = function() 
      {
        wsconnection.onclose = function () {}; // disable onclose handler first
        wsconnection.close()
        alert("FALHA NA CONEXÃO");
      };

      function switchPress(bt)
      {

         //botão liga/desliga
        if(bt == 01)
        {
            if(document.getElementById("bt00").className == "bt00lig"){
            wsconnection.send('desliga');//envia bt00off
            console.log("desligando");
              //document.getElementById("bt00").className = "bt00d";
              // document.getElementById("bt00").innerHTML = "ligado";
            }else if(document.getElementById("bt00").className == "bt00des"){
              wsconnection.send('liga');//envia bt00on
              console.log("ligando");
              // document.getElementById("bt00").className = "bt00l";
              // document.getElementById("bt00").innerHTML = "Desligado";
            }
        }
      };
    function createWs()
      {

        wsconnection = new WebSocket('ws://' + location.hostname + ':81/', ['arduino']);
        wsconnection.onopen = function() 
        {
          //document.getElementById("cube-switch").className = "cube-switch";
          //document.getElementById("cube-switch").style.display = "block";
         // wsconnection.send('Connect ' + new Date());
           wsconnection.send('situacao_esp');
           console.log("enviado pro esp 'situacão'");
          /* setInterval(function estatus(){
           wsconnection.send('situacao');//envia bt00on
           console.log("enviado pro esp e arduino 'situacão'"); },60000);*/
          
           
        };
        wsconnection.onerror = function(error) 
        {
          console.log('WebSocket Error ', error);
          alert("FALHA NA CONEXÃO");
        };
        wsconnection.onmessage = function(e) 
        {
          console.log('Server: ', e.data);
          //var dados =   e.data;
          //  documento . getElementById ( " c_entr " ). innerHTML  = dados ;
          // console.log(dados);
          try 
          {
            var res = JSON.parse(e.data);

            if(res.devices[0].ecarro )
            {
              var c_entrv = res.devices[0].ecarro;
              document.getElementById("ecar").innerHTML = c_entrv;            
            } 
            if(res.devices[0].scarro )
            {
              var c_sairv = res.devices[0].scarro;
              document.getElementById("scar").innerHTML = c_sairv;            
            }
            if(res.devices[0].pcarro )
            {
              var c_perv = res.devices[0].pcarro;
              document.getElementById("pcar").innerHTML = c_perv;            
            }
            if(res.devices[0].emoto )
            {
              var c_entrMv = res.devices[0].emoto;
              document.getElementById("emot").innerHTML = c_entrMv;            
            } 
            if(res.devices[0].smoto )
            {
              var c_sairMv = res.devices[0].smoto;
              document.getElementById("smot").innerHTML = c_sairMv;            
            } 
            if(res.devices[0].pmoto )
            {
              var c_perMv = res.devices[0].pmoto;
              document.getElementById("pmot").innerHTML = c_perMv;            
            }         

           //botão liga/desliga
           /*
            if(res.devices[0].state=="liga" || res.devices[0].state=="1" )
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
            }            
            */
          }
          catch(err) {
            //  console.log("ERR:"+err.message);
          }
        }
    }      

</script>     
</head>
<body onload ="createWs()">
   <center>
    <div class="header">
     </br>
     <div><h2>Controle de Estacionamento WEB</h2></div>
     </br>
    </div>

    </br>

    <div class="quadrado">
      <h5>CARROS</h5>
      <div  class= "bt00e  " >
        <p class="mostEsq">ENTRADA:</p >
      </div>
      <div  class= "bt00d " >
        <p id = "ecar" class="mostDir"> eCarro </p >
      </div>
      <div  class= "bt00e  " >
        <p class="mostEsq">SAIDA:</p> 
      </div>
      <div  class= "bt00d " >
        <p id = "scar"class="mostDir"> sCarro </p >
      </div> 
      <div  class= "bt00e  " >
        <p class="mostEsq">PÁTIO:</p>
      </div>
      <div  class= "bt00d " >
        <p id = "pcar" class="mostDir"> pCarro </p >
      </div>
    </div>
    </br>
    <div class="quadrado">
      <h5>MOTOS</h5>
      <div  class= "bt00e  " >
        <p class="mostEsq">ENTRADA:</p >
      </div>
      <div  class= "bt00d " >  
        <p id = "emot" class="mostDir"> eMoto </p >
      </div>
      <div  class= "bt00e  " >
        <p class="mostEsq">SAIDA:</p> 
      </div>
      <div  class= "bt00d " >
         <p id = "smot"class="mostDir"> sMoto </p >
      </div> 
      <div  class= "bt00e  " >
        <p class="mostEsq">PÁTIO:</p>
      </div>
      <div  class= "bt00d " >
        <p id = "pmot"class="mostDir"> pMoto </p >
      </div>
    </div>

  </br> 
  <a href="login?login=YES">PAINEL DE CONTROLE</a></br>
  </br>

  <div class="rodape">
  <address>CopyRight 2018 - Todos os direitos reservados</br>"
  Powered by STE AUTOMAÇÃO E SISTEMAS - www.steautomacaoesistemas.com.br</address>
  </div>
</center>
</body>
</html>
)rawliteral";
/// FIM PAGINA PUPBIC
/// INICIO PAGINA PRINCIPAL
static const char PROGMEM INDEX_HTML[] = R"rawliteral(
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
<meta charset='utf-8' />
<title>Controle de Estacionamento WEB</title>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>

<style type='text/css'>
  div > h2 {color: #00979C;}
  body {font-family: Arial;margin: 0px;}
  h5{margin-top: 10px;margin-bottom: 0px;color: #00979C;font-size: 23px;text-align: center}; 
  .mostEsq{border-radius:0.4rem;color:#fff;margin: 6px;line-height:2.0rem;font-size:1.2rem;width:90%;text-align: right;} 
  .mostDir{border-radius:0.4rem;color:#fff;margin: 6px;background-color:#1fa3ec;line-height:2.0rem;font-size:1.4rem;width:93%;text-align: center;}
  .header{width: 100%;height: 70px;border: 10px;background-color: #F6F9F9;margin-top: 0px;}
  .quadrado{border-style: solid;border-color: #00979C;background-color: #F6F9F9;width: 380px;height: 195px;text-align: center;display: inline-block;margin-bottom: 5px;}
  .config{border-style: solid;border-color: #00979C;background-color: #F6F9F9;width: 380px;height: 45px;text-align: center;display: inline-block;margin-bottom: 5px;}

  .bt00d {border-radius:0.4rem;width: 185px; height: 23%;margin: 2px; cursor: pointer; float: right; background-color:#999999;}
  .bt00e {border-radius:0.4rem;width: 185px; height: 23%;margin: 2px;cursor: pointer; float: left;background-color:#999999;}
  .quadradoResset{border-style: solid;border-color: #00979C;background-color: #F6F9F9; width: 130px; height: 60px;text-align: center;display: inline-block;margin-bottom: 5px;}
  .rodape{ width: 100%;height:60px;background-color: #F6F9F9; }
  .rodape address{ background-color: #F6F9F9;width: 100%; height:35px; color:#999999;font-size:13px;font-weight:bold;font-style:normal;padding:15px 0 0; border-bottom:1px solid #CCC; text-shadow:#FFF 1px 1px 1px;}
  
  .config1{border-style: solid;border-color: #00979C;background-color: #F6F9F9;width: 180px;height: 40px;text-align: center;margin: 2px; margin-top: 0px;float: right;}
  .config2{border-style: solid;border-color: #00979C;background-color: #F6F9F9;width: 85px;height: 40px;text-align: center;margin: 2px; margin-top: 0px;float: right;}
  .bt00des {height: 90%;width: 90%; cursor: pointer; background-color:#999999;}
  .bt00lig {height: 90%; cursor: pointer; background-color:#ADFF85;}

</style>
<script>

      var wsconnection;
      window.onbeforeunload = function() 
      {
        wsconnection.onclose = function () {}; // disable onclose handler first
        wsconnection.close()
        alert("FALHA NA CONEXÃO");
      };

      function switchPress(bt)
      {

         //botão liga/desliga
        if(bt == 01)
        {
            if(document.getElementById("bt01").className == "bt00des"){
            wsconnection.send('ressteContadores');//envia bt00off
            console.log("ressteContadores");
              //document.getElementById("bt00").className = "bt00d";
              // document.getElementById("bt00").innerHTML = "ligado";
            }
        }
         //botão liga/desliga
        if(bt == 02)
        {
            if(document.getElementById("bt02").className == "bt00des"){
            wsconnection.send('resstWIFI');//envia bt00off
            console.log("resstWIFI");
              //document.getElementById("bt00").className = "bt00d";
              // document.getElementById("bt00").innerHTML = "ligado";
            }
        }
      };
    function createWs()
      {

        wsconnection = new WebSocket('ws://' + location.hostname + ':81/', ['arduino']);
        wsconnection.onopen = function() 
        {
          //document.getElementById("cube-switch").className = "cube-switch";
          //document.getElementById("cube-switch").style.display = "block";
         // wsconnection.send('Connect ' + new Date());
           wsconnection.send('situacao_esp');
           console.log("enviado pro esp 'situacão'");
          /* setInterval(function estatus(){
           wsconnection.send('situacao');//envia bt00on
           console.log("enviado pro esp e arduino 'situacão'"); },60000);*/
          
           
        };
        wsconnection.onerror = function(error) 
        {
          console.log('WebSocket Error ', error);
          alert("FALHA NA CONEXÃO");
        };
        wsconnection.onmessage = function(e) 
        {
          console.log('Server: ', e.data);
          //var dados =   e.data;
          //  documento . getElementById ( " c_entr " ). innerHTML  = dados ;
          // console.log(dados);
          try 
          {
            var res = JSON.parse(e.data);

            if(res.devices[0].ecarro )
            {
              var c_entrv = res.devices[0].ecarro;
              document.getElementById("ecar").innerHTML = c_entrv;            
            } 
            if(res.devices[0].scarro )
            {
              var c_sairv = res.devices[0].scarro;
              document.getElementById("scar").innerHTML = c_sairv;            
            }
            if(res.devices[0].pcarro )
            {
              var c_perv = res.devices[0].pcarro;
              document.getElementById("pcar").innerHTML = c_perv;            
            }
            if(res.devices[0].emoto )
            {
              var c_entrMv = res.devices[0].emoto;
              document.getElementById("emot").innerHTML = c_entrMv;            
            } 
            if(res.devices[0].smoto )
            {
              var c_sairMv = res.devices[0].smoto;
              document.getElementById("smot").innerHTML = c_sairMv;            
            } 
            if(res.devices[0].pmoto )
            {
              var c_perMv = res.devices[0].pmoto;
              document.getElementById("pmot").innerHTML = c_perMv;            
            }         

           //botão liga/desliga
           /*
            if(res.devices[0].state=="liga" || res.devices[0].state=="1" )
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
            }            
            */
          }
          catch(err) {
            //  console.log("ERR:"+err.message);
          }
        }
    }      

</script>     
</head>
<body onload ="createWs()">
   <center>
    <div class="header">
     </br>
     <div><h2>Controle de Estacionamento WEB</h2></div>
     </br>
    </div>

    </br>

    <div class="quadrado">
      <h5>CARROS</h5>
      <div  class= "bt00e  " >
        <p class="mostEsq">ENTRADA:</p >
      </div>
      <div  class= "bt00d " >
        <p id = "ecar" class="mostDir"> eCarro </p >
      </div>
      <div  class= "bt00e  " >
        <p class="mostEsq">SAIDA:</p> 
      </div>
      <div  class= "bt00d " >
        <p id = "scar"class="mostDir"> sCarro </p >
      </div> 
      <div  class= "bt00e  " >
        <p class="mostEsq">PÁTIO:</p>
      </div>
      <div  class= "bt00d " >
        <p id = "pcar" class="mostDir"> pCarro </p >
      </div>
    </div>
    </br>
    <div class="quadrado">
      <h5>MOTOS</h5>
      <div  class= "bt00e  " >
        <p class="mostEsq">ENTRADA:</p >
      </div>
      <div  class= "bt00d " >  
        <p id = "emot" class="mostDir"> eMoto </p >
      </div>
      <div  class= "bt00e  " >
        <p class="mostEsq">SAIDA:</p> 
      </div>
      <div  class= "bt00d " >
         <p id = "smot"class="mostDir"> sMoto </p >
      </div> 
      <div  class= "bt00e  " >
        <p class="mostEsq">PÁTIO:</p>
      </div>
      <div  class= "bt00d " >
        <p id = "pmot"class="mostDir"> pMoto </p >
      </div>
    </div> 

      <h5>Configurações</h5> 

    <div class="config">
       <div  class= "config2" >        
         <button class="bt00des"><a href="login?DISCONNECT=YES">logof</a></button> 
       </div>
       <div  class= "config2" >
         <button class="bt00des" id="bt02" onclick="switchPress(02)">Resset WIFI</button>          
       </div>
       <div  class= "config1" >      
         <button class="bt00des" id="bt01" onclick="switchPress(01)">Resset Contadores</button>
       </div>
    </div>

  </br>
 
  <div class="rodape">
   <address>CopyRight 2018 - Todos os direitos reservados</br> Powered by STE AUTOMAÇÃO E SISTEMAS - www.steautomacaoesistemas.com.br
   </ddress>
  </div>
  </center>
</body>
</html>
)rawliteral";
/// FIM PAGINA PRINCIPAL
//////////--------------iniciowebSocket-------------------///////////

// função que envia a inforamção para os clietes via Json
void wsSendState(String state)
{
    String json = "{\"devices\":[{\"" + (state) + "\":\"" + (menssagem) + "\"}]}";
    int numcl = 0;
    for (numcl = 0; numcl < max_ws_client; numcl++)
    {
        if (wsClientNumber[numcl] != -1)
            webSocket.sendTXT(wsClientNumber[numcl], json);
    }

    json = String();
    DBG_OUTPUT_PORT.print("enviando do esp pra clientes conectrados:");
    DBG_OUTPUT_PORT.println(menssagem);
}

// analiza eventos chegados dos clientes conectados e chama funçoes wsSendState() e lerDados()

void webSocketEvent(uint8_t num, WStype_t type, uint8_t *payload, size_t lenght)
{
    switch (type)
    {
    case WStype_DISCONNECTED:

        DBG_OUTPUT_PORT.printf("[%u] Disconnected!\n", num);
        break;

    case WStype_CONNECTED:
    {
        IPAddress ip = webSocket.remoteIP(num);
        DBG_OUTPUT_PORT.printf("[%u] Connected from %d.%d.%d.%d url: %s\n", num, ip[0], ip[1], ip[2], ip[3], payload);

        int index = (num % max_ws_client);
        if (index <= 0)
            index = 0;
        wsClientNumber[index] = num;
        DBG_OUTPUT_PORT.printf("Save client index %d :%u\n", index, num);

        wsSendState("cliente"); // send message to client
    }
    break;

    case WStype_TEXT:

        DBG_OUTPUT_PORT.printf("[%u] get Text: %s\n", num, payload);
        // String mensagem = strcmp((const char *)payload);
        // DBG_OUTPUT_PORT.println((const char *)payload);
        DBG_OUTPUT_PORT.print("enviano pro arduino =");
        DBG_OUTPUT_PORT.println((const char *)payload);

        menssagem = (const char *)payload;
        DBG_OUTPUT_PORT.print("mensagem =");
        DBG_OUTPUT_PORT.println(menssagem);

        if (menssagem == "ressteContadores")
        {
            resset();
            menssagem = c_entrM;
            wsSendState("emoto");
            delay(20);
            menssagem = c_saidM;
            wsSendState("smoto");
            delay(20);
            menssagem = c_permM;
            wsSendState("pmoto");
            delay(20);
            menssagem = c_entr;
            wsSendState("ecarro");
            delay(20);
            menssagem = c_said;
            wsSendState("scarro");
            delay(20);
            menssagem = c_perm;
            wsSendState("pcarro");
        }

        if (menssagem == "resstWIFI")
        {
            reset_config();
        }
        if (menssagem == "situacao_esp")
        {
            /*
             // String json = "{\"devices\":[{\"emoto\":\"" + (c_entrM) + "\",\"smoto\":\"" + (c_saidM) + "\",\"pmoto\":\"" + (c_permM) + "\",\"ecarro\":\"" + (c_entr) + "\",\"scarro\":\"" + (c_said) + "\",\"pcarro\":\"" + (c_perm) + "\"}]}";
              String json = "{\"devices\":[{\"emoto\":\"" + (menssagem) + "\"}]}";
              int numcl = 0;
              for (numcl = 0; numcl < max_ws_client; numcl++){
                 if (wsClientNumber[numcl] != -1)
                 webSocket.sendTXT(wsClientNumber[numcl], json);
                 }

             json = String();
             DBG_OUTPUT_PORT.print("enviando do esp pra clientes conectrados:");
             DBG_OUTPUT_PORT.println(menssagem);
               */

            menssagem = c_entrM;
            wsSendState("emoto");
            delay(20);
            menssagem = c_saidM;
            wsSendState("smoto");
            delay(20);
            menssagem = c_permM;
            wsSendState("pmoto");
            delay(20);
            menssagem = c_entr;
            wsSendState("ecarro");
            delay(20);
            menssagem = c_said;
            wsSendState("scarro");
            delay(20);
            menssagem = c_perm;
            wsSendState("pcarro");
        }
        break;
    }
}

//////////---------------fimwebSocket-------------------///////////

//////////---------------inicioSimplesAutenticaçâo-------------------///////////
// Check if header is present and correct
bool is_authentified()
{
    Serial.println("Enter is_authentified");
    if (server.hasHeader("Cookie"))
    {
        Serial.print("Found cookie: ");
        String cookie = server.header("Cookie");
        Serial.println(cookie);
        if (cookie.indexOf("ESPSESSIONID=1") != -1)
        {
            Serial.println("Authentification Successful");
            return true;
        }
    }
    Serial.println("Authentification Failed");
    return false;
}

// login page, also called for disconnect
void handleLogin()
{
    String msg;
    if (server.hasHeader("Cookie"))
    {
        Serial.print("Found cookie: ");
        String cookie = server.header("Cookie");
        Serial.println(cookie);
    }
    if (server.hasArg("DISCONNECT"))
    {
        Serial.println("Disconnection");
        String header = "HTTP/1.1 301 OK\r\nSet-Cookie: ESPSESSIONID=0\r\nLocation: /\r\nCache-Control: no-cache\r\n\r\n";
        server.sendContent(header);
        return;
    }
    if (server.hasArg("USERNAME") && server.hasArg("PASSWORD"))
    {
        if (server.arg("USERNAME") == usuario && server.arg("PASSWORD") == senha)
        {
            String header = "HTTP/1.1 301 OK\r\nSet-Cookie: ESPSESSIONID=1\r\nLocation: /\r\nCache-Control: no-cache\r\n\r\n";
            server.sendContent(header);
            Serial.println("Log in Successful");
            return;
        }
        msg = "Erro username/password! Tente Novamente.";
        Serial.println("Log in Failed");
    }
    String content = "<!DOCTYPE html>";
    content += "<html lang='pt-BR'>";
    content += "<head>";
    content += " <meta charset='utf-8' />";
    content += " <title>Painel de Alarme e Automação</title>";
    content += " <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=no'/>";
    content += "  <style type='text/css'>";
    content += " div > h2 {color: #00979C;}";
    content += " body {font-family: Arial;margin: 0px;}";
    content += ".header{width: 100%;height: 110px;border: 10px;background-color: #F6F9F9;margin-top: 0px;}";
    content += ".quadrado{border-style: solid;border-color: #00979C;background-color: #F6F9F9;width: 100%;height: 150px;text-align: center;display: inline-block;margin-bottom: 5px;}";
    content += ".form{font-size: 17px;width: 100%;height: 150px;text-align: center;display: inline-block;margin-bottom: 5px;}";
    content += ".imput{font-size: 17px;width: 150px;text-align: left;display: inline-block;margin-bottom: 5px;}";
    content += ".quadradoResset{ width: 255px; height: 50px;text-align: center;display: inline-block;margin-bottom: 5px;}";
    content += ".rodape{ width: 100%;height:50px; background-color: #F6F9F9; }";
    content += ".rodape address{ background-color: #F6F9F9;width: 100%; height:30px; color:#999999;font-size:12px;font-weight:bold;font-style:normal;padding:15px 0 0; border-bottom:1px solid #CCC; text-shadow:#FFF 1px 1px 1px;}";
    content += " h5{margin-top: 40px;margin-bottom: 0px;color: #00979C;font-size: 18px;";
    content += " p{font-size: 50px; margin: 0px; color: #00979C;}";
    content += "</style>";
    content += " </head>";
    content += "<body style= font-family: Arial;margin: 0px;>";
    content += "<center>";
    content += "<div class='header'>";
    content += "</br>";
    content += "<div>";
    content += "<h2>Painel de Alarme e Automação</h2>";
    content += "</div>";
    content += "</br>";
    content += "</div>";
    content += "</br>";
    content += "</br>";
    content += "<div class='quadrado'>";
    content += "<h5>Ambiente Protegido</h5>";
    content += "<div class='quadradoResset'>";
    content += "<p>";
    content += "<p >É necessario efetuar o login para  Acesso ao Painel</p>";
    content += "</div>";
    content += "</div>";
    content += "</br>";
    content += "</br>";
    content += "</br>";
    content += "<form class='form' action='/login' method='POST'>Para login default : admin/admin</br></br>";
    content += "Usuario:<input class='imput' type='text' name='USERNAME' placeholder='usuario'></br>";
    content += "Senha   :<input class='imput' type='password' name='PASSWORD' placeholder='senha'></br>";
    content += "<input type='submit' name='SUBMIT' value='Enviar'></form>" + msg + "</br>";
    content += "</p>";
    content += "</div>";
    content += "</br>";
    content += "</br>";
    content += "</br>";
    content += "</br>";
    content += "</br>";
    content += "<div class=\"rodape\">";
    content += "<address>CopyRight 2018 - Todos os direitos reservados</br>";
    content += "Powered by STE AUTOMAÇÂO E SISTEMAS - www.steautomacaoesistemas.com.br</address>";
    content += "</div>";
    content += "</center>";
    content += "</div>";
    content += "</body>";
    content += "</html>";

    server.send(200, "text/html", content);
}

// root page can be accessed only if authentification is ok
void publicHtml()
{

    Serial.println("Enter fronte");

    server.send_P(200, "text/html", PUBLIC_HTML);
}

// root page can be accessed only if authentification is ok
void handleRoot()
{
    Serial.println("Enter handleRoot");
    String header;
    if (!is_authentified())
    {
        String header = "HTTP/1.1 301 OK\r\nLocation: /Pagina_pulica\r\nCache-Control: no-cache\r\n\r\n";
        server.sendContent(header);
        return;
    }

    server.send_P(200, "text/html", INDEX_HTML);
}

// no need authentification
void handleNotFound()
{
    String message = "File Not Found\n\n";
    message += "URI: ";
    message += server.uri();
    message += "\nMethod: ";
    message += (server.method() == HTTP_GET) ? "GET" : "POST";
    message += "\nArguments: ";
    message += server.args();
    message += "\n";
    for (uint8_t i = 0; i < server.args(); i++)
    {
        message += " " + server.argName(i) + ": " + server.arg(i) + "\n";
    }
    server.send(404, "text/plain", message);
}
void display()
{
    // CARROS DISPLAY
    if (c_entr >= c_said)
    {
        c_perm = c_entr - c_said;
        if (c_perm >= 0 && c_perm < 10)
        {
            disp.setCursor(10, 0); // Posiciona cursor na coluna 1, linha 10
            disp.print("PC:");
            disp.setCursor(13, 0);
            disp.print("00");
            disp.setCursor(15, 0);
            disp.print(c_perm);
        }
        if (c_perm >= 10 && c_perm < 100)
        {
            disp.setCursor(10, 0); // Posiciona cursor na coluna 1, linha 10
            disp.print("PC:");
            disp.setCursor(13, 0);
            disp.print("0");
            disp.setCursor(14, 0);
            disp.print(c_perm);
        }
        if (c_perm >= 100 && c_perm < 1000)
        {
            disp.setCursor(10, 0); // Posiciona cursor na coluna 1, linha 10
            disp.print("PC:");
            disp.setCursor(13, 0);
            disp.print(c_perm);
        }
    }

    // MOTOS DISPLAY

    if (c_entrM >= c_saidM)
    {
        c_permM = c_entrM - c_saidM;

        if (c_permM >= 0 && c_permM < 10)
        {
            disp.setCursor(10, 1); // Posiciona cursor na coluna 1, linha 10
            disp.print("PM:");
            disp.setCursor(13, 1);
            disp.print("00");
            disp.setCursor(15, 1);
            disp.print(c_permM);
        }
        if (c_permM >= 10 && c_permM < 100)
        {
            disp.setCursor(10, 0); // Posiciona cursor na coluna 1, linha 10
            disp.print("PC:");
            disp.setCursor(13, 1);
            disp.print("0");
            disp.setCursor(14, 1);
            disp.print(c_permM);
        }
        if (c_permM >= 100 && c_permM < 1000)
        {
            disp.setCursor(10, 1); // Posiciona cursor na coluna 1, linha 10
            disp.print("PM:");
            disp.setCursor(13, 1);
            disp.print(c_permM);
        }
    }
}

// INICIO FUNÇAO LERDADOS
void lerDados()
{

    senEntrada = digitalRead(butEnt2);
    senSaida = digitalRead(butEnt1);
    senCentro = digitalRead(butC);

    // ENTRADA
    if ((!senEntrada || travaSaida == 1) && !senCentro && carroEntrada == 0 && motoEntrada == 0 && travaEntrada == 0) // condicional ou + entrada ativada para manter bloco ativo na opção moto
    {
        Serial.println("Entrada");
        travaSaida = 1;
        Serial.print("Trava Saida: ");
        Serial.println(travaSaida);

        if (senEntrada && !senCentro && !senSaida)
        {
            Serial.println("Entrada motos");
            c_entrM++;
            menssagem = c_entrM;
            wsSendState("emoto");
            disp.setCursor(0, 1); // Posiciona cursor na coluna 1, linha 2
            disp.print("EM");
            disp.print(c_entrM);
            display();
            menssagem = c_permM;
            wsSendState("pmoto");

            digitalWrite(fotS, HIGH); // dipara foto entrada
            digitalWrite(fotE, HIGH); // dipara foto entrada
            delay(300);
            digitalWrite(fotS, LOW); // dipara foto entrada
            digitalWrite(fotE, LOW); // dipara foto entrada

            motoEntrada = 1;
            Serial.print("Moto Entrada: ");
            Serial.println(motoEntrada);
        }
        if (!senEntrada && !senCentro && !senSaida)
        {
            Serial.println("Entrada carro");
            c_entr++;
            menssagem = c_entr;
            wsSendState("ecarro");
            disp.setCursor(0, 0); // Posiciona cursor na coluna 1, linha 2
            disp.print("EC");
            disp.print(c_entr);
            display();
            menssagem = c_perm;
            wsSendState("pcarro");

            digitalWrite(fotS, HIGH); // dipara foto entrada
            digitalWrite(fotE, HIGH); // dipara foto entrada
            delay(300);
            digitalWrite(fotS, LOW); // dipara foto entrada
            digitalWrite(fotE, LOW); // dipara foto entrada
            carroEntrada = 1;
            Serial.print("Carro Entrada: ");
            Serial.println(carroEntrada);
        }
    }
    if ((carroEntrada == 1 || motoEntrada == 1) && senCentro)
    {
        carroEntrada = 0;
        motoEntrada = 0;
        travaSaida = 0;
        Serial.print("Carro Entrada, Moto entrada e Trava Saida ZERADOS ");
    }
    // SAIDA
    if ((!senSaida || travaEntrada == 1) && !senCentro && carroSaida == 0 && motoSaida == 0 && travaSaida == 0)
    {
        Serial.println("Saida");
        travaEntrada = 1;
        Serial.print("Trava Entrada: ");
        Serial.println(travaEntrada);

        //&& (c_saidM < c_entrM )&& (c_said < c_entr )

        if (!senEntrada && !senCentro && senSaida)
        {
            Serial.println("Saida motos");
            if (c_saidM < c_entrM)
            {
                c_saidM++;
            }
            menssagem = c_saidM;
            wsSendState("smoto");
            disp.setCursor(5, 1); // Posiciona cursor na coluna 1, linha 2
            disp.print("SM");
            disp.print(c_saidM);
            display();
            menssagem = c_permM;
            wsSendState("pmoto");

            digitalWrite(fotS, HIGH); // dipara foto entrada
            digitalWrite(fotE, HIGH); // dipara foto entrada
            delay(300);
            digitalWrite(fotS, LOW); // dipara foto entrada
            digitalWrite(fotE, LOW); // dipara foto entrada
            motoSaida = 1;
            Serial.print("Moto Saida: ");
            Serial.println(motoSaida);
        }
        if (!senEntrada && !senCentro && !senSaida)
        {
            Serial.println("Saida Carros");
            if (c_said < c_entr)
            {
                c_said++;
            }
            menssagem = c_said;
            wsSendState("scarro");
            disp.setCursor(5, 0); // Posiciona cursor na coluna 1, linha 2
            disp.print("SC");
            disp.print(c_said);
            display();
            menssagem = c_perm;
            wsSendState("pcarro");

            digitalWrite(fotS, HIGH); // dipara foto entrada
            digitalWrite(fotE, HIGH); // dipara foto entrada
            delay(300);
            digitalWrite(fotS, LOW); // dipara foto entrada
            digitalWrite(fotE, LOW); // dipara foto entrada
            carroSaida = 1;
            Serial.print("Carro Saida: ");
            Serial.println(carroSaida);
        }
    }
    if ((carroSaida == 1 || motoSaida == 1) && senCentro)
    {
        carroSaida = 0;
        motoSaida = 0;
        travaEntrada = 0;
        Serial.print("Carro Saida, Moto Saida e Trava Entrada ZERADOS ");
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////// FIM FUN LER DADOS /////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////// INICIO FUN ATUALIZAÇÂO //////////////////////////////////////////////////

void InicializaServicoAtualizacao()
{
    atualizadorOTA.setup(&server);
    // servidorWeb.begin();
    Serial.println("O servico de atualizacao remota (OTA) Foi iniciado com sucesso! Abra http://");
    // Serial.println(host);
    Serial.print(".local/update no seu browser para iniciar a atualizacao\n");
}

////////////////////////////////////////////////////////////// FIM FUN ATUALIZAÇÂO //////////////////////////////////////////////////////

void setup()
{
    Serial.begin(115200);
    Serial.println("serial iniciada");

    // clean FS, for testing
    // SPIFFS.format();
    // wifiManager.resetSettings();
    // delay(1500);
    // ESP.reset();

    // configuração de leitura do FS json
    Serial.println("mounting FS...");

    if (SPIFFS.begin())
    {
        Serial.println("sistema de arquivos montado");
        if (SPIFFS.exists("/config.json"))
        {
            // arquivo existe, lendo e carregando
            Serial.println("lendo arquivo de configuração");
            File configFile = SPIFFS.open("/config.json", "r");
            if (configFile)
            {
                Serial.println("opened config file");
                size_t size = configFile.size();
                // Allocate a buffer to store contents of the file.
                std::unique_ptr<char[]> buf(new char[size]);

                configFile.readBytes(buf.get(), size);
                DynamicJsonBuffer jsonBuffer;
                JsonObject &json = jsonBuffer.parseObject(buf.get());
                json.printTo(Serial);
                if (json.success())
                {
                    Serial.println("\nparsed json");

                    strcpy(usuario, json["usuario"]);
                    strcpy(porta, json["porta"]);
                    strcpy(senha, json["senha"]);

                    if (json["ip"])
                    {
                        Serial.println("setting custom ip from config");
                        // static_ip = json["ip"];
                        strcpy(static_ip, json["ip"]);
                        strcpy(static_gw, json["gateway"]);
                        strcpy(static_sn, json["subnet"]);
                        // strcat(static_ip, json["ip"]);
                        // static_gw = json["gateway"];
                        // static_sn = json["subnet"];
                        Serial.println(static_ip);
                        /*Serial.println("converting ip");
                          IPAddress ip = ipFromCharArray(static_ip);
                          Serial.println(ip);*/
                    }
                    else
                    {
                        Serial.println("no custom ip in config");
                    }
                }
                else
                {
                    Serial.println("failed to load json config");
                }
            }
        }
    }
    else
    {
        Serial.println("failed to mount FS");
    }
    // end read
    Serial.println(static_ip);
    Serial.println(porta);
    // printf("Sum = %d\n", sum );
    Serial.println(usuario);
    Serial.println(senha);

    // The extra parameters to be configured (can be either global or just in the setup)
    // After connecting, parameter.getValue() will get you the configured value
    // id/name placeholder/prompt default length

    WiFiManagerParameter custom_usuario("usuario", "usuario", usuario, 40);
    WiFiManagerParameter custom_porta("porta", "porta", porta, 5);
    WiFiManagerParameter custom_senha("senha", "senha", senha, 34);

    // WiFiManager
    // Local intialization. Once its business is done, there is no need to keep it around
    WiFiManager wifiManager;

    // set config save notify callback
    wifiManager.setSaveConfigCallback(saveConfigCallback);

    // set static ip
    IPAddress _ip, _gw, _sn;
    _ip.fromString(static_ip);
    _gw.fromString(static_gw);
    _sn.fromString(static_sn);

    wifiManager.setSTAStaticIPConfig(_ip, _gw, _sn);

    // add all your parameters here
    //-------------------------------------------parametros------------------------------------
    wifiManager.addParameter(&custom_usuario);
    wifiManager.addParameter(&custom_senha);
    wifiManager.addParameter(&custom_porta);
    //-------------------------------------------parametros------------------------------------

    // reset settings - for testing
    // wifiManager.resetSettings();

    // set minimu quality of signal so it ignores AP's under that quality
    // defaults to 8%
    wifiManager.setMinimumSignalQuality();

    // sets timeout until configuration portal gets turned off
    // useful to make it all retry or go to sleep
    // in seconds
    // wifiManager.setTimeout(120);

    // fetches ssid and pass and tries to connect
    // if it does not connect it starts an access point with the specified name
    // here  "AutoConnectAP"
    // and goes into a blocking loop awaiting configuration
    if (!wifiManager.autoConnect("AutoConnectAP", "password"))
    {
        Serial.println("failed to connect and hit timeout");
        delay(3000);
        // reset and try again, or maybe put it to deep sleep
        ESP.reset();
        delay(5000);
    }

    // if you get here you have connected to the WiFi
    Serial.println("connected...yeey :)");

    // read updated parameters
    strcpy(usuario, custom_usuario.getValue());
    strcpy(porta, custom_porta.getValue());
    strcpy(senha, custom_senha.getValue());

    // save the custom parameters to FS
    if (shouldSaveConfig)
    {
        Serial.println("saving config");
        DynamicJsonBuffer jsonBuffer;
        JsonObject &json = jsonBuffer.createObject();
        json["usuario"] = usuario;
        json["porta"] = porta;
        json["senha"] = senha;
        // json["porta"] = porta;

        json["ip"] = WiFi.localIP().toString();
        json["gateway"] = WiFi.gatewayIP().toString();
        json["subnet"] = WiFi.subnetMask().toString();

        File configFile = SPIFFS.open("/config.json", "w");
        if (!configFile)
        {
            Serial.println("failed to open config file for writing");
        }

        json.prettyPrintTo(Serial);
        json.printTo(configFile);
        configFile.close();
        // end save
    }

    Serial.println("local ip");
    Serial.println(WiFi.localIP());
    Serial.println(WiFi.gatewayIP());
    Serial.println(WiFi.subnetMask());
    InicializaServicoAtualizacao();
    //////////---------------inicioSimplesAutenticaçâo-------------------///////////
    server.on("/", handleRoot);
    // server.on("/config", configuracao);
    server.on("/login", handleLogin);
    server.on("/Pagina_pulica", publicHtml);
    server.on("/inline", []()
              { server.send(200, "text/plain", "Pagina Publica"); });

    server.onNotFound(handleNotFound);
    // here the list of headers to be recorded
    const char *headerkeys[] = {"User-Agent", "Cookie"};
    size_t headerkeyssize = sizeof(headerkeys) / sizeof(char *);
    // ask server to track these headers
    server.collectHeaders(headerkeys, headerkeyssize);
    server.begin();
    // start webSocket server
    webSocket.begin();
    webSocket.onEvent(webSocketEvent);
    Serial.println("HTTP server iniciado");
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    pinMode(butEnt1, INPUT);
    pinMode(butEnt2, INPUT);
    pinMode(butC, INPUT);
    pinMode(fotE, OUTPUT);   // Configura saída para fotE
    pinMode(fotS, OUTPUT);   // Configura saída para fotS
    digitalWrite(fotE, LOW); // fotE  inicia ON
    digitalWrite(fotS, LOW); // fotS  inicia ON

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    disp.begin();
    // disp.init();                                           // initialize the lcd
    // Print a message to the LCD.
    disp.backlight();
    disp.setCursor(0, 0); // Posiciona cursor na coluna 1, linha 1
    disp.print("Controle EST WEB");
    disp.setCursor(0, 1);
    disp.print("V 1.5 Acesso WEB");
    delay(3000);
    disp.setCursor(0, 0); // Posiciona cursor na coluna 1, linha 1
    disp.print(" Servidor no IP ");
    disp.setCursor(0, 1);
    disp.print("                ");
    disp.setCursor(0, 1);
    disp.print(WiFi.localIP());
    delay(3000);
    disp.setCursor(0, 1);
    disp.print(" Porta Web:9000 ");
    delay(3000);
    disp.setCursor(0, 0); // Posiciona cursor na coluna 1, linha 1
    disp.print(" STE TECNOLOGIA  ");
    disp.setCursor(0, 1);
    disp.print("  SOLUCOES EM   ");
    delay(1500);
    disp.setCursor(0, 1);
    disp.print("   AUTOMACAO    ");
    delay(3000);
    disp.setCursor(0, 1);
    disp.print("   E ACESSOS    ");
    delay(3000);
    disp.setCursor(0, 1);
    disp.print("                ");
    disp.setCursor(0, 0);
    disp.print("                ");

    c_entr = 0x00;  // limpa flag c_ent
    c_said = 0x00;  // limpa flag c_tSai
    c_perm = 0x00;  // limpa flag c_perm
    c_entrM = 0x00; // limpa flag c_ent
    c_saidM = 0x00; // limpa flag c_tSai
    c_permM = 0x00; // limpa flag c_perm

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    disp.setCursor(0, 0);
    disp.print("EC");
    disp.print(c_entr);
    disp.setCursor(5, 0);
    disp.print("SC");
    disp.print(c_said);
    disp.setCursor(10, 0);
    disp.print("PC");
    disp.print(c_perm);

    disp.setCursor(0, 1);
    disp.print("EM");
    disp.print(c_entrM);
    disp.setCursor(5, 1);
    disp.print("SM");
    disp.print(c_saidM);
    disp.setCursor(10, 1);
    disp.print("PM");
    disp.print(c_permM);
    delay(3000);

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}

void loop()
{

    webSocket.loop();
    lerDados();
    server.handleClient();
}
