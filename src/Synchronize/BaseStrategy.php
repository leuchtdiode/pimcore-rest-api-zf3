<?php
namespace PimcoreRestApi\Synchronize;

abstract class BaseStrategy implements Strategy
{
	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @param array $config
	 */
	public function setConfig(array $config)
	{
		$this->config = $config;
	}
}