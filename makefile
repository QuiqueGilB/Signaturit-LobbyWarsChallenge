env=dev

up:
	docker-compose up -d --force-recreate
down:
	docker-compose down

install: command:=install
require require-dev: package:=
require-dev: flags:=--dev
require require-dev: command:=require ${package} ${flags}
composer: command=
composer require require-dev install:
	docker-compose run --rm composer ${command}

cc: command=cache\:clear
console cc: command := bin/console ${command} -e ${env}

test: command:=vendor/bin/phpunit

php: command=
php console cc test:
	docker-compose run --rm php ${command}