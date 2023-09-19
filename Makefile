.SILENT:

DOCKER_COMPOSE = docker-compose
DOCKER_PHP_CONTAINER_EXEC = $(DOCKER_COMPOSE) exec doelapp
DOCKER_PHP_EXECUTABLE_CMD = $(DOCKER_PHP_CONTAINER_EXEC) php

CMD_ARTISAN = $(DOCKER_PHP_EXECUTABLE_CMD) artisan

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
