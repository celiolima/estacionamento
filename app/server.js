const fs = require('fs');
const http = require('http');
//const https = require('https');
const express = require('express')
const dotenv = require('dotenv')
const path = require('path');
var session = require('express-session')


// atribuindo as rotas nas variaveis
const indexRouter = require('./routes/index');
const usersRouter = require('./routes/users');
const loginRouter = require('./routes/login');
const gallryRouter = require('./routes/gallery');
const carRouter = require('./routes/car');
const carRegistreRouter = require('./routes/carRegistre');

//##verificar
const { render } = require('ejs');
const app = express()

// Load SSL certificate and key
/* const options = {
    key: fs.readFileSync('./certs/key.pem'),
    cert: fs.readFileSync('./certs/cert.pem')
    // ca: fs.readFileSync('/path/to/your/ca_bundle.crt') // Optional: for CA chain
}; */

// Create HTTPS server
//const server = https.createServer(options, app);

//seteamos el motor de plantillas
app.set('view engine', 'ejs')
app.set('views', './views');
//seteamos la carpeta public para archivos estáticos
//app.use('/static', express.static(__dirname + '/public'));
app.use(express.static(__dirname + '/public'));
//app.use(express.static('public'))

//para procesar datos enviados desde forms
app.use(express.urlencoded({ extended: true }))
app.use(express.json())

//seteamos las variables de entorno
dotenv.config({ path: './.env' })

//para poder trabajar con las cookies
//app.use(cookieParser())

//setando session
app.use(session({
    secret: 'keyboard cat',
    resave: false,
    saveUninitialized: false,
    cookie: { maxAge: 3600000 }      // Tempo de expiração do cookie (1 hora)
    //cookie: { secure: true }
}))

//Rotas 
app.use('/', indexRouter);
app.use('/login', loginRouter);
app.use('/users', usersRouter);
app.use('/gallery', gallryRouter);
app.use('/car', carRouter);
app.use('/carRegistre', carRegistreRouter);

//Para eliminar la cache 
app.use(function (req, res, next) {
    if (!req.user)
        res.header('Cache-Control', 'private, no-cache, no-store, must-revalidate');
    next();
});


//const appWs = require('./bin/app-ws');

app.listen(process.env.PORT_SERVER || 3000, () => {
    console.log(`SERVER corriendo en http://localhost:${process.env.PORT_SERVER}`);
})

/* server.listen(process.env.PORT_SERVER || 3000, () => {
    console.log(`SERVER corriendo en http://localhost:${process.env.PORT_SERVER}`);
}); */

//appWs(server);