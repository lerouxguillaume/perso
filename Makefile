build:
	docker-compose -f docker/docker-compose.yml build

docker-start: docker-stop
	docker-compose -f docker/docker-compose.yml up -d

docker-watch:
	docker-compose -f docker/docker-compose.yml up

docker-stop:
	docker-compose -f docker/docker-compose.yml stop

bash-symfony:
	docker exec -it -u dev php_guler bash

bash-apache:
	docker exec -it apache_guler bash

bash-root:
	docker exec -it php_guler bash

bash-mysql:
	docker exec -it mysql_guler bash

bash-front:
	docker exec -it vuejs_guler bash


### Ansible ###

ansible-ping:
	ansible -i ansible/hosts all -m ping -u guillaume

deliver-api:
	ansible-playbook ansible/ansible_api.yml -i ansible/hosts -u guillaume

deliver-front:
	ansible-playbook ansible/ansible_front.yml -i ansible/hosts -u guillaume