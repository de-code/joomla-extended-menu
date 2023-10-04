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
		--db-pass=db_root_password


joomla-install-extension:
	docker-compose exec -T joomla \
		php cli/joomla.php extension:install \
		--path=/source/dist/exmenu.zip


joomla-enable-debug:
	docker-compose exec -T joomla \
		sed -i \
		-e 's/$debug = false;/$debug = true;/g' \
		configuration.php


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
