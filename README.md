
>Testing classes with hard coded dependencies can be difficult.
>Spoof tries to make that a little bit easier.

Wether we like it or not singletons and hard coded dependencies are very
common in PHP projects. When writing tests for such projects it's not
uncommon that we run in to a case where we need an external resource, such as a
database, because the code we want to test expects one to be present.

If the code relies on dependency injection then we can use getMock() to emulate
the resource, if not...
well that's where **Spoof** comes in to the picture.

Check out the example test in ExampleTest.php for an example of mocking a
singleton whose implementation we are uninterested in during the test.

**Known issues**

Because of the way singletons work you might run in to problems when mocking the singleton in one test and then expecting the actual singleton in another. Or vice versa.
In theory the PHPUnits attributes @preserveGlobalState, @runInSeparateProcess and runTestsInSeparateProcesses should be able to solve this problem (depending on your setup) but I have not confirmed that they do.

**See also**

There is no denying that **Spoof** is pretty awesome ;)
but if you're looking for more advanced mocking capabilities then you should have a look at [Mockery](https://github.com/padraic/mockery), it's quite impressive.


[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?url=https://github.com/leihog/Spoof&title=%53%70%6f%6f%66)
