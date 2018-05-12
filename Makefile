lint:
	./vendor/bin/php-cs-fixer fix modules --dry-run
fix:
	./vendor/bin/php-cs-fixer fix modules
test:
	#vendor/bin/phpstan analyse modules -c phpstan.neon --level max
	vendor/bin/phpunit