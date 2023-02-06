## TESTE TÉCNICO - PLANIUM


### Subindo o projeto

Voce deve adicionar ao seu hosts `/etc/hosts`

```
127.0.0.1       backend.com.br
127.0.0.1       frontend.com.br
```

Construa o projeto com os sequintes comandos.

Crie as variaveis de ambiente.

```sh
cp .env.example .env
```
```sh
cp ./app/.env.example ./app/.env
```

```sh
docker-compose up
```
Instalacao dos pacotes do PHP.
```sh
docker-compose run --rm composer install
```
Criacao do banco de dados.
```sh
docker-compose run --rm artisan migrate --seed
```
Instalacao dos pacotes do JS.
```sh
docker-compose run --rm node install
```
Subindo o servidor do front-end.
```sh
docker-compose run --rm node run build
```
### Arquivos

Os arquivos solicitados estao todos dentro da pasta `/app/storage/app/jsons`