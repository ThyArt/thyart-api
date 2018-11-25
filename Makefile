ENVIRONMENT_FILE=					.env
ENVIRONMENT_FILE_EXAMPLE=			.env.example

ENVIRONMENT_TESTING_FILE=			.env.testing
ENVIRONMENT_TESTING_FILE_EXAMPLE=	.env.testing.example

LARADOCK_ENVIRONMENT_FILE=			thyart-api-docker/.env
LARADOCK_ENVIRONMENT_FILE_EXAMPLE=	.env.laradock.example

LARADOCK_MYSQL_SCRIPT_FILE=			thyart-api-docker/mysql/docker-entrypoint-initdb.d/createdb.sql
LARADOCK_MYSQL_SCRIPT_FILE_EXAMPLE=	createdb.sql.example

LARADOCK_CONTAINERS=				workspace \
									mysql     \
									nginx

LARADOCK_IMAGES=					laradock_nginx     \
									laradock_php-fpm   \
									laradock_mysql     \
									laradock_workspace

GREEN=								\033[0;32m
RED=								\033[0;31m
WHITE=								\033[0m

define print_output
	@printf "${${1}}[ThyArt API %s] %s\n${WHITE}" "$(shell date +"%D %T")" "$(2)"
endef

define docker_compose
	@cd thyart-api-docker; docker-compose $(1)
endef

define to_logs
	@$(2) >> $(1)storage/logs/makefile.log
endef

all: 		print_header copy_environment_files build_containers initiate_composer_dependencies initate_project_keys

database:	print_header initiate_dev_database initiate_testing_database

clean:		print_header delete_containers delete_envrionment_files

fclean:		print_header delete_containers delete_envrionment_files delete_laradock_database_folder	\
			delete_laradock_images

start:		print_header start_containers

stop:		print_header stop_containers

tests:		print_header run_tests

re:			print_header delete_containers delete_envrionment_files delete_laradock_database_folder	      \
			delete_laradock_images copy_environment_files build_containers initiate_composer_dependencies \
			initate_project_keys

workspace:	print_header enter_workspace_container

print_header:
	@echo "$(GREEN)\
  _____ _              _         _        _    ____ ___ \n\
 |_   _| |__  _   _   / \   _ __| |_     / \  |  _ \_ _|\n\
   | | | '_ \| | | | / _ \ | '__| __|   / _ \ | |_) | | \n\
   | | | | | | |_| |/ ___ \| |  | |_   / ___ \|  __/| | \n\
   |_| |_| |_|\__, /_/   \_\_|   \__| /_/   \_\_|  |___|\n\
              |___/                                     $(WHITE)"

start_containers:
	@$(call print_output,WHITE,starting containers $(LARADOCK_CONTAINERS))
	@$(call to_logs,../,$(call docker_compose,start $(LARADOCK_CONTAINERS)))
	@$(call print_output,GREEN,containers $(LARADOCK_CONTAINERS) started)

stop_containers:
	@$(call print_output,WHITE,stopping containers $(LARADOCK_CONTAINERS))
	@$(call to_logs,../,$(call docker_compose,stop $(LARADOCK_CONTAINERS)))
	@$(call print_output,RED,containers $(LARADOCK_CONTAINERS) stoped)

build_containers:
	@$(call print_output,WHITE,building containers $(LARADOCK_CONTAINERS))
	@$(call to_logs,../,$(call docker_compose,up -d $(LARADOCK_CONTAINERS)))
	@$(call print_output,GREEN,containers $(LARADOCK_CONTAINERS) builded)

delete_containers:
	@$(call print_output,WHITE,deleting containers $(LARADOCK_CONTAINERS))
	@$(call to_logs,../,$(call docker_compose,down))
	@$(call print_output,RED,containers $(LARADOCK_CONTAINERS) deleted)

delete_laradock_database_folder:
	@$(call to_logs,./,rm -rvf ~/.laradock/data/mysql)
	@$(call print_output,RED,laradock databases removed)

delete_laradock_images:
	@$(call print_output,WHITE,removing laradock images)
	@$(call to_logs,./,docker image rm $(LARADOCK_IMAGES))
	@$(call print_output,RED,laradock images removed)

copy_environment_files:
	@$(call to_logs,./,cp -v $(ENVIRONMENT_FILE_EXAMPLE) $(ENVIRONMENT_FILE))
	@$(call print_output,GREEN,$(ENVIRONMENT_FILE_EXAMPLE) copied into $(ENVIRONMENT_FILE))

	@$(call to_logs,./,cp -v $(ENVIRONMENT_TESTING_FILE_EXAMPLE) $(ENVIRONMENT_TESTING_FILE))
	@$(call print_output,GREEN,$(ENVIRONMENT_TESTING_FILE_EXAMPLE) copied into $(ENVIRONMENT_TESTING_FILE))

	@$(call to_logs,./,cp -v $(LARADOCK_ENVIRONMENT_FILE_EXAMPLE) $(LARADOCK_ENVIRONMENT_FILE))
	@$(call print_output,GREEN,$(LARADOCK_ENVIRONMENT_FILE_EXAMPLE) copied into $(LARADOCK_ENVIRONMENT_FILE))

	@$(call to_logs,./,cp -v $(LARADOCK_MYSQL_SCRIPT_FILE_EXAMPLE) $(LARADOCK_MYSQL_SCRIPT_FILE))
	@$(call print_output,GREEN,$(LARADOCK_MYSQL_SCRIPT_FILE_EXAMPLE) copied into $(LARADOCK_MYSQL_SCRIPT_FILE))

delete_envrionment_files:
	@$(call to_logs,./,rm -vf $(ENVIRONMENT_FILE))
	@$(call print_output,RED,$(ENVIRONMENT_FILE) removed)

	@$(call to_logs,./,rm -vf $(LARADOCK_ENVIRONMENT_FILE))
	@$(call print_output,RED,$(LARADOCK_ENVIRONMENT_FILE) removed)

	@$(call to_logs,./,rm -vf $(LARADOCK_MYSQL_SCRIPT_FILE))
	@$(call print_output,RED,$(LARADOCK_MYSQL_SCRIPT_FILE) removed)

initiate_composer_dependencies:
	@$(call print_output,WHITE,installing composer project dependencies)
	@$(call to_logs,../,$(call docker_compose,exec workspace composer install))
	@$(call print_output,GREEN,composer project dependencies installed)

initate_project_keys:
	@$(call print_output,WHITE,generating project encryption key)
	@$(call to_logs,../,$(call docker_compose,exec workspace php artisan key:generate))
	@$(call print_output,GREEN,project encryption key generated)

	@$(call print_output,WHITE,generating testing encryption key)
	@$(call to_logs,../,$(call docker_compose,exec workspace php artisan key:generate --env=testing))
	@$(call print_output,GREEN,testing encryption key generated)

initiate_dev_database:
	@$(call print_output,WHITE,migrating development database)
	@$(call to_logs,../,$(call docker_compose,exec workspace php artisan migrate))
	@$(call print_output,GREEN,development database migrated)

	@$(call print_output,WHITE,generating laravel passport clients)
	@$(call to_logs,../,$(call docker_compose,exec workspace php artisan passport:install))
	@$(call print_output,GREEN,laravel passport clients generated)

initiate_testing_database:
	@$(call print_output,WHITE,migrating testing database)
	@$(call to_logs,../,$(call docker_compose,exec workspace php artisan migrate --env=testing))
	@$(call print_output,GREEN,testing database migrated)

	@$(call print_output,WHITE,executing seeders on testing environment)
	@$(call to_logs,../,$(call docker_compose,exec workspace php artisan db:seed --env=testing))
	@$(call print_output,GREEN,seeders executed on testing environment)

run_tests:
	$(call docker_compose,exec workspace ./vendor/bin/phpunit)

enter_workspace_container:
	$(call docker_compose,exec workspace bash)

.PHONY:		all clean fclean start stop re tests workspace print_header start_containers stop_containers       \
			build_containers delete_containers delete_laradock_database_folder delete_laradock_images          \
			copy_environment_file delete_envrionment_files initiate_composer_dependencies initate_project_keys \
			initiate_dev_database initiate_testing_database run_tests enter_workspace_container