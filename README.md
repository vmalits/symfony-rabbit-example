#  An example of Symfony working with rabbitmq

## Usage

```
$ git clone https://github.com/vmalits/symfony-rabbit-example.git
```

```
$ cd symfony-rabbit-example
```

```
$ cp .env .env.local
```

```
$ git submodule update --init --recursive
```

```
$ cp .env-laradock laradock/.env
```

```
$ cd laradock
```

```
$ docker-compose up -d nginx mysql rabbitmq workspace
```

```
$ docker exec workspace bash composer install
```

#### Project is running at `http://localhost`