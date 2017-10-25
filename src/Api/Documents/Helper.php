<?php
namespace PimcoreRestApi\Api\Documents;

class Helper
{
	public static function correctDocumentPath($path)
	{
		if (substr($path, -1) != '/')
		{
			$path .= '/';
		}

		return $path;
	}
}