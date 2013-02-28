<?php

return array (
	array (
		'route'      => '/',
		'controller' => 'index',
		'action'     => 'index'
	),
	array (
		'route'      => '/\?m=(private|public)&p=(\d+)',
		'controller' => 'index',
		'action'     => 'index',
		'params'     => array ('mode', 'page')
	),
	array (
		'route'      => '/\?p=(\d+)',
		'controller' => 'index',
		'action'     => 'index',
		'params'     => array ('page')
	),
	array (
		'route'      => '/\?m=(private|public)',
		'controller' => 'index',
		'action'     => 'index',
		'params'     => array ('mode')
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
	
	//////////
	array (
		'route'      => '/api/ajouter_lien',
		'controller' => 'api',
		'action'     => 'add'
	),
	array (
		'route'      => '/api/get_(\w+)_links\?format=(\w+)',
		'controller' => 'api',
		'action'     => 'getLinks',
		'params'     => array ('type', 'format')
	),
);
