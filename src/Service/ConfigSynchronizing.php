<?php
namespace PimcoreRestApi\Service;

use Exception;
use PimcoreRestApi\Api\Documents\GetDocumentById;
use PimcoreRestApi\Api\Documents\Helper;
use PimcoreRestApi\Api\PimcoreApi;
use PimcoreRestApi\Api\Documents\Search as DocumentSearch;
use PimcoreRestApi\Synchronize\FileSystemStrategy;
use PimcoreRestApi\Synchronize\Strategy;

class ConfigSynchronizing implements Synchronizing
{
	const TYPE_FILE_SYSTEM = 'fileSystem';
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var PimcoreApi
	 */
	private $api;

	/**
	 * @var FileSystemStrategy
	 */
	private $fileSystemStrategy;

	/**
	 * @var Strategy
	 */
	private $strategy;

	/**
	 * @var string
	 */
	private $rootPath;

	/**
	 * @param array|null $config
	 * @param PimcoreApi $api
	 * @param FileSystemStrategy $fileSystemStrategy
	 */
	public function __construct(
		$config,
		PimcoreApi $api,
		FileSystemStrategy $fileSystemStrategy
	)
	{
		$this->config = $config;
		$this->api = $api;
		$this->fileSystemStrategy = $fileSystemStrategy;
	}

	public function synchronize($rootPath)
	{
		$this->failIfConfigIsMissing();
		$this->chooseStrategyOrFail();

		$this->rootPath = $rootPath;

		$this->doSync();
	}

	public function getDocumentByPath($path)
	{
		$this->failIfConfigIsMissing();
		$this->chooseStrategyOrFail();

		return $this->strategy->getDocumentByPath($path);
	}

	private function doSync()
	{
		$this->strategy->beforeSync();

		$this->loadPath($this->rootPath);

		$this->strategy->afterSync();
	}

	private function loadPath($path)
	{
		$searchResponse = $this->api->call(DocumentSearch::with()
			->condition(
				sprintf(
					'`path` = \'%s\'',
					Helper::correctDocumentPath($path)
				)
			)
			->orderKey('index')
			->order('ASC')
		);

		if ($searchResponse->isSuccess() && ($objectInfos = $searchResponse->getData()))
		{
			foreach ($objectInfos as $objectInfo)
			{
				$document = $this->getById($objectInfo->getId())->getData();

				$this->strategy->persistDocument($document);

				$this->loadPath($document->getPath() . $document->getKey());
			}
		}
	}

	private function getById($documentId)
	{
		return $this->api->call(GetDocumentById::with()->documentId($documentId));
	}

	private function chooseStrategyOrFail()
	{
		$strategy = null;

		switch($this->config['type'])
		{
			case self::TYPE_FILE_SYSTEM:
				$strategy = $this->fileSystemStrategy;
		}

		if (!$strategy)
		{
			throw new Exception('Unknown synchronizing type');
		}

		$strategy->setConfig($this->config);

		$this->strategy = $strategy;
	}

	private function failIfConfigIsMissing()
	{
		if (!$this->config)
		{
			throw new Exception('Synchronizing config is missing');
		}
	}
}