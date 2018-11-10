ENVIRONMENT_FILE=.env
ENVIRONMENT_FILE_EXAMPLE=.env.example

LARADOCK_ENVIRONMENT_FILE=thyart-api-docker/.env
LARADOCK_ENVIRONMENT_FILE_EXAMPLE=.env.laradock.example

LARADOCK_MYSQL_SCRIPT_FILE=thyart-api-docker/mysql/docker-entrypoint-initdb.d/createdb.sql
LARADOCK_MYSQL_SCRIPT_FILE_EXAMPLE=createdb.sql.example

LARADOCK_CONTAINERS=	workspace \
						mysql     \
						nginx
LARADOCK_IMAGES=	laradock_nginx \
					laradock_php-fpm \
					laradock_mysql \
					laradock_workspace
GREEN=\033[0;32m
RED=\033[0;31m
WHITE=\033[0m

define print_output
	@printf "${${1}}[ThyArt API %s] %s\n${WHITE}" "$(shell date +"%D %T")" "$(2)"
endef

all: copy_environment_files build_containers

clean: delete_containers delete_envrionment_files
fclean: clean delete_laradock_database_folder delete_laradock_images

start: start_containers
stop: stop_containers

start_containers:
	@cd thyart-api-docker; docker-compose start $(LARADOCK_CONTAINERS)
	@$(call print_output,GREEN,containers $(LARADOCK_CONTAINERS) started)

stop_containers:
	@cd thyart-api-docker; docker-compose stop $(LARADOCK_CONTAINERS)
	@$(call print_output,RED,containers $(LARADOCK_CONTAINERS) stoped)

build_containers:
	@cd thyart-api-docker; docker-compose up -d $(LARADOCK_CONTAINERS)
	@$(call print_output,GREEN,containers $(LARADOCK_CONTAINERS) builded)

delete_containers:
	@cd thyart-api-docker; docker-compose down
	@$(call print_output,RED,containers $(LARADOCK_CONTAINERS) deleted)

delete_laradock_database_folder:
	@rm -rf ~/.laradock/data/mysql
	@$(call print_output,RED,removed laradock databases)

delete_laradock_images:
	@docker image rm $(LARADOCK_IMAGES)
	@$(call print_output,RED,removed laradock images)

copy_environment_files:
	@cp $(ENVIRONMENT_FILE_EXAMPLE) $(ENVIRONMENT_FILE)
	@$(call print_output,GREEN,copied $(ENVIRONMENT_FILE_EXAMPLE) into $(ENVIRONMENT_FILE))
	@cp $(LARADOCK_ENVIRONMENT_FILE_EXAMPLE) $(LARADOCK_ENVIRONMENT_FILE)
	@$(call print_output,GREEN,copied $(LARADOCK_ENVIRONMENT_FILE_EXAMPLE) into $(LARADOCK_ENVIRONMENT_FILE))
	@cp $(LARADOCK_MYSQL_SCRIPT_FILE_EXAMPLE) $(LARADOCK_MYSQL_SCRIPT_FILE)
	@$(call print_output,GREEN,copied $(LARADOCK_MYSQL_SCRIPT_FILE_EXAMPLE) into $(LARADOCK_MYSQL_SCRIPT_FILE))

delete_envrionment_files:
	@rm -f $(ENVIRONMENT_FILE)
	@$(call print_output,RED,removed $(ENVIRONMENT_FILE))
	@rm -f $(LARADOCK_ENVIRONMENT_FILE)
	@$(call print_output,RED,removed $(LARADOCK_ENVIRONMENT_FILE))
	@rm -f $(LARADOCK_MYSQL_SCRIPT_FILE)
	@$(call print_output,RED,removed $(LARADOCK_MYSQL_SCRIPT_FILE))


.PHONY: all clean fclean start stop start_containers stop_containers  build_containers delete_containers delete_laradock_database_folder delete_laradock_images copy_environment_file delete_envrionment_files