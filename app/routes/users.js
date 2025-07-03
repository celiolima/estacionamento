const express = require('express');
const router = express.Router();

//Invocamos a la conexion de la DB
const conexion = require('../database/db');
//Invocamos autenticação
const auth = require('../middleware/auth')

const usersControle = require('../controllers/users')


//ROTA PARA MOSTRAR TODOS LOS REGISTROS
router.get('/', (req, res) => {

    conexion.query('SELECT * FROM users', (error, results) => {
        if (error) {
            throw error;
        } else {
            var locals = {
                title: 'User',
                description: 'Page Description',
                header: 'Page Header',
            };
            res.render('users.ejs', { results: results, sessionUser: req.session.user });
            // console.log({ results: results, locals })
        }
    })

    //res.send('user /')
})

//ROTA QUE ENTREGA A PAGINA DE REGISTRO DE USUARIO
router.get('/userRegister', (req, res) => {

    var locals = {
        title: 'Cadastro',
        description: 'Page Description',
        header: 'Page Header',
        pafh: '../'
    };
    res.render('userRegister', { sessionUser: req.cookies.session })
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