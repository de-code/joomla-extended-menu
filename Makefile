# See https://docs.joomla.org/J4.x:Joomla_CLI_Installation
joomla-install:
	@echo "installing joomla..."
	docker-compose exec -T joomla \
		php installation/joomla.php install \
		--no-interaction \
		--site-name=Test \
		--admin-user=Admin \
		--admin-username=admin \
		--admin-password=admin-password \
		--admin-email=admin@example.org \
		--db-host=joomladb \
		--db-user=root \
		--db-pass=db_root_password \
		--db-name=joomla_db \
		--db-prefix=test_


joomla-install-extension:
	docker-compose exec -T joomla \
		php cli/joomla.php extension:install \
		--path=/source/dist/exmenu.zip


joomla-enable-debug:
	docker-compose exec -T joomla \
		php cli/joomla.php config:set debug=true


joomla-db-shell:
	docker-compose exec joomladb mysql \
		-u root \
		-pdb_root_password \
		--database=joomla_db


joomla-db-enable-extension:
	cat ./sql/enable-mod-exmenu.sql \
	| docker-compose exec -T joomladb mysql \
		-u root \
		-pdb_root_password \
		--database=joomla_db


joomla-install-if-not-installed:
	@if docker-compose exec -T joomla test -e installation; then \
		$(MAKE) joomla-install; \
	else \
		echo "already installed"; \
	fi


joomla-wait-for-port-available:
	docker-compose run --rm wait-for-it \
		"joomla:80" \
		--timeout=30 \
		--strict \
		-- echo "joomla is up"


joomla-start-and-wait:
	docker-compose up -d
	$(MAKE) joomla-wait-for-port-available
	$(MAKE) joomla-install-if-not-installed


extension-zip:
	mkdir -p dist
	zip -r dist/exmenu.zip \
		mod_exmenu.* \
		exmenu \
		LICENSE


clean:
	docker-compose down -v
