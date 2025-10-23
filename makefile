include .env

# a set of commands for updating a project in production
update-project: pull composer-install db-migrate build-front rm-images build-prod restart doc-generate

# a set of commands to initialize a project locally
init: build composer-install build-front key-generate storage-link db-migrate seed doc-generate restart build-wait

# a set of commands for initializing a project on production
init-prod: build-prod composer-install build-front key-generate storage-link db-migrate seed doc-generate restart build-prod

build:
	@echo "Building containers"
	@docker compose --env-file .env up -d --build
build-wait:
	@echo "Building containers"
	@docker compose --env-file .env up -d --build --wait
up:
	@echo "Starting containers"
	@docker compose --env-file .env up -d --remove-orphans
build-prod:
	@echo "Building containers"
	@docker compose -f docker-compose.yml -f docker-compose.prod.yml --env-file .env up -d --wait --build
up-prod:
	@echo "Starting containers"
	@docker compose -f docker-compose.yml -f docker-compose.prod.yml --env-file .env up -d --wait --remove-orphans
exec:
	@docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) /bin/bash
test:
	@echo "Run all tests"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer tests
test-coverage:
	@echo "Run test coverage"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer test-coverage
lint:
	@echo "Perform a code phpstan - phpcs"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer cs-check
	@echo "Perform a code rector"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer cs-rector
	@echo "Perform a words in project"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer word-check
lint-fix:
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer cs-fix
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer cs-rector-fix
rector-fix:
	@echo "Fix code with rector"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer cs-rector-fix
code-baseline:
	@echo "Perform phpstan generate-baseline"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) vendor/bin/phpstan analyse --generate-baseline --memory-limit=2G
composer-install:
	@echo "Running composer install"
	@docker exec -i $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer install
db-migrate:
	@echo "Running database migrations"
	@docker exec -i $$(docker ps -q -f name=php.${APP_NAMESPACE}) php artisan migrate --force
build-front:
	@echo "Building admin frontend for production"
	@docker exec -i $$(docker ps -q -f name=php.${APP_NAMESPACE}) npm i
	@docker exec -i $$(docker ps -q -f name=php.${APP_NAMESPACE}) npm run build
pull:
	@echo "Updating project from git and rebuild"
	@git pull
rm-images:
	@echo "Delete extra images"
	@docker system prune -f
key-generate:
	@echo "Key generate"
	@docker exec -i $$(docker ps -q -f name=php.${APP_NAMESPACE}) php artisan key:generate
storage-link:
	@echo "Storage Link"
	@docker exec -i $$(docker ps -q -f name=php.${APP_NAMESPACE}) php artisan storage:link
seed:
	@echo "Db Seed"
	@docker exec -i $$(docker ps -q -f name=php.${APP_NAMESPACE}) php artisan db:seed
doc-generate:
	@echo "Key generate"
	@docker exec -i $$(docker ps -q -f name=php.${APP_NAMESPACE}) php artisan scribe:generate
restart:
	@echo "restart container"
	@docker restart php.${APP_NAMESPACE}
expand-server:
	ansible-playbook -i ansible/inventory.ini ansible/playbooks/expand_environment.yml


