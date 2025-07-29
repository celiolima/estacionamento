
const WebSocket = require('ws');

//usando conexão com o DB
//const conexion = require('../database/db');
const mysql = require('mysql2')

const conexion = mysql.createConnection({
    host: 'mysql', /* process.env.DB_HOST, */
    user: 'root', /* process.env.DB_USER, */
    password: 'root', /*  process.env.DB_PASS, */
    database: 'estacionamentojn' /* process.env.DB_DATABASE, */
    // //user: 'stesiste_fb_root', /* process.env.DB_USER, */
    // password: 'jbestacionamento@123', /*  process.env.DB_PASS, */
    // database: 'stesiste_jbestacionamento' /* process.env.DB_DATABASE, */
})

conexion.connect((error) => {
    if (error) {
        console.log('erro de conexão ws: ' + error)
        return
    }
    console.log('WS conectado no banco!')
})


const wss = new WebSocket.Server({ port: 3001 });
let sockets = [];
wss.on('connection', ws => {
    //sockets.push(ws); 
    //console.log(`sockets : ${sockets}`);
    ws.on('message', function message(data) {
        if (data == 'teste') {
            conexion.query('SELECT * FROM veic ', (error, results) => {
                if (error) {
                    throw error;
                } else {
                    console.log('result teste:', results[0])
                    //res.render('edit.ejs', {user:results[0]});                   

                }

            });
            console.log('deu certo')

        }
        //console.log(`Received message ${data} from user ${client}`);
        console.log(`Received message ${data} `);
        let flagfoto;
        let foto;
        let tex;
        let buffer = Buffer.from(data);                          //usando o buffer do nodeJS
        let arraybuffer = Uint8Array.from(buffer).buffer;        //convertendo o buffer em um arreybuffer
        var uint8 = new Uint8Array(arraybuffer.slice(12, 13));   //convertendo o arreybuffer em um arrey unit8
        var currentCam = uint8[0];
        //console.log("current Cam: ", currentCam);
        if (currentCam == '1' || currentCam == '2') {
            console.log("current Cam: é foto. ");
            flagfoto = true;
            foto = data;
            var bitmap = new Buffer.from(data, 'base64');
            let created_at = Date.now().toString();
            //let created_at = Date.now();
            //console.log('data:',created_at.to)
            let pafhImage = 'uploads/car/car' + created_at + '.jpg';
            //let pafhImage = dirImage.toString
            let uploadsPath = path.resolve(__dirname, `./public/${pafhImage}`);

            //#################-enviando foto para pasta local-###################//                
            fs.writeFileSync(uploadsPath, bitmap, 'binary', function (err) {
                if (err) {
                    console.log('Conversao com erro');
                }
            });
            //console.log(`foto enviada para ${uploadsPath} com sucesso.`);

            //#################-Verificando de é entrada ou saida -###################// 
            console.log('Conferindo CurrentCam =', currentCam);
            let type = '';
            if (currentCam == '1') {
                type = 'Entrada ';
                console.log('Entrada');
            } else if (currentCam == '2') {
                type = 'Saida ';
                console.log('Saida');
            }
            let name = type + 'car' + created_at;
            let parfirImage = pafhImage;

            //#################-enviando foto para pasta o banco-###################// 

            conexion.query('INSERT INTO car SET ?', { name: name, dirImage: parfirImage, type: type }, (error, results) => {
                if (error) { console.log(error) }
                console.log(`${pafhImage} enviado ao banco com sucesso`)
            })
        } else {
            console.log("current Cam: é texto. ");
            flagfoto = false;
            //tex = new Uint8Array(arraybuffer);
            tex = data.toString();
            console.log(`Texto: ${tex} enviado com sucesso`);
            if (tex == 'WEB_CLIENT') {
                sockets.push(ws);
                console.log(`sockets : ${sockets}`);
            } else {
                let texjson = tex.slice(0, 1);
                if (texjson == "{") {

                    const id = 1;
                    conexion.query('SELECT * FROM veic WHERE id=?', [id], (error, results) => {
                        if (error) {
                            throw error;
                        } else {
                            //console.log('result:', results[0])
                            //res.render('edit.ejs', {user:results[0]});
                            let total_car_mes = results[0].total_car_mes;
                            let total_car = results[0].total_car;
                            let total_mot_mes = results[0].total_mot_mes;
                            let total_mot = results[0].total_mot;
                            let created_at = results[0].created_at;

                            //let created_at = "2020-12-31";                          
                            let mes_query = new Date(created_at).getMonth();
                            let mes_atual = new Date().getMonth();
                            console.log('mes_query:', mes_query)
                            console.log('mes_atual:', mes_atual)
                            if (mes_query = !mes_atual) {
                                total_car_mes = 0;
                                total_mot_mes = 0;
                            }
                            //console.log(tex.slice(0,1))
                            //UPDATE `estacionamentojn`.`veic` SET `total_mot`='1' WHERE  `id`=1;
                            //console.log('texto:', JSON.parse(tex).pcarro)

                            if (JSON.parse(tex).ecarro) { total_car_mes++; total_car++; }
                            if (JSON.parse(tex).emoto) { total_mot_mes++; total_mot++; }

                            conexion.query(`UPDATE  veic SET total_car_mes = ${total_car_mes}, total_car = ${total_car},total_mot_mes = ${total_mot_mes},total_mot = ${total_mot} WHERE id=1`, (error, results) => {
                                if (error) {
                                    throw error;
                                } else {
                                    console.log('Suceces:UPDATE realizado com sucesso')
                                }
                            });
                            let msg = `{"painel": [{"total_car_mes": "${total_car_mes}","total_car": "${total_car}", "total_mot_mes": "${total_mot_mes}","total_mot":" ${total_mot}" }]}`;
                            console.log(msg);
                            sockets.forEach(s => s.send(msg))
                            //{"devices":[{"emoto":"0","smoto":"0","pmoto":"0","ecarro":"1","scarro":"0","pcarro":"1"}]}

                        }

                    });
                }
                //var res = JSON.parse(message.data); 
                // exampleSocket.send(JSON.stringify(msg));
                //sockets.forEach(s => s.send(""))
            }
        }

        //#################-enviando data para clienets se foto ou se texto-###################//            
        wss.clients.forEach(function each(client) {

            if (client !== ws && client.readyState === WebSocket.OPEN) {
                if (!flagfoto) {

                    client.send(tex);
                    //console.log('texto:', tex)
                } else {
                    //client.send( foto, { binary: isBinary });
                    sockets.forEach(s => s.send(foto))
                    //client.send(foto);
                }
            }
        });

        /*  if (typeof (data) == 'object') {
             console.log('object:', data)            
         }
         if (typeof (data) == 'tex') {
             console.log('texto:', data)
         } */
    });
    ws.on('close', () => console.log('Client disconnected.'));
    ws.on('error', console.error);
});





