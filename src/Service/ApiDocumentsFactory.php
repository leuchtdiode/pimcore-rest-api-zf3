<?php
namespace PimcoreRestApi\Service;

use Interop\Container\ContainerInterface;
use PimcoreRestApi\Api\Api;
use Zend\ServiceManager\Factory\FactoryInterface;

class ApiDocumentsFactory implements FactoryInterface
{
	public function __invoke(
		ContainerInterface $container,
		$requestedName,
		array $options = null
	)
	{
		return new ApiDocuments(
			$container->get(Api::class),
			$container->get(Synchronizing::class)
		);
	}
}