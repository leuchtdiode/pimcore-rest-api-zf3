<?php
namespace PimcoreRestApi\Api;

use Interop\Container\ContainerInterface;
use Zend\Cache\Storage\StorageInterface;
use Zend\Http\Client;
use Zend\ServiceManager\Factory\FactoryInterface;

class Factory implements FactoryInterface
{
	const SERVICE_LOCATOR_CACHE_KEY = 'PimcoreRestApi\StorageCache';

	private $container;

	public function __invoke(
		ContainerInterface $container,
		$requestedName,
		array $options = null
	)
	{
		$this->container = $container;

		$pimcoreConfig = $container->get('Config')['pimcoreRestApi'];

		$this->failIfConfigInvalid($pimcoreConfig);

		return new Api(
			new Client(),
			$pimcoreConfig['host'],
			$pimcoreConfig['apiKey'],
			$pimcoreConfig['ssl'] !== null ? $pimcoreConfig['ssl'] : false,
			$this->getCacheStorage()
		);
	}

	private function failIfConfigInvalid($pimcoreConfig)
	{
		$this->failIfConfigMissing($pimcoreConfig);
		$this->failIfHostMissing($pimcoreConfig);
		$this->failIfApiKeyMissing($pimcoreConfig);
	}

	/**
	 * @param $pimcoreConfig
	 * @throws \Exception
	 */
	private function failIfConfigMissing($pimcoreConfig)
	{
		if (!isset($pimcoreConfig) && empty($pimcoreConfig))
		{
			throw new \Exception('Missing pimcore rest api config');
		}
	}

	/**
	 * @param $pimcoreConfig
	 * @return mixed
	 * @throws \Exception
	 */
	private function failIfHostMissing($pimcoreConfig)
	{
		if (!isset($pimcoreConfig['host']) && empty($pimcoreConfig['host']))
		{
			throw new \Exception('Missing host in config');
		}

		return $pimcoreConfig;
	}

	/**
	 * @param $pimcoreConfig
	 * @throws \Exception
	 */
	private function failIfApiKeyMissing($pimcoreConfig)
	{
		if (!isset($pimcoreConfig['apiKey']) && empty($pimcoreConfig['apiKey']))
		{
			throw new \Exception('Missing API-Key in config');
		}
	}

	private function getCacheStorage()
	{
		if ($this->container->has(self::SERVICE_LOCATOR_CACHE_KEY))
		{
			$storageCache = $this->container->get(self::SERVICE_LOCATOR_CACHE_KEY);

			$this->failIfStorageCacheIsInvalid($storageCache);

			return $storageCache;
		}

		return null;
	}

	private function failIfStorageCacheIsInvalid($storageCache)
	{
		if (!$storageCache instanceof StorageInterface)
		{
			throw new \Exception('Storage cache must be an instance of Zend\Cache\Storage\StorageInterface');
		}
	}
}