FROM node:22

# We have to install nodemon globally before moving into the working directory
RUN npm install -g nodemon

#cria diretorio /app
WORKDIR /usr/src/app

#copia todos aquivos iniciando por package e terminamdo em .json e na pasta app para o diretorio criado
COPY package*.json ./

#instala as dependecias
RUN npm install 

#faz o bild da imagem
COPY . .

EXPOSE 3000
#CMD ["node", "app.js"]
#CMD ./start.sh
