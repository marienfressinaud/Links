<?php

return array (
	array (
		'route'      => '/',
		'controller' => 'index',
		'action'     => 'index'
	),
	
	//////////
	array (
		'route'      => '/ajouter_lien',
		'controller' => 'link',
		'action'     => 'add'
	),
	
	array (
		'route'      => '/api/ajouter_lien',
		'controller' => 'api',
		'action'     => 'add'
	),
);
