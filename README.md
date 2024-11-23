# Introduction

This repository is used to practice [Symfony](https://en.wikipedia.org/wiki/Symfony) and [Domain-driven design](https://en.wikipedia.org/wiki/Domain-driven_design). Commit messages will have detailed description which commands, documentation and other resources were used along the way. The goal is to have information on *why* and *how* in addition to *what* has changed. [`git blame`](https://www.atlassian.com/git/tutorials/inspecting-a-repository/git-blame) and `git log` can be used to follow along, commit history can be seen as a tutorial. Commit Driven Learning (CDL). 🤯

## Highlights

- [Symfony Docker](https://github.com/dunglas/symfony-docker) with [FrankenPHP](https://frankenphp.dev/) at [commit](commit/3d1f347e7cf82eadedc40f66bd693a33c81e2d66).
- [Symfony](https://symfony.com/) at [commit](commit/a86001810d3ebf5b2eefcdd965c33c7897a2c5c7).
- Makefile at [commit](commit/c469c151cc8ca4c2d65bf960cf1a92dfb058120d).
- [Documentation](doc/editors.md) for debugging with [PhpStorm](https://www.jetbrains.com/phpstorm/) and [Visual Studio Code](https://code.visualstudio.com/).
- Unit, functional and E2E tests at [commit](commit/b20babfeff8f8a115e25696ec5641c54ec17b750), [commit](commit/5314299ad0997cce952d0f4d4005d1db4faf3c71), [commit](commit/8b4cc74e7d8de0921616794e5fae870a1065a5fc) and [commit](commit/51270f6e998904ecc46ab31a05575ed6439dd72f).
- [CQRS](https://herbertograca.com/2017/11/16/explicit-architecture-01-ddd-hexagonal-onion-clean-cqrs-how-i-put-it-all-together/) and [Event Sourcing](https://medium.com/@skowron.dev/practical-implementation-of-event-sourcing-in-symfony-a-case-study-on-client-verification-system-2419f71be249) at [commit](commit/2d1465b973499831377f442a90760451b5b3c49c) and [commit](https://github.com/k-37/dolphin-is-symfony-ddd-experiment/commit/286716406f37cc6357bdb921272725603cbd2f22).
- Domain Events at [commit](commit/c84b9d5969ca887b3dc7e57f7b159297cb9e076e).
- [Deployment in production on Kubernetes](doc/production.md) at [commit](commit/bdbb27fa60f7cb89439a44a8441ae8c61d64ae95) and [commit](commit/3ae1362b8f649d3f9638f37590cb1159e393a05a).
- [Semantic HTML](https://web.dev/learn/html/semantic-html) with [Pico CSS](https://picocss.com/) at [commit](commit/74c2d1fece82c22df25d17f366fe6772431df753).
- [Deptrac](https://github.com/qossmic/deptrac) at [commit](commit/9fe740606a44849b2486b8ebb1b88bda2b7195e3) and [commit](commit/9b5cdbaff91850850b2d04b7cc889caa40bd0b66).
- [PHPStan](https://phpstan.org/user-guide/getting-started) at [commit](commit/24fa8c8664310a70d0744eced3f9c9bd3b083943).
- [Easy Coding Standard](https://github.com/easy-coding-standard/easy-coding-standard) at [commit](commit/eb30f1423edb3c878e8830950a583b44b27e3fa5).

# Requirements

- [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
- If you are using Windows, you have to install [chocolatey.org](https://chocolatey.org/) or [Cygwin](http://cygwin.com) to use the `make` command. Check out this [StackOverflow question](https://stackoverflow.com/q/2532234/633864) for more explanations.

> [!NOTE]
> The project is developed on [Debian 12](https://www.debian.org/) if you use another OS have that in mind if something doesn't work as expected.

# Install Symfony

To build Docker images, after cloning current repository in the project root execute:

    make build

To install Symfony inside Docker container and start the application:

    make up

`make up` will install Symfony only if it is not already installed.

# Usage

After installation app should be available at [http://localhost/](http://localhost/).

## Services

### [pgAdmin](https://www.pgadmin.org/) - administration and development platform for PostgreSQL

It is available at [http://localhost:5050/](http://localhost:5050/).

Credentials:

- **Email Address / Username**: `admin@example.com`
- **Password**: `!ChangeMe!`

### [Mailpit](https://mailpit.axllent.org/) - email & SMTP testing tool with API for developers

It is available at [http://localhost:8025/](http://localhost:8025/).

### [RabbitMQ](https://www.rabbitmq.com/) - a reliable and mature messaging and streaming broker

RabbitMQ Management (UI) is available at [http://localhost:15672/](http://localhost:15672/).

Credentials:

- **Username**: `admin`
- **Password**: `!ChangeMe!`

## Commands which can be executed from the project root folder

|                          Action                          |                      Command                      |
|----------------------------------------------------------|---------------------------------------------------|
| List all commands                                        | `make help`                                       |
| Start containers                                         | `make up`                                         |
| Check project for errors, run tests, code analysis, etc. | `make check`                                      |
| Stop containers                                          | `make down`                                       |
| Rebuild and start the containers                         | `make rebuild`                                    |
| Restart the containers                                   | `make restart`                                    |
| Show live logs                                           | `make logs`                                       |
| Get Bash shell in container                              | `make bash`                                       |
| Clear the cache                                          | `make cc`                                         |
| Start tests with phpunit                                 | `make test`                                       |
| Install composer package                                 | `make composer c='require <PACKAGE_NAME>'`        |
| Take ownership of files outside the container            | `make ownership`                                  |
| Remove all the containers, networks, volumes and images  | `make destroy`                                    |
| Execute Symfony console command                          | `make sf c='<COMMAND>'`, e.g. `make sf c='about'` |
| Run architectural layers analysis with Deptrac           | `make ala`                                        |
| Run static code analysis with PHPStan                    | `make sca`                                        |
| Run coding standard analysis with Easy Coding Standard   | `make csa`                                        |
| Fix coding standard with Easy Coding Standard            | `make csf`                                        |

# Documentation

- [Editors and IDEs configuration](doc/editors.md).
- [Deployment in production on Kubernetes](doc/production.md).
- [Troubleshooting](doc/troubleshooting.md).

# Acknowledgements

Everything here is heavily influenced by these great projects:

- [Symfony: The Fast Track](https://symfony.com/book)
- [Symfony Documentation](https://symfony.com/doc/current/index.html)
- [Symfony Docker](https://github.com/dunglas/symfony-docker)
- [API Platform](https://api-platform.com/)
- [jorge07/symfony-6-es-cqrs-boilerplate](https://github.com/jorge07/symfony-6-es-cqrs-boilerplate)
- [Pico CSS](https://picocss.com/)

Big thank you for all the ~~fish~~ lessons goes to them. 🙏

🐬
