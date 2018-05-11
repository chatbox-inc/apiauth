lint:
	./vendor/bin/php-cs-fixer fix modules --dry-run
test:
	#vendor/bin/phpstan analyse modules -c phpstan.neon --level max
	vendor/bin/phpunit