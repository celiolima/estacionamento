const bcryptjs = require('bcryptjs')
const conexion = require('../database/db')
const { promisify } = require('util')

//procedimiento para registrarnos
exports.register = async (req, res) => {
    try {
        const name = req.body.name
        const user = req.body.user
        const pass = req.body.pass
        const email = req.body.email
        const rol = req.body.rol
        let passHash = await bcryptjs.hash(pass, 8)
        //console.log(passHash)   
        conexion.query('INSERT INTO users SET ?', { user: user, name: name, pass: passHash, email: email, rol: rol }, (error, results) => {
            if (error) { console.log(error) }
            res.redirect('/users')
        })
    } catch (error) {
        console.log(error)
    }
}

