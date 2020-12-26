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
$ docker-compose up -d 
```

```
$ ./dc.sh composer install
```

#### Project is running at `http://localhost`