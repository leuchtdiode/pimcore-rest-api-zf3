<?php
namespace PimcoreRestApi\Service;

use Interop\Container\ContainerInterface;
use PimcoreRestApi\Api\Api;
use PimcoreRestApi\Synchronize\FileSystemStrategy;
use Zend\ServiceManager\Factory\FactoryInterface;

class ConfigSynchronizingFactory implements FactoryInterface
{
	public function __invoke(
		ContainerInterface $container,
		$requestedName,
		array $options = null
	)
	{
		$config = $container->get('Config')['pimcoreRestApi'];

		return new ConfigSynchronizing(
			isset($config['synchronizing']) ? $config['synchronizing'] : null,
			$container->get(Api::class),
			$container->get(FileSystemStrategy::class)
		);
	}
}