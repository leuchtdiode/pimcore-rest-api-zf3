<?php
namespace PimcoreRestApi\Service;

interface Synchronizing
{
	public function synchronize($rootPath);

	public function getDocumentByPath($path);
}