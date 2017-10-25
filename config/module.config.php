<?php
namespace PimcoreRestApi;

use PimcoreRestApi\Api\Api;
use PimcoreRestApi\Api\Factory;
use PimcoreRestApi\Service\ApiDocumentsFactory;
use PimcoreRestApi\Service\Documents;
use PimcoreRestApi\Service\Synchronizing;
use PimcoreRestApi\Service\ConfigSynchronizingFactory;
use PimcoreRestApi\Synchronize\FileSystemStrategy;
use PimcoreRestApi\View\Helper\PraDocumentFactory;

return [

	'service_manager' => [
		'invokables' => [

			// synchronizing
			FileSystemStrategy::class		=> FileSystemStrategy::class,
		],
		'factories' => [

			// api
			Api::class						=> Factory::class,

			// service
			Documents::class				=> ApiDocumentsFactory::class,
			Synchronizing::class			=> ConfigSynchronizingFactory::class,
		],
	],

	'view_helpers' => [
		'factories' => [
			'praDocument' 	=> PraDocumentFactory::class,
		],
	],
];
