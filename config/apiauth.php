<?php


return [

	"default" => "apiauth",

	"drivers" => [
		"apiauth" => [
			"user" => \App\User::class,
			"guard" => "default"
		]
	]

];