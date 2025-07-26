const bcryptjs = require('bcryptjs')
const conexion = require('../database/db')



exports.login = (req, res) => {

    const user = req.body.user
    const pass = req.body.pass
    if (!user) {
        res.render('login', {
            alert: true,
            alertTitle: "Advertencia",
            alertMessage: "Insira Usuario",
            alertIcon: 'info',
            showConfirmButton: true,
            timer: false,
            ruta: 'login'
        })
    } else if (!pass) {
        res.render('login', {
            alert: true,
            alertTitle: "Advertencia",
            alertMessage: "Insira Senha",
            alertIcon: 'info',
            showConfirmButton: true,
            timer: false,
            ruta: 'login'
        })

    } else if (!user && !pass) {
        res.render('login', {
            alert: true,
            alertTitle: "Advertencia",
            alertMessage: "Insira usuario e Senha",
            alertIcon: 'info',
            showConfirmButton: true,
            timer: false,
            ruta: 'login'
        })

    } else {

        conexion.query("SELECT * FROM users WHERE user =" + user, (err, results, fields) => {

            if (err) throw err;
            if (!results || !(bcryptjs.compare(pass, results[0].pass))) {
                console.log("usuario INICIO: " + user + " FIM ");
                console.log("RESULT INICIO: " + JSON.stringify(results) + " FIM ");
                console.log("ERRO INICIO: " + JSON.stringify(results) + " FIM ");

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
            // Close the connection with a callback
            connection.end((endErr) => {
                if (endErr) {
                    console.error('Error closing connection:', endErr);
                    return;
                }
                console.log('MySQL connection closed.');
            });
        })

    }
}

exports.logout = (req, res) => {
    req.session.destroy(function (err) {
        return res.redirect('/')
    })

}