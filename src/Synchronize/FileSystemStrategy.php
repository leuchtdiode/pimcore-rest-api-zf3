<?php
namespace PimcoreRestApi\Synchronize;

use Exception;
use PimcoreRestApi\FileSystemHelper;
use PimcoreRestApi\Api\Documents\Document;

class FileSystemStrategy extends BaseStrategy
{
	/**
	 * @var string
	 */
	private $directory;

	/**
	 * @var string
	 */
	private $tempDirectory;

	public function beforeSync()
	{
		$this->setDirectoryOrFail();

		$this->tempDirectory = $this->directory . '-temp';

		FileSystemHelper::createDirectoryRecursively($this->directory);
		FileSystemHelper::deleteDirectoryRecursively($this->tempDirectory);
		FileSystemHelper::createDirectoryRecursively($this->tempDirectory);
	}

	public function persistDocument(Document $document)
	{
		FileSystemHelper::createDirectoryRecursively($this->tempDirectory . $document->getPath());

		$path =
			$this->tempDirectory
			. $document->getPath()
			. str_pad($document->getIndex(), 5, 0, STR_PAD_LEFT)
			. '-----'
			. $document->getKey()
			. '.ser';

		FileSystemHelper::writeToFile($path, serialize($document));
	}

	public function afterSync()
	{
		FileSystemHelper::deleteDirectoryRecursively($this->directory);
		FileSystemHelper::move($this->tempDirectory, $this->directory);
	}

	public function getDocumentByPath($path)
	{
		$this->setDirectoryOrFail();

		$pathInfo = pathinfo($path);

		$globPath = sprintf(
			'%s%s/*-----%s.ser',
			$this->directory,
			$pathInfo['dirname'],
			$pathInfo['filename']
		);

		$matchedFiles = glob($globPath);

		if (count($matchedFiles) != 1)
		{
			return null;
		}

		return unserialize(
			file_get_contents($matchedFiles[0])
		);
	}

	private function setDirectoryOrFail()
	{
		$this->directory = $this->config['directory'];

		if (!$this->directory)
		{
			throw new Exception('Directory must be specified');
		}
	}
}