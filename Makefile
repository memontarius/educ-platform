
ENV_PATH=./.env
ifneq ("$(wildcard $(ENV_PATH))","")
	 include $(ENV_PATH)
endif


DOCKER_FILE=docker-compose.yml
cnn=$(CONTAINER_PREFIX)_app # Container name
sn=app #Service name
c=DatabaseSeeder # Class name


#------ Setup
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


#------ Docker
up:
	docker compose up -d

dw:
	docker compose down


#------ DB
mig:
	php artisan migrate

migr:
	php artisan migrate:rollback

seed:
	php artisan db:seed --class=$(c)

migrf:
	php artisan migrate:refresh

c-mig:
	docker exec $(cnn) make mig

c-migr:
	docker exec $(cnn) make migr

c-seed:
	docker exec $(cnn) make seed c=$(c)

c-migrf:
	docker exec $(cnn) make migrf
