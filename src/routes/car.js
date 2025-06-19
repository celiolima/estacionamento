const express = require('express')
const router = express.Router()

//Invocamos a la conexion de la DB
const conexion = require('../database/db');
//Invocamos autenticação
const auth = require('../middleware/auth')



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
                if (error) {
                    throw error;
                } else {
                    console.log('resultis: db ', { results: results })
                    res.send({ results: results, sessionUser: req.session.user });
                    //console.log(`SELECT * FROM car WHERE created_at >='${dataInicial} ${horaInicial}' AND created_at <='${dataFinal} ${horaFinal}' `)
                }
            })
    }
})


module.exports = router