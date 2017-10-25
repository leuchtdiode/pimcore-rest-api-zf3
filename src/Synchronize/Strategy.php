<?php
namespace PimcoreRestApi\Synchronize;

use PimcoreRestApi\Api\Documents\Document;

interface Strategy
{
	public function beforeSync();

	public function persistDocument(Document $document);

	public function afterSync();

	public function getDocumentByPath($path);
}