migrate:
	php ./database/up.php
migrate-down:
	php ./database/down.php
install:
	cp .env.default .env
	composer install
	npm i
	make migrate