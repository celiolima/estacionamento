const bcryptjs = require('bcryptjs')
const conexion = require('../database/db')
const { promisify } = require('util')


exports.isAuthenticated = async (req, res, next) => {
    //res.send('deu certo')

    if (req.session.user) {
        //res.send(req.session.user)
        try {
            conexion.query('SELECT * FROM users WHERE id = ?', [req.session.user.id], (error, results) => {
                if (!results) { return next() }
                req.user = results[0]
                return next()
            })
        } catch (error) {
            console.log(error)
            return next()
        }
    } else {
        res.redirect('/login')
    }
}

