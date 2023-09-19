.SILENT:

DOCKER_COMPOSE = docker-compose
DOCKER_PHP_CONTAINER_EXEC = docker exec -it doelphp

start:
	$(DOCKER_COMPOSE) up -d

restart:
	$(DOCKER_COMPOSE) restart

build:
	$(DOCKER_COMPOSE) up -d --build --force-recreate

stop:
	$(DOCKER_COMPOSE) stop

down:
	$(DOCKER_COMPOSE) down

make bash:
	$(DOCKER_PHP_CONTAINER_EXEC) sh

.env:
	cd app && cp .env.example .env

help:
	@echo "Docker Makefile"
	@echo ""
	@echo "Usage:"
	@echo "  make start                 Start the project"
	@echo "  make restart               Restart the project"
	@echo "  make build                 Build the project"
	@echo "  make stop                  Stop the project"
	@echo "  make down                  Stop and remove containers, networks, images, and volumes"
