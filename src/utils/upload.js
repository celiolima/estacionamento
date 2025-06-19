const fs = require('fs');
const path = require('path');

const dirUpload='./teste'

const contentString = 'testando codigo'

function jsonOut(name, data) {
let pathData = ;
    fs.writeFileSync(
        ,
        JSON.stringify(data));
    console.log(`arquivo ${pathData} salvo`);
}

jsonOut('arquivo2', contentString);
