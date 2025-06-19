FROM node:23.8-slim AS build

#cria diretorio /app
WORKDIR /app

#copia todos aquivos iniciando por package e terminamdo em .json e na pasta app para o diretorio criado
COPY package*.json ./

#instala as dependecias
RUN npm install 

#faz o bild da imagem
COPY . .

EXPOSE 3000
CMD ["npm" ,"start"]
