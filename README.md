# FrankenPHP and Laravel 12 Octane with Docker

This template was created for a quick start of a Laravel project with already 
prepared basic logic and is required by the environment:

<a href="https://github.com/deniskorbakov/laravel-12-frankenphp-docker"><img alt="" src="https://github.com/deniskorbakov/laravel-12-frankenphp-docker/actions/workflows/deploy.yml/badge.svg">
</a>

## Installation

To start the template you will need git and docker/docker compose

**Performing steps:**

You can also submit a template to yourself through the GitHub interface
```bash
git clone https://github.com/deniskorbakov/laravel-12-frankenphp-docker.git
```

Let's go to the cloned repository
```bash
cd laravel-12-frankenphp-docker
```

Copy env example to env
```bash
cp .env.example .env
```

Let's run the command to start the project
```bash
make init
```

**Docker images - utilities:**

* Laravel 12
* Frankenphp
* Postgres
* Redis
* Supervisor
* Traefik
* Mailhog

**Auxiliary services:**

* Rector + Phpstan + Php_codesniffer
* Pest

**Libraries - prepared code:**

* DTO Laravel-data
* WebSocket - centrifugo
* Horizon - monitoring queue
* laravel/octane
* Admin panel - Filament
* API logic auth
* Logic saved files in storage - db
* Scribe API doc
* Dozzle - monitoring containers

**Additional functionality:**

* Multi-stage build
* Prepared assembly for local development and sales
* Configured GitHub actions for stat analyzers and deployment
* Customized role system
* Centrifugo real-time messaging server
* Ansible is configured to set up the production environment
* Monitoring system

**Go to the project address:**
- [API doc](http://localhost/api/docs)
- [Admin panel](http://localhost/admin/login)
- [Horizon - available only to users with the Developer role](http://localhost/horizon)

## Documentation

[Template documentation](documentation/README.md)


