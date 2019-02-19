build:
	docker-compose -f docker/docker-compose.yml build

docker-start:
	docker-compose -f docker/docker-compose.yml up -d

docker-stop:
	docker-compose -f docker/docker-compose.yml stop

bash-symfony:
	docker exec -it -u dev sf4_php bash

bash-root:
	docker exec -it sf4_php bash
