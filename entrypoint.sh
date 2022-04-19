docker exec -it 763710bc714fa6e6e081d2eeff8f58b602f0089d9eced365272daaa7c17
1f0ef /bin/sh#!/bin/sh

if [ "$SECRET_ENV_FILE" ]; then
    ln -s "/run/secrets/$SECRET_ENV_FILE" /var/www/.env
fi

# This will exec the CMD from your Dockerfile
exec "$@"
