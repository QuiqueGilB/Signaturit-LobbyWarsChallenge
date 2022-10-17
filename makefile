#env=dev

install:
	docker-compose run --rm composer install
up:
	docker-compose up -d --force-recreate

cc: command=cache\:clear

console cc:
	docker-compose run --rm php bin/console ${command}