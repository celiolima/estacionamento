const bcryptjs = require('bcryptjs')
const conexion = require('../database/db')
const { promisify } = require('util')
const { exit } = require('process')


exports.login = async (req, res) => {

    try {
        const user = req.body.user
        const pass = req.body.pass

        if (!user || !pass) {
            res.render('login', {
                alert: true,
                alertTitle: "Advertencia",
                alertMessage: "Insira Usuario e Senha",
                alertIcon: 'info',
                showConfirmButton: true,
                timer: false,
                ruta: 'login'
            })
        } else {

            conexion.query('SELECT * FROM users WHERE user = ?', [user], async (error, results) => {
                if (results.length == 0 || !(await bcryptjs.compare(pass, results[0].pass))) {
                    res.render('login', {
                        alert: true,
                        alertTitle: "Error",
                        alertMessage: "usuario ou senha incorretos",
                        alertIcon: 'error',
                        showConfirmButton: true,
                        timer: false,
                        ruta: 'login'
                    })
                } else {
                    //inicio de sesión OK
                    //res.send('AQUI INICIO')
                    console.log("INICIO: " + JSON.stringify(results) + " FIM ")
                    const id = results[0].id
                    const userSession = results[0]
                    req.session.user = userSession

                    if (req.session.user) {
                        //res.send('usuario' + req.session.useName.user + ' encontrado')                             

                        res.render('login', {
                            alert: true,
                            alertTitle: "Conexão com Sucesso",
                            alertMessage: "Seja Bem Vindo",
                            alertIcon: 'success',
                            showConfirmButton: false,
                            timer: 800,
                            ruta: ''
                        })
                    }
                }
                //conexion.destroy;
            })
        }
    } catch (error) {
        console.log(error)
    }
}

exports.logout = (req, res) => {
    req.session.destroy(function (err) {
        return res.redirect('/')
    })

}