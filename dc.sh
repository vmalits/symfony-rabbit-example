#!/bin/bash
# Script runs commands inside php docker container

if [ $# -gt 0 ]; then
    # Script has arguments, pass them to the command
    # shellcheck disable=SC2068
    docker-compose exec --user www-data php-fpm $@
else
    # No arguments passed, execute bash command
    docker-compose exec --user www-data php-fpm bash
fi