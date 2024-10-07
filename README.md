This repository is used to practice [Symfony](https://en.wikipedia.org/wiki/Symfony) and [Domain-driven design](https://en.wikipedia.org/wiki/Domain-driven_design). Commit messages will have detailed description which commands, documentation and other resources were used along the way. The goal is to have information on *why* and *how* in addition to *what* has changed. [`git blame`](https://www.atlassian.com/git/tutorials/inspecting-a-repository/git-blame) and `git log` can be used to follow along, Commit Driven Learning (CDL) 🤯.

# Requirements

    - [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)

> [!NOTE]
> The project is developed on [Debian 12](https://www.debian.org/) if you use another OS have that in mind if something doesn't work as expected.

# Install Symfony

After cloning current repository to build Docker images in the project root execute:

    docker compose build --pull --no-cache

To install Symfony:

    docker compose up --pull always --detach --wait

# Usage

After installation app should be available at [localhost](http://localhost/).

### Start Docker containers

    docker compose up --detach

### Stop Docker containers

    docker compose down --remove-orphans

### Rebuild Docker environment

    docker compose down --remove-orphans && docker compose build --pull --no-cache

# Debugging

- [Debugging with Xdebug and PHPStorm](https://github.com/dunglas/symfony-docker/blob/6b37be14c98583e202cbbdec380c6e9e3103d2ab/docs/xdebug.md#debugging-with-xdebug-and-phpstorm)
- [PhpStorm ❤ Docker](https://medium.com/the-sensiolabs-tech-blog/phpstorm-docker-ccc4ce9a0b8e)

# Troubleshooting

### Permissions outside container

On GNU/Linux after installation `git diff` will complain `...Not a git repository...`, because files created inside container will have ownership set to `root` user, to fix that we need to set ownership to the current user outside container with command:

    docker compose run --rm php chown -R $(id -u):$(id -g) .

as explained [here](https://github.com/dunglas/symfony-docker/blob/6b37be14c98583e202cbbdec380c6e9e3103d2ab/docs/troubleshooting.md#editing-permissions-on-linux).

# Acknowledgements

Everything here is heavily influenced by these great projects:

- [Symfony: The Fast Track](https://symfony.com/book)
- [Symfony Documentation](https://symfony.com/doc/current/index.html)
- [Symfony Docker](https://github.com/dunglas/symfony-docker)

Big thank you for all the ~~fish~~ lessons goes to them. 🙏

🐬
