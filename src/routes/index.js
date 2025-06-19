const express = require('express')
const router = express.Router()

//usando conexão com o DB
const conexion = require('../database/db');

const auth = require('../middleware/auth')

//ROTA RAIZ

router.get('/', auth.isAuthenticated, (req, res) => {
    //res.send('deu certo')
    let dadosPainel;
    const id = 1;
    conexion.query('SELECT * FROM veic WHERE id=?', [id], (error, results) => {
        if (error) {
            throw error;
            conexion.destroy();
        } else {

            dadosPainel = results[0];
            console.log("dadosPainel:", dadosPainel)
            res.render('index', { user: req.user, sessionUser: req.session.user, dados: dadosPainel })
        }
    });
})
module.exports = router