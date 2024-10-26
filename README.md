# Introduction

This repository is used to practice [Symfony](https://en.wikipedia.org/wiki/Symfony) and [Domain-driven design](https://en.wikipedia.org/wiki/Domain-driven_design). Commit messages will have detailed description which commands, documentation and other resources were used along the way. The goal is to have information on *why* and *how* in addition to *what* has changed. [`git blame`](https://www.atlassian.com/git/tutorials/inspecting-a-repository/git-blame) and `git log` can be used to follow along, commit history can be seen as a tutorial. Commit Driven Learning (CDL). 🤯

# Requirements

- [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
- If you are using Windows, you have to install [chocolatey.org](https://chocolatey.org/) or [Cygwin](http://cygwin.com) to use the `make` command. Check out this [StackOverflow question](https://stackoverflow.com/q/2532234/633864) for more explanations.

> [!NOTE]
> The project is developed on [Debian 12](https://www.debian.org/) if you use another OS have that in mind if something doesn't work as expected.

# Install Symfony

To build Docker images, after cloning current repository in the project root execute:

    make build

To install Symfony inside Docker container and start the application:

    make up logs

`make up` will install Symfony only if it is not already installed.

# Usage

After installation app should be available at [http://localhost/](http://localhost/).

## Services

### [pgAdmin](https://www.pgadmin.org/) - administration and development platform for PostgreSQL

It is available at [http://localhost:5050/](http://localhost:5050/).

Credentials:

- `Email Address / Username`: `admin@example.com`
- `Password`: `!ChangeMe!`

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
