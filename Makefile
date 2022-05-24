.PHONY: dev prod stop preprod npm deploy-prod compose-prod
dockername= copro_big_$(USER)
dev:
	@echo "\033[32;1m-------Start project-------\033[0m"
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.override.yml --env-file .env up -d --remove-orphans --force-recreate --no-build
prod: pull-prod deploy-prod compose-prod

build-dev:
	@echo "\033[32;1m-------Build and push container for dev-------\033[0m"
	@echo "\033[32;1m-------Build container-------\033[0m"
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.override.yml --env-file .env build php
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.override.yml --env-file .env push php
build-prod-php:
	@echo "\033[32;1m-------Build and push container for dev-------\033[0m"
	@echo "\033[32;1m-------Build container-------\033[0m"
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env --env-file .env.local build php
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env --env-file .env.local push php
build-prod-front:
	@echo "\033[32;1m-------Build and push container for dev-------\033[0m"
	@echo "\033[32;1m-------Build container-------\033[0m"
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env --env-file .env.local build front
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env --env-file .env.local push front
stop:
	@echo "\033[32;1m-------Stoping containers-------\033[0m"
	@docker-compose -p $(dockername) stop
bash-front:
	@echo "\033[32;1m-------Start bash shell in front container-------\033[0m"
	@docker-compose -p $(dockername) exec front sh
bash-php:
	@echo "\033[32;1m-------Start bash shell in php container-------\033[0m"
	@docker-compose -p $(dockername) exec php sh
logs-php:
	@echo "\033[32;1m-------Show container log-------\033[0m"
	docker-compose -p $(dockername) logs -f php
logs-front:
	@echo "\033[32;1m-------Show container log-------\033[0m"
	docker-compose -p $(dockername) logs -f front
npm:
	@echo "\033[32;1m-------Npm install on container-------\033[0m"
	@docker-compose -p $(dockername) exec front sh -c "yarn"
test-front:
	@echo "\033[32;1m-------Run tests on front container-------\033[0m"
	@docker-compose -p $(dockername) exec front sh -c "yarn test"
test-php:
	@echo "\033[32;1m-------Run tests on php container-------\033[0m"
	@docker-compose -p $(dockername) exec -T php sh -c "bin/console doctrine:migrations:migrate --no-interaction --env="test
	@docker-compose -p $(dockername) exec -T php sh -c "bin/phpunit -dpcov.enabled=1 --coverage-clover coverage.xml"
compose-prod:
	@echo "\033[32;1m-------Run composer prod-------\033[0m"
	@docker-compose -p $(dockername) exec php sh -c "php bin/console cache:clear"
pull-prod:
	@echo "\033[32;1m-------Pull prod container-------\033[0m"
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env.local pull -q
pull-dev:
	@echo "\033[32;1m-------Pull prod container-------\033[0m"
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.override.yml --env-file .env pull -q
deploy-prod:
	@echo "\033[32;1m-------Deploy app to production-------\033[0m"
	@echo "\033[32;1m-------Start containers-------\033[0m"
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.prod.yml --env-file .env.local up -d --remove-orphans --force-recreate --no-build
ci:
	@echo "\033[32;1m-------Start project-------\033[0m"
	@docker-compose -p $(dockername) -f docker-compose.yml -f docker-compose.test.yml --env-file .env up -d --remove-orphans --force-recreate --no-build
