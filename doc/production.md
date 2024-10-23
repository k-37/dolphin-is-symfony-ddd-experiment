# Requirements

### If production deployment on [Kubernetes](https://kubernetes.io/) cluster is planned

To deploy application on a local Kubernetes cluster, for development and testing purposes, install:

- [minikube](https://minikube.sigs.k8s.io/docs/start/)
- [kubectl](https://kubernetes.io/docs/tasks/tools/#kubectl)
- [Helm](https://helm.sh/docs/intro/quickstart/)

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
