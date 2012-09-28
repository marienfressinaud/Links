<?php

return array (
	array (
		'route'      => '/',
		'controller' => 'index',
		'action'     => 'index'
	),
	array (
		'route'      => '/\?p=(\d+)',
		'controller' => 'index',
		'action'     => 'index',
		'params'     => array ('page')
	),
	array (
		'route'      => '/parametrage',
		'controller' => 'index',
		'action'     => 'configuration'
	),
	array (
		'route'      => '/datastore.php',
		'controller' => 'index',
		'action'     => 'export'
	),
	
	//////////
	array (
		'route'      => '/ajouter_lien',
		'controller' => 'link',
		'action'     => 'add'
	),
	array (
		'route'      => '/modifier_lien\?id=(.+)',
		'controller' => 'link',
		'action'     => 'update',
		'params'     => array ('id')
	),
	array (
		'route'      => '/supprimer_lien\?id=(.+)',
		'controller' => 'link',
		'action'     => 'delete',
		'params'     => array ('id')
	),
	
	array (
		'route'      => '/api/ajouter_lien',
		'controller' => 'api',
		'action'     => 'add'
	),
);
