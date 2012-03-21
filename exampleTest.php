<?php

include 'spoof.php';

class Store
{
	protected static $instance;

	public static function getInstance()
	{
		if ( !isset(self::$instance) )
		{
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function set($key, $value)
	{
		// writing to external storage
		echo "Original set called\n";
	}

	public function get($key)
	{
		// reading from external storage here
		echo "Original get called\n";
	}
}

class Foo
{
	public function getSomething()
	{
		return Store::getInstance()->get('foo');
	}

	public function doSomething($x)
	{
		$a = $this->getSomething();
		Store::getInstance()->set('foo', ($a * $x));
	}
}

class ExampleTests extends PHPUnit_Framework_TestCase
{
	public static function setUpBeforeClass()
	{
		set_new_overload( 'Spoof::loader' );
	}

	public static function tearDownAfterClass()
	{
		unset_new_overload();
	}

	public function testFoo()
	{
		Spoof::register( 'Store', array(
			'get' => 10,
		));

		$f = new Foo();
		$this->assertEquals( 10, $f->getSomething() );
	}

	public function testFooBar()
	{
		$store = array( 'foo' => 5 );
		Spoof::instanceMethods(Store::getInstance(), array(
			'get' => function($key) use(&$store){
				return $store[$key];
			},
			'set' => function($key, $value) use(&$store){
				$store[$key] = $value;
				return null;
			}
		));

		$f = new Foo();
		$f->doSomething(2);
		$this->assertEquals( 10, $f->getSomething() );
	}
}
