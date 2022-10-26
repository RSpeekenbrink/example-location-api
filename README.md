# Location API Example

This is a test application made with the Laravel Framework as a Technical Test for ZAP-maps.
Original assesment: https://bitbucket.org/nextgreencar/zap-map-technical-interview-laravel/src/master/

# Table of contents

- [Getting Started](#getting-started)
    - [Prerequisites](#prerequisites)
    - [Installing](#installing)
    - [Setting up the database and installing packages](#setting-up-the-database-and-installing-packages)
    - [Building the frontend](#building-the-vuejs-views-and-installing-npm-packages)
- [Running the tests](#running-the-tests)
- [Code Style](#code-style)

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

> On windows it's incredibly important to checkout the repo with the correct line endings. To achieve this run `git config --global core.autocrlf true` once **before cloning the repo**. Otherwise this can lead to problems when starting the Docker environment or when pushing code to the repo.

- [Docker Desktop](https://www.docker.com/products/docker-desktop)
- [WSL2 (Only required on windows)](https://docs.microsoft.com/en-us/windows/wsl/install-win10)

### Installing

#### Windows Prerequisites

Open a new WSL2 Ubuntu shell and navigate to the cloned project. Then install make by executing:

```bash
sudo apt install make
```

After this you are ready to continue with the normal setup.

#### Installing and Running the app

Simply run:

```bash
make install && make up
```

If you want the application to run on a port other than port 80 simply change `APP_PORT` in your .env file. You can do the
same for:
`FORWARD_DB_PORT`

### Setting up the database and installing packages

To setup the database you can execute:

```bash
make migrate
```

The database is automatically created based on the credentials in your .env file and can also be reached on your
localhost on the configured `FORWARD_DB_PORT` (3306 by default).

You can ssh to the server container to execute your normal artisan commands with

```bash
make sh
```

### Building the Frontend (And installing NPM packages)
To work on the frontend you need to install all NPM packages via

```bash
make npmi
```

Then you can watch the files and build them on the fly with

```bash
make watch
```

The watcher will automatically rebuild all JS and CSS files when they change.

This will run the vite server. In order for this to work make sure the VITE_APP_URL in the env file is configured to an
URI pointing to the box (i.e. forward location-api.test to 127.0.0.1 in hosts file). This due to how Vite currently runs.

## Running the tests

To run the tests locally you can execute:

```bash
make test
```

This will run all the Feature and Unit tests available for the project.

## Code Style

We use the Spatie guidelines for code styling (https://spatie.be/guidelines/laravel-php).

To format your code autmatically you can run

```bash
make style
```
