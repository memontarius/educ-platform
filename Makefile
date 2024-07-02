
ENV_PATH=./.env
ifneq ("$(wildcard $(ENV_PATH))","")
	 include $(ENV_PATH)
endif

DOCKER_FILE_PREFIX=
ifeq ($(APP_ENV),local)
	DOCKER_FILE_PREFIX=-dev
endif

DOCKER_FILE=docker-compose$(DOCKER_FILE_PREFIX).yml
cnn=$(CONTAINER_PREFIX)_app # Container name
sn=app #Service name
c=DatabaseSeeder # Class name


# Setup  _____________
prepare-env:
	cp -n .env.example .env || true
	make key

setup:
	sudo chown -R $(USER):www-data storage
	sudo chown -R $(USER):www-data bootstrap/cache
	sudo chmod 775 -R storage/
	sudo chmod 775 -R bootstrap/cache/

install:
	composer install
	npm i
	npm run build


# Helpers _____________
config-clr:
	docker exec $(cnn) php artisan cache:clear


# Docker _____________
up:
	docker compose --file $(DOCKER_FILE) up -d

dw:
	docker compose --file $(DOCKER_FILE) down

in:
	docker exec -it $(cnn) bash

b:
	docker-compose --file $(DOCKER_FILE) build

bs:
	docker-compose --file $(DOCKER_FILE) build $(sn)


# DB _____________
mig:
	docker exec $(cnn) php artisan migrate

migr:
	docker exec $(cnn) php artisan migrate:rollback

seed:
	docker exec $(cnn) php artisan db:seed --class=$(c)

migrf:
	docker exec $(cnn) php artisan migrate:refresh


# Testing _____________
test:
	make config-clr
	docker exec $(cnn) php artisan test

testc:
	make config-clr
	docker exec $(cnn) php artisan test --filter $(c)
