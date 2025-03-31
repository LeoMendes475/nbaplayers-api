# 📌 Projeto Laravel com Docker

Este projeto utiliza **Docker** para rodar um ambiente Laravel de forma rápida e isolada. O ambiente contém:

-   **PHP 8.x**
-   **MySQL**
-   **NGINX**
-   **Redis** (Opcional)
-   **Adminer** (Opcional)

---

## 🚀 Como rodar o projeto com Docker

### 🔹 1. Clone o repositório

```sh
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

### 🔹 2. Copie o arquivo `.env.example` para `.env`

```sh
cp .env.example .env
```

### 🔹 3. Configure as variáveis de ambiente no `.env`

Edite o arquivo `.env` e configure as conexões do banco de dados:

```ini
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```

---

## 🛠️ Configurando o Docker

### 🔹 4. Instale o **Docker** e **Docker Compose**

Se ainda não tiver instalado, siga as instruções:

-   [Instalar Docker](https://docs.docker.com/get-docker/)
-   [Instalar Docker Compose](https://docs.docker.com/compose/install/)

### 🔹 5. Suba os containers

```sh
docker-compose up -d
```

Isso criará os containers do **Laravel, MySQL e NGINX**.

---

## ⚙️ Rodando o Laravel dentro do container

### 🔹 6. Acesse o container do Laravel

```sh
docker exec -it laravel-app bash
```

### 🔹 7. Instale as dependências do Laravel

```sh
composer install
```

### 🔹 8. Gere a chave da aplicação

```sh
php artisan key:generate
```

### 🔹 9. Execute as migrações do banco de dados

```sh
php artisan migrate --seed
```

---

## ✅ Testando a aplicação

Agora, acesse a aplicação no navegador:

```sh
http://localhost
```

Se precisar testar o banco de dados via **Adminer** (opcional), acesse:

```sh
http://localhost:80
```

### 🔹 10. Logs e depuração

Para visualizar os logs do Laravel dentro do container:

```sh
docker logs -f laravel-app
```

---

## 🛑 Parando e removendo os containers

Para parar os containers, execute:

```sh
docker-compose down
```

Se quiser remover volumes também:

```sh
docker-compose down -v
```

---

## 🎯 Estrutura do Docker Compose

O **docker-compose.yml** utilizado neste projeto pode ser semelhante a este:

```yaml
version: "3.8"

services:
    app:
        build:
            context: .
            dockerfile: Dockerfile
        image: laravel-app
        container_name: nbaplayers-api
        restart: unless-stopped
        working_dir: /var/www
        volumes:
            - .:/var/www
        ports:
            - "9000:9000"

    web:
        image: nginx:stable-alpine
        container_name: nginx
        restart: unless-stopped
        ports:
            - "80:80"
        volumes:
            - .:/var/www
            - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
        depends_on:
            - app
```

---

## 🔗 Repositório do Postman

Adicione aqui o link para os repositórios do Postman com as requisições da API.

undefined/workspace/nbaplayers/collection/27038375-b8b96ef7-0f74-4536-8e7b-4c577b4f5ad0?action=share&creator=27038375&active-environment=27038375-e3d561ca-0716-4869-bbfa-21ea7cbcbee3
