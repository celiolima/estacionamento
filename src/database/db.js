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
        console.log('El error de conexión es: ' + error)
        return
    }
    console.log('¡Conectado a la base de datos MySQL!')
})

module.exports = conexion