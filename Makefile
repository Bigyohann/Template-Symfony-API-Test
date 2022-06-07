.PHONY: dev prod stop preprod npm deploy-prod compose-prod
dockername= copro_$(USER)
dev:
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.override.yml --env-file .env up -d --remove-orphans --force-recreate --no-build
prod: pull-prod deploy-prod compose-prod

build-dev:
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.override.yml --env-file .env build php
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.override.yml --env-file .env push php
build-prod-php:
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env --env-file .env.local build php
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env --env-file .env.local push php
build-prod-front:
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env --env-file .env.local build front
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env --env-file .env.local push front
stop:
	@docker-compose -p $(dockername) stop
bash-front:
	@docker-compose -p $(dockername) exec front sh
bash-php:
	@docker-compose -p $(dockername) exec php sh
logs-php:
	docker-compose -p $(dockername) logs -f php
logs-front:
	docker-compose -p $(dockername) logs -f front
npm:
	@docker-compose -p $(dockername) exec front sh -c "yarn"
test-front:
	@docker-compose -p $(dockername) exec front sh -c "yarn test"
test-php:
	@docker-compose -p $(dockername) exec -T php sh -c "bin/console doctrine:migrations:migrate --no-interaction --env="test
	@docker-compose -p $(dockername) exec -T php sh -c "bin/phpunit -dpcov.enabled=1 --coverage-clover coverage.xml"
compose-prod:
	@docker-compose -p $(dockername) exec php sh -c "php bin/console cache:clear"
pull-prod:
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env.local pull -q
pull-dev:
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.override.yml --env-file .env pull -q
deploy-prod:
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env.local up -d --remove-orphans --force-recreate --no-build
ci:
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.test.yml --env-file .env up -d --remove-orphans --force-recreate --no-build
