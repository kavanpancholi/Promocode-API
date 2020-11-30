.DEFAULT_GOAL:=help
SHELL:=/bin/bash
.PHONY: test help

deploy: ## Start deploying the app
	./setup.sh

test: ## Run phpunit tests
	docker-compose exec laravel phpunit

down: ## Stop all the containers
	docker-compose down --remove-orphans

help: ## List of available commands
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-10s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)
