.DEFAULT_GOAL := help

UID := $(shell id -u)
GID := $(shell id -g)

help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build docker image
	@docker build --build-arg UID=${UID} --build-arg GID=${GID} --tag php-blues .

up: build ## Start container
	@docker run --rm -d --name php-blues -v $(PWD):/app --user ${UID}:${GID} php-blues

down: ## Start container
	@docker stop php-blues

rmi: down ## Remove docker image
	@docker rmi -f php-blues

shell: ## Shell of php container
	@docker exec -ti --user ${UID}:${GID} php-blues /bin/bash
