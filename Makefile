test:
	vendor/bin/phpstan analyse src libs tests --level max
	vendor/bin/phpunit