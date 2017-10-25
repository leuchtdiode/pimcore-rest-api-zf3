<?php
namespace PimcoreRestApi\Service;

use Exception;
use PimcoreRestApi\Api\Documents\Document;
use PimcoreRestApi\Api\Documents\GetDocumentById;
use PimcoreRestApi\Api\Documents\Helper;
use PimcoreRestApi\Api\Documents\Search as DocumentSearch;
use PimcoreRestApi\Api\PimcoreApi;

class ApiDocuments implements Documents
{
	/**
	 * @var PimcoreApi
	 */
	private $api;

	/**
	 * @var Synchronizing
	 */
	private $synchronizingService;

	/**
	 * @param PimcoreApi $api
	 * @param Synchronizing $synchronizingService
	 */
	public function __construct(
		PimcoreApi $api,
		Synchronizing $synchronizingService
	)
	{
		$this->api = $api;
		$this->synchronizingService = $synchronizingService;
	}

	/**
	 * @param string $documentPath
	 * @return Document
	 * @throws Exception
	 */
	public function getByPath($documentPath)
	{
		try
		{
			$syncedDocument = $this->synchronizingService->getDocumentByPath($documentPath);

			if($syncedDocument)
			{
				return $syncedDocument;
			}
		}
		catch (Exception $ex)
		{
			error_log($ex->getMessage());
		}

		$searchResponse = $this->api->call(DocumentSearch::with()
			->condition($this->makePathCondition($documentPath))
		);

		if ($searchResponse->isSuccess() && ($objectInfos = $searchResponse->getData()))
		{
			if (count($objectInfos) == 1)
			{
				return $this->getById(reset($objectInfos)->getId())->getData();
			}
		}

		throw new Exception('Could not find one document for path ' . $documentPath);
	}

	private function makePathCondition($fullPath)
	{
		$boom = explode('/', $fullPath);

		$path = '';

		foreach ($boom as $i => $pathPart)
		{
			if ($i < count($boom) - 1)
			{
				$path .= $pathPart . '/';
			}
		}

		return sprintf(
			'`path` = \'%s\' AND `key` = \'%s\'',
			$path,
			$boom[count($boom) - 1]
		);
	}

	public function getById($documentId)
	{
		return $this->api->call(GetDocumentById::with()->documentId($documentId));
	}

	public function getAllByPath($path)
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

		$documents = [ ];

		if ($searchResponse->isSuccess() && ($objectInfos = $searchResponse->getData()))
		{
			if (count($objectInfos) > 0)
			{
				foreach ($objectInfos as $objectInfo)
				{
					$documents[] = $this->getById($objectInfo->getId())->getData();
				}
			}
		}

		return $documents;
	}
}