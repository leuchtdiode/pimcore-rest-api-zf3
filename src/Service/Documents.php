<?php
namespace PimcoreRestApi\Service;

use PimcoreRestApi\Api\Documents\Document;

interface Documents
{
	/**
	 * @param $documentId
	 * @return Document|null
	 */
	public function getById($documentId);

	/**
	 * @param $documentPath
	 * @return Document|null
	 */
	public function getByPath($documentPath);

	/**
	 * @param $path
	 * @return Document[]
	 */
	public function getAllByPath($path);
}