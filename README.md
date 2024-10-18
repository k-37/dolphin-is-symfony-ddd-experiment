# Introduction

This repository is used to practice [Symfony](https://en.wikipedia.org/wiki/Symfony) and [Domain-driven design](https://en.wikipedia.org/wiki/Domain-driven_design). Commit messages will have detailed description which commands, documentation and other resources were used along the way. The goal is to have information on *why* and *how* in addition to *what* has changed. [`git blame`](https://www.atlassian.com/git/tutorials/inspecting-a-repository/git-blame) and `git log` can be used to follow along, commit history can be seen as a tutorial. Commit Driven Learning (CDL). 🤯

# Requirements

- [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
- If you are using Windows, you have to install [chocolatey.org](https://chocolatey.org/) or [Cygwin](http://cygwin.com) to use the `make` command. Check out this [StackOverflow question](https://stackoverflow.com/q/2532234/633864) for more explanations.

> [!NOTE]
> The project is developed on [Debian 12](https://www.debian.org/) if you use another OS have that in mind if something doesn't work as expected.

### If production deployment on [Kubernetes](https://kubernetes.io/) cluster is planned

To deploy application on a local Kubernetes cluster, for development and testing purposes, install:

- [minikube](https://minikube.sigs.k8s.io/docs/start/)
- [kubectl](https://kubernetes.io/docs/tasks/tools/#kubectl)
- [Helm](https://helm.sh/docs/intro/quickstart/)

# Install Symfony

To build Docker images, after cloning current repository in the project root execute:

    make build

To install Symfony inside Docker container and start the application:

    make up logs

`make up` will install Symfony only if it is not already installed.

# Usage

After installation app should be available at [http://localhost/](http://localhost/).

### Services

##### [pgAdmin](https://www.pgadmin.org/) - administration and development platform for PostgreSQL

It is available at [http://localhost:5050/](http://localhost:5050/).

Credentials:

- `Email Address / Username`: `admin@example.com`
- `Password`: `!ChangeMe!`

### Commands which can be executed from the project root folder

|                         Action                          |                      Command                      |
|---------------------------------------------------------|---------------------------------------------------|
| List all commands                                       | `make help`                                       |
| Start containers                                        | `make up`                                         |
| Stop containers                                         | `make down`                                       |
| Rebuild and start the containers                        | `make rebuild`                                    |
| Restart the containers                                  | `make restart`                                    |
| Show live logs                                          | `make logs`                                       |
| Get Bash shell in container                             | `make bash`                                       |
| Clear the cache                                         | `make cc`                                         |
| Start tests with phpunit                                | `make test`                                       |
| Install composer package                                | `make composer c='require <PACKAGE_NAME>'`        |
| Take ownership of files outside the container           | `make ownership`                                  |
| Remove all the containers, networks, volumes and images | `make destroy`                                    |
| Execute Symfony console command                         | `make sf c='<COMMAND>'`, e.g. `make sf c='about'` |

# PhpStorm

### Debugging

- [Debugging with Xdebug and PHPStorm](https://github.com/dunglas/symfony-docker/blob/6b37be14c98583e202cbbdec380c6e9e3103d2ab/docs/xdebug.md#debugging-with-xdebug-and-phpstorm)

### Remote interpreter

- On `File > Settings > PHP` we need to add interpreter which is inside container with the option `CLI Interpreter` using  `...` on the right side. For the option `Configuration files` we **must add both** `compose.yaml` and `compose.override.yaml`.
- On `File > Settings > PHP > Composer > Execution > Remote Interpreter > CLI Interpreter` select added interpreter.
- On `File > Settings > PHP > Test Frameworks` click on `+` and select remote interpreter. For the option `Path to script` we **must type** absolute path inside container `/app/vendor/autoload.php` and click refresh button on the right side, for the option `Default configuration file` **type** `/app/phpunit.xml.dist`. The bootstrap file can be skipped because it will be guessed from the config file.

[Detailed instructions with pictures](https://medium.com/the-sensiolabs-tech-blog/phpstorm-docker-ccc4ce9a0b8e). 📸️

# Troubleshooting

### Permissions outside container

As explained [here](https://github.com/dunglas/symfony-docker/blob/6b37be14c98583e202cbbdec380c6e9e3103d2ab/docs/troubleshooting.md#editing-permissions-on-linux), on GNU/Linux after installing Symfony `git diff` will complain `...Not a git repository...`, because files created inside container will have ownership set to `root` user, to fix that we need to set ownership to the current user outside the container with command:

    docker compose run --rm php chown -R $(id -u):$(id -g) .

or:

    make ownership

# Deployment

### Locally to minikube

##### Basic usage

To start the cluster from the project root execute:

    minikube start --addons registry --addons metrics-server --addons dashboard

If [errors are encountered](https://github.com/kubernetes/minikube/issues/19387) during `minikube start`, before starting it again run:

    minikube delete

Get Kubernetes [Dashboard](https://minikube.sigs.k8s.io/docs/handbook/dashboard/) URL:

    minikube dashboard --url

List pods with [`kubectl`](https://kubernetes.io/docs/reference/kubectl/):

    kubectl get pods --all-namespaces=true

##### Build and push Docker image of the application

On GNU/Linux and macOS, to point your terminal to use the docker daemon inside minikube run this:

    eval $(minikube docker-env)

Now any `docker` command you run in this current terminal will run against the docker inside minikube cluster. For detailed explanation and instructions for Windows [visit official minikube documentation](https://minikube.sigs.k8s.io/docs/handbook/pushing/#1-pushing-directly-to-the-in-cluster-docker-daemon-docker-env).

Build the image in minikube:

    docker build --tag localhost:5000/php --target frankenphp_prod .

Push the image in the registry installed in minikube:

    docker push localhost:5000/php

##### Deploy

Fetch Helm chart dependencies:

    helm repo add postgresql https://charts.bitnami.com/bitnami/
    helm dependency build etc/helm/dolphin

Deploy the project using the Helm chart:

    helm install dolphin etc/helm/dolphin \
        --set php.image.repository=localhost:5000/php \
        --set php.image.tag=latest

Copy and paste the commands displayed in the terminal to enable the port forwarding then go to [http://localhost:8080](http://localhost:8080) to access the application running in minikube cluster. Give it some time to start.

# Acknowledgements

Everything here is heavily influenced by these great projects:

- [Symfony: The Fast Track](https://symfony.com/book)
- [Symfony Documentation](https://symfony.com/doc/current/index.html)
- [Symfony Docker](https://github.com/dunglas/symfony-docker)
- [API Platform](https://api-platform.com/)
- [jorge07/symfony-6-es-cqrs-boilerplate](https://github.com/jorge07/symfony-6-es-cqrs-boilerplate)

Big thank you for all the ~~fish~~ lessons goes to them. 🙏

🐬
