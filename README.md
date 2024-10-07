This repository is used to practice [Symfony](https://en.wikipedia.org/wiki/Symfony) and [Domain-driven design](https://en.wikipedia.org/wiki/Domain-driven_design). Commit messages will have detailed description which commands, documentation and other resources were used along the way. The goal is to have information on *why* and *how* in addition to *what* has changed. [`git blame`](https://www.atlassian.com/git/tutorials/inspecting-a-repository/git-blame) and `git log` can be used to follow along, Commit Driven Learning (CDL) 🤯.

# Requirements

    - [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
    - If you are using Windows, you have to install [chocolatey.org](https://chocolatey.org/) or [Cygwin](http://cygwin.com) to use the `make` command. Check out this [StackOverflow question](https://stackoverflow.com/q/2532234/633864) for more explanations.

> [!NOTE]
> The project is developed on [Debian 12](https://www.debian.org/) if you use another OS have that in mind if something doesn't work as expected.

# Install Symfony

After cloning current repository to build Docker images in the project root execute:

    make build

To install Symfony:

    make up

# Usage

After installation app should be available at [localhost](http://localhost/).

|           Action            |    Command     |
|-----------------------------|----------------|
| Start containers            | `make up`      |
| Stop containers             | `make down`    |
| Rebuild containers          | `make rebuild` |
| Show live logs              | `make logs`    |
| Get Bash shell in container | `make bash`    |
| Clear the cache             | `make cc`      |
| Start tests with phpunit    | `make test`    |

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
