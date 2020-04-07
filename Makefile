all: help

help:                  #~ Show this help
	@fgrep -h "#~"  $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e "s/^\([^:]*\):/${GREEN}\1${RESET}/;s/#~r/${RESET}/;s/#~y/${YELLOW}/;s/#~ //"

build:                 #~ Build docker containers
	docker-compose build

start:                 #~ Start the docker containers
	docker-compose up -d

install:               #~ Install and start the project
install: build start composer-install

stop:                  #~ Stop the docker containers
	docker-compose stop

composer-install:      #~ Run composer install.
	docker-compose exec php sh -c "php -d memory_limit=-1 /usr/bin/composer install"

.PHONY: install build composer-install start stop
