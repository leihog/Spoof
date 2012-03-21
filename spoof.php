<?php

require_once 'spoofable.php';

class Spoof
{
	public static $mocks = array();
	public static $mockMethods = array();

	public static function register( $class, $methods = array() )
	{
		//$mockClassName = md5($class . serialize($methods));
		$mockClassName = "{$class}Mock";
		if ( !class_exists($mockClassName, false) )
		{
			$classDefinition = "class {$mockClassName} extends Spoofable {}";
			eval( $classDefinition );
		}

		self::$mocks[$class] = $mockClassName;
		self::$mockMethods[$mockClassName] = $methods;
	}

	public static function instanceMethods($obj, $methods = array())
	{
		$rc = new ReflectionClass( get_class($obj) );
		$rp = $rc->getProperty('methods');
		$rp->setAccessible(true);
		$rp->setValue($obj, $methods);
		$rp->setAccessible(false);
	}

	public static function loader($class)
	{
		if ( isset(self::$mocks[$class]) )
		{
			return self::$mocks[$class];
		}
		return $class;
	}
}
