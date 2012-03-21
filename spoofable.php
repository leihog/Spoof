<?php

abstract class Spoofable
{
	protected $methods;

	public function __construct()
	{
		$className = get_class($this);
		if ( isset(Spoof::$mockMethods[$className]) )
		{
			$this->methods = Spoof::$mockMethods[$className];
		}
	}

	public function __call($method, $args)
	{
		if ( isset($this->methods[$method]) )
		{
			$return = $this->methods[$method];
			if ( is_callable($return) )
			{
				return call_user_func_array($return, $args);
			}
			return $return;
		}
		return null;
	}
}
