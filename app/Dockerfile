# Use a imagem base do Node.js
FROM node:18

# Defina o diretório de trabalho dentro do contêiner
WORKDIR /app

COPY . .

RUN npm install -g @quasar/cli

RUN npm install

EXPOSE 9000

CMD ["quasar", "dev"]
