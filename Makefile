.PHONY: dev prod stop preprod npm deploy-prod compose-prod
dev:
	@docker-compose -f docker-compose.yml -f docker-compose.override.yml --env-file .env up -d --remove-orphans --force-recreate --no-build
prod: pull-prod deploy-prod compose-prod

build-dev:
	@docker-compose -f docker-compose.yml -f docker-compose.override.yml --env-file .env build php
	@docker-compose -f docker-compose.yml -f docker-compose.override.yml --env-file .env push php
build-prod-php:
	@docker-compose -f docker-compose.yml -f docker-compose.prod.yml --env-file .env --env-file .env.local build php
	@docker-compose -f docker-compose.yml -f docker-compose.prod.yml --env-file .env --env-file .env.local push php
stop:
	@docker-compose stop
bash:
	@docker-compose exec php sh
logs:
	docker-compose logs -f php
test:
	@docker-compose exec -T php sh -c "bin/console doctrine:migrations:migrate --no-interaction --env='test'"
	@docker-compose exec -T php sh -c "bin/phpunit -dpcov.enabled=1 --coverage-clover coverage.xml"
compose-prod:
	@docker-compose exec php sh -c "php bin/console cache:clear"
pull-prod:
	@docker-compose -f docker-compose.yml -f docker-compose.prod.yml --env-file .env.local pull -q
pull-dev:
	@docker-compose -f docker-compose.yml -f docker-compose.override.yml --env-file .env pull -q
deploy-prod:
	@docker-compose -f docker-compose.yml -f docker-compose.prod.yml --env-file .env.local up -d --remove-orphans --force-recreate --no-build
ci:
	@docker-compose -f docker-compose.yml -f docker-compose.test.yml --env-file .env up -d --remove-orphans --force-recreate --no-build
