const express = require('express')
const router = express.Router()

const loginControle = require('../controllers/login')

//ROTA LOGIN
router.get('/', (req, res)=>{
    res.render('login', {alert:false})
})
router.post('/', loginControle.login)
router.get('/logout', loginControle.logout)

module.exports = router