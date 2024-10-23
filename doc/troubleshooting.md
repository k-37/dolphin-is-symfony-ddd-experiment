# Permissions outside container

As explained [here](https://github.com/dunglas/symfony-docker/blob/6b37be14c98583e202cbbdec380c6e9e3103d2ab/docs/troubleshooting.md#editing-permissions-on-linux), on GNU/Linux after installing Symfony `git diff` will complain `...Not a git repository...`, because files created inside container will have ownership set to `root` user, to fix that we need to set ownership to the current user outside the container with command:

    docker compose run --rm php chown -R $(id -u):$(id -g) .

or:

    make ownership
