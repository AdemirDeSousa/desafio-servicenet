# Laravel Opportunities

# Tecnologias Utilizadas

- Php
- Laravel
- React
- Next
- Mysql
- Docker

# Requisitos

- Php 8
- Composer
- Node v16
- Docker

# Instalação back-end

- Acessar a pasta do back-end
- No Terminal rodar o comando:

```sh
composer install --ignore-platform-reqs
```

- Apos instalar as dependencias utilizaremos o Laravel Sail (uma interface de linha de comando para o Docker)
- Verifique se a env esta configurada pois o Sail builda o container utilizando as variaveis da env (vou estar subindo a env com uma configuração padrao para facilitar o setup)
- No Terminal rodar o comando:

```sh
./vendor/bin/sail up -d
```

- Acessar o bash do container:

```sh
./vendor/bin/sail exec laravel.test bash
```

- Para garantir que as dependencias estejam atualizadas de acordo com o container eu gosto de rodar o comando de instalação das dependencias dentro do container sem a necessidade do --ignore-platform-reqs

```sh
composer install
```

ou

```sh
composer update
```

- Apos finalizar a instalação, rodar o comando de criação das tabelas do banco junto com as seeds

```sh
php artisan migrate --seed
```

- Pronto, seu back-end esta configurado e rodando.

- Para executar os testes rode o comando:

```sh
php artisan test
```

ou, caso esteja fora do bash do container

```sh
./vendor/bin/sail php artisan test
```

# Instalação front-end

- Instalar os pacotes do node

```sh
npm install
```

- Inicializar o servidor

```sh
npm run dev
```
