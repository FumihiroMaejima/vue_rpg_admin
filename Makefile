##############################
# make docker environmental
##############################
up:
	docker-compose up -d

stop:
	docker-compose stop

down:
	docker-compose down

down-rmi:
	docker-compose down --rmi all
ps:
	docker-compose ps

##############################
# make frontend production in nginx container
##############################
frontend-install:
	docker-compose exec nginx ash -c 'cd /var/www/frontend && yarn install'

frontend-build:
	docker-compose exec nginx ash -c 'cd /var/www/frontend && yarn build'

##############################
# backend
##############################
migrate:
	docker-compose exec app php artisan migrate

# データベースから全テーブルをドロップし、その後migrateを行う
migrate-fresh:
	docker-compose exec app php artisan migrate:fresh --seed

# 全部のデータベースマイグレーションを最初にロールバックし,その後migrateを行う
migrate-refresh:
	docker-compose exec app php artisan migrate:refresh --seed

# migrationを全てロールバックする
migrate-reset:
	docker-compose exec app php artisan migrate:reset

seed:
	docker-compose exec app php artisan db:seed

tinker:
	docker-compose exec app php artisan tinker

composer-install:
	docker-compose exec app composer install

composer-update:
	docker-compose exec app composer update

dump-autoload:
	docker-compose exec app composer dump-autoload

cache-clear:
	docker-compose exec app php artisan cache:clear

view-clear:
	docker-compose exec app php artisan view:clear

config-clear:
	docker-compose exec app php artisan config:clear

phpunit:
	docker-compose exec app vendor/bin/phpunit --testdox

phpcsfix:
	docker-compose exec app vendor/bin/php-cs-fixer fix -v

phpcs:
	docker-compose exec app vendor/bin/phpcs --standard=phpcs.xml --extensions=php .

phpmd:
	docker-compose exec app vendor/bin/phpmd . text ruleset.xml --suffixes php --exclude node_modules,resources,storage,vendor,app/Console, database/seeds

# local server
backend-serve:
	cd app/backend && php artisan serve

##############################
# web server(nginx)
##############################
nginx-t:
	docker-compose exec nginx ash -c 'nginx -t'

nginx-reload:
	docker-compose exec nginx ash -c 'nginx -s reload'

nginx-stop:
	docker-compose exec nginx ash -c 'nginx -s stop'


##############################
# db container(mysql)
##############################
mysql:
	docker-compose exec db bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'


##############################
# circle ci
##############################
circleci:
	cd app/backend && circleci build

ci:
	circleci build

##############################
# mock-server docker container
##############################
mock-up:
	docker-compose -f ./docker-compose.mock.yml up -d

mock-down:
	docker-compose -f ./docker-compose.mock.yml down

mock-ps:
	docker-compose -f ./docker-compose.mock.yml ps

##############################
# swagger docker container
##############################
swagger-up:
	docker-compose -f ./docker-compose.swagger.yml up -d

swagger-down:
	docker-compose -f ./docker-compose.swagger.yml down

swagger-ps:
	docker-compose -f ./docker-compose.swagger.yml ps

##############################
# swagger codegen mock-server
##############################
codegen-mock:
	rm -rf api/node-mock/* && \
	swagger-codegen generate -i api/api.yml -l nodejs-server -o api/node-mock && \
	sed -i -e "s/serverPort = 8080/serverPort = 3200/g" api/node-mock/index.js && \
	cd api/node-mock && npm run prestart

codegen-changeport:
	sed -i -e "s/serverPort = 8080/serverPort = 3200/g" api/node-mock/index.js

codegen-prestart:
	cd api/node-mock && npm run prestart

codegen-start:
	cd api/node-mock && npm run start
