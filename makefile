install:
	docker-compose run --rm composer install
up:
	docker-compose up -d --force-recreate