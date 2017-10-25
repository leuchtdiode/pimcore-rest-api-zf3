<?php
namespace PimcoreRestApi;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class FileSystemHelper
{
	/**
	 * @param $path
	 */
	public static function deleteDirectoryRecursively($path)
	{
		if (!file_exists($path))
		{
			return;
		}

		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::CHILD_FIRST
		);

		foreach ($files as $fileInfo) {
			$todo = ($fileInfo->isDir() ? 'rmdir' : 'unlink');
			$todo($fileInfo->getRealPath());
		}

		rmdir($path);
	}

	/**
	 * @param $path
	 * @param $content
	 * @return int
	 */
	public static function writeToFile($path, $content)
	{
		return file_put_contents($path, $content);
	}

	/**
	 * @param $source
	 * @param $destination
	 */
	public static function move($source, $destination)
	{
		rename($source, $destination);
	}

	/**
	 * @param $path
	 * @return bool
	 */
	public static function pathExists($path)
	{
		return file_exists($path);
	}

	/**
	 * @param $path
	 */
	public static function createDirectoryRecursively($path)
	{
		if (!self::pathExists($path))
		{
			mkdir($path, 0775, true);
		}
	}
}