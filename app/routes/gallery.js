const express = require('express');
const router = express.Router();

//Invocamos a la conexion de la DB
const conexion = require('../database/db');
//Invocamos autenticação
const auth = require('../middleware/auth')


//ENVIA DADOS DA CHAMADA GET PARA WIEW GALERY
router.get('/', auth.isAuthenticated, function (req, res) {
    conexion.query('SELECT * FROM car', (error, results) => {

        let sentido = ""
        let path = ""
        let dataAtual = ""
        let dia = ""
        let mes = ""
        let ano = ""
        let horas = ""
        let minutos = ""
        let segundos = ""
        let id = ""

        //console.log("size:", size);
        //console.log("results:", results);
        if (error) {
            throw error;
        } else {

            var locals = {
                title: 'User',
                description: 'Page Description',
                header: 'Page Header'
            };

            let arrObjeto = []
            //for (let i = 0; i < size; i++) {
            results.forEach((e) => {
                id = e.id
                sentido = e.type
                path = e.dirImage
                dataAtual = new Date(e.created_at);
                dia = dataAtual.getDate();
                mes = (dataAtual.getMonth() + 1);
                ano = dataAtual.getFullYear();
                horas = dataAtual.getHours();
                minutos = dataAtual.getMinutes();
                segundos = dataAtual.getSeconds();
                // console.log("path2 ", path);

                arrObjeto.push({
                    id: `${id}`,
                    name: `${sentido}${dia}/0${mes}/${ano} ${horas}:${minutos}:${segundos}s`,
                    dirImage: `${path}`

                })
            })

            //console.log("name ", typeof arrObjeto);
            //console.log("name2 ", arrObjeto);  
            res.render('gallery', { sessionUser: req.session.user, nameVeic: arrObjeto });

        }
    })

});

//ENVIA DADOS DA CHAMADA POST FILTRADAS PARA WIEW GALERY
router.post('/', auth.isAuthenticated, (req, res) => {

    const dataInicial = req.body.date_sel_start;
    const dataFinal = req.body.date_sel_end;
    const horaInicial = req.body.time_sel_start;
    const horaFinal = req.body.time_sel_end;
    console.log('reqBody:', dataInicial, dataFinal, horaInicial, horaFinal)
    /* SELECT * FROM car
    WHERE created_at >= '2023-07-08 14:48:08 ' 
    AND   created_at <= '2023-07-08 21:22:50 ' */

    if (dataInicial == '' || dataFinal == '' || horaInicial == '' || horaFinal == '') {
        console.log('resultis: Vasio')
        //res.send('dados vasio');
    } else {
        conexion.query(`SELECT * FROM car WHERE created_at >='${dataInicial} ${horaInicial}' AND created_at <='${dataFinal} ${horaFinal}' `
            //conexion.query(`SELECT * FROM car  `
            , async (error, results) => {
                let sentido = ""
                let path = ""
                let dataAtual = ""
                let dia = ""
                let mes = ""
                let ano = ""
                let horas = ""
                let minutos = ""
                let segundos = ""
                let name = ""
                let size = results.length
                let id = ""
                let nameArquivo = ""
                if (error) {
                    throw error;
                } else {
                    let arrObjeto = []
                    //for (let i = 0; i < size; i++) {
                    results.forEach((e) => {
                        id = e.id
                        sentido = e.type
                        path = e.dirImage
                        dataAtual = new Date(e.created_at);
                        dia = dataAtual.getDate();
                        mes = (dataAtual.getMonth() + 1);
                        ano = dataAtual.getFullYear();
                        horas = dataAtual.getHours();
                        minutos = dataAtual.getMinutes();
                        segundos = dataAtual.getSeconds();

                        if (e.name.substr(0, 5) == "Saida") {
                            console.log("saida ");
                            console.log("nome arquivos ", e.name.substr(6, 24));
                            console.log("nome arquivos ", e.name);
                            nameArquivo = e.name.substr(6, 24);

                        } else {

                            console.log("entrada ");
                            console.log("nome arquivos ", e.name.substr(8, 24));
                            console.log("nome arquivos ", e.name);
                            nameArquivo = e.name.substr(8, 24);
                        }


                        //Entrada car1689962534973


                        arrObjeto.push({
                            id: `${id}`,
                            name: `${sentido}${dia}/0${mes}/${ano} ${horas}:${minutos}:${segundos}s`,
                            dirImage: `${path}`,
                            nameArquivo: `${nameArquivo}`

                        })
                    })

                    //console.log("name ", typeof arrObjeto);
                    console.log("Filtro ", arrObjeto);
                    // res.render('gallery', { sessionUser:req.cookies.session, nameVeic:arrObjeto}); 





                    //console.log('resultis: db ', { results: results })
                    res.send({ results: arrObjeto, sessionUser: req.cookies.session });
                    //console.log(`SELECT * FROM car WHERE created_at >='${dataInicial} ${horaInicial}' AND created_at <='${dataFinal} ${horaFinal}' `)
                }
            })
    }
})


//RUTA PARA ELIMINAR UN REGISTRO SELECCIONADO NO FILTRO
router.get('/delete/:id', auth.isAuthenticated, (req, res) => {
    const id = req.params.id;
    conexion.query('DELETE FROM car WHERE id = ?', [id], (error, results) => {
        if (error) {
            console.log(error);
        } else {
            res.redirect('/gallery');
        }
    })
})





//ruta para enviar los datos en formato json
/* router.get('/data', (req, res)=>{     
    conexion.query('SELECT * FROM users',(error, results)=>{
        if(error){
            throw error;
        } else {                                                   
            data = JSON.stringify(results);
            res.send(data); 
            //res.render('users.ejs', data);
            console.log(data)
        }   
    })
}) */

//RUTA PARA EDITAR UN REGISTRO SELECCIONADO
router.get('/edit/:id', (req, res) => {
    const id = req.params.id;
    conexion.query('SELECT * FROM users WHERE id=?', [id], (error, results) => {
        if (error) {
            throw error;
        } else {
            res.render('edit.ejs', { user: results[0] });
        }
    });
});






module.exports = router;