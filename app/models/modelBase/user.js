const connect = require('../../database/db')

/* async function connect() {
    if (global.connection && global.connection.state !== 'disconnected')
        return global.connection;

    const mysql = require("mysql2/promise");
    const connection = await mysql.createConnection(`mysql://${process.env.MYSQL_USER}:${process.env.MYSQL_PASSWORD}@${process.env.MYSQL_HOST}:${process.env.MYSQL_PORT}/${process.env.MYSQL_DB}`);
    console.log("Conectou no MySQL!");
    global.connection = connection;
    return connection;
} */

async function findUser(user) {
    const conn = await connect;
    const [rows] = await conn.query(`SELECT * FROM users WHERE user=? LIMIT 1`, [user]);
    if (rows.length > 0)
        return rows[0];
    else return null;
}

async function findUserById(id) {
    const conn = await connect;
    const [rows] = await conn.query(`SELECT * FROM users WHERE id=? LIMIT 1`, [id]);
    if (rows.length > 0)
        return rows[0];
    else return null;
}

async function allUser() {
    const conn = await connect;
    const [rows] = await conn.query(`SELECT * FROM users `);
    if (rows.length > 0)
        return rows[0];
    else return null;
}

  

module.exports = { findUser, findUserById, allUser }



