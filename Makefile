.DEFAULT_GOAL := help

UID := $(shell id -u)
GID := $(shell id -g)

help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build docker image
	@docker build --build-arg UID=${UID} --build-arg GID=${GID} --tag php-blues .

rmi: ## Remove docker image
	@docker rmi php-blues

vendor: ## Install composer vendors
	@docker run --rm -t -v $(PWD):/app --user ${UID}:${GID} php-blues composer update

test: ## Run tests
	@docker run --rm -t -v $(PWD):/app --user ${UID}:${GID} php-blues /app/vendor/bin/phpunit $^

shell: ## Shell of php container
	@docker run --rm -ti -v $(PWD):/app --user ${UID}:${GID} php-blues /bin/bash
