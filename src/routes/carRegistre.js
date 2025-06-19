const express = require('express');
const router = express.Router();

//Invocamos a la conexion de la DB
const conexion = require('../database/db');
//Invocamos autenticação
const auth = require('../middleware/auth')

const usersControle = require('../controllers/users')


//ROTA PARA MOSTRAR TODOS LOS REGISTROS
router.get('/', (req, res) => {

    conexion.query('SELECT * FROM car', (error, results) => {
        let sentido = ""
        let total = results.length
        let dataAtual = ""
        let dia = ""
        let mes = ""
        let ano = ""
        let horas = ""
        let minutos = ""
        let segundos = ""
        let id = ""
        if (error) {
            throw error;
        } else {
            var locals = {
                title: 'Car Register',
                description: 'Page Description',
                header: 'Page Header',
            };
            let arrObjeto = []
            //for (let i = 0; i < size; i++) {
            results.forEach((e) => {
                id = e.id
                sentido = e.type
                type = e.type
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
                    data: `${dia}/0${mes}/${ano} ${horas}:${minutos}:${segundos}s`,
                    type: `${type}`

                })
            })
            res.render('carRegistre', { total: total, results: arrObjeto, sessionUser: req.session.user });
            // console.log({ results: results, locals })
        }
    })

    //res.send('user /')
})

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
                let total = results.length
                let dataAtual = ""
                let dia = ""
                let mes = ""
                let ano = ""
                let horas = ""
                let minutos = ""
                let segundos = ""
                let id = ""

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
                        //console.log("path2 ", path);

                        arrObjeto.push({
                            id: `${id}`,
                            name: `${sentido}${dia}/0${mes}/${ano} ${horas}:${minutos}:${segundos}s`,
                            data: `${dia}/0${mes}/${ano} ${horas}:${minutos}:${segundos}s`,
                            type: `${type}`

                        })
                    })

                    //console.log("name ", typeof arrObjeto);
                    console.log("Filtro ", arrObjeto);
                    // res.render('gallery', { sessionUser:req.cookies.session, nameVeic:arrObjeto}); 





                    //console.log('resultis: db ', { results: results })
                    res.send({ total: total, results: arrObjeto, sessionUser: req.session.user });
                    //console.log(`SELECT * FROM car WHERE created_at >='${dataInicial} ${horaInicial}' AND created_at <='${dataFinal} ${horaFinal}' `)
                }
            })
    }
})


//ROTA QUE ENTREGA A PAGINA DE REGISTRO DE USUARIO
router.get('/userRegister', (req, res) => {

    var locals = {
        title: 'Cadastro',
        description: 'Page Description',
        header: 'Page Header',
        pafh: '../'
    };
    res.render('userRegister', { sessionUser: req.session.user })
})
//ROTA PARA REGISTRA UM USUARIO
router.post('/userRegister', usersControle.register)

//ROTA PARA EDITAR UN REGISTRO SELECCIONADO
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


//ROTA PARA ELIMINAR UN REGISTRO SELECCIONADO
router.get('/delete/:id', (req, res) => {
    const id = req.params.id;
    conexion.query('DELETE FROM users WHERE id = ?', [id], (error, results) => {
        if (error) {
            console.log(error);
        } else {
            res.redirect('/users');
        }
    })
});


module.exports = router;

/* 

router.get('/dashboard', function(req, res) {
  var locals = {
    title: 'Page Title',
    description: 'Page Description',
    header: 'Page Header'
  };
  res.render('dashboard', locals);
});

router.get('/chat', function(req, res) {
  var locals = {
    title: 'Page Title',
    description: 'Page Description',
    header: 'Page Header'
  };
  res.render('chat', locals);
});
//ROTA para enviar los datos en formato json
router.get('/data', (req, res)=>{     
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
})
 */