<?php
namespace Unittests\NextPrev;

use Database\DbObject as Db;
use \Database\Models\Item;
use Unittests\LocalTestcase;
use \Trace;

// phpcs:disable 

class MonthsTest extends LocalTestcase
{
	function setUp()
	{
		global $config;
		Db::init($config);
		$db = Db::get_instance();
	}
	function testBothExist()
	{
		$result = Item::get_by_slug('130417');

		$next = $result->next(array("months"=>"2013-04"));
		$prev = $result->prev(array("months"=>"2013-04"));
		$this->assertEqual($next->slug, "130418");
		$this->assertEqual($prev->slug, "130416");
	}
	function testNoPrev()
	{
		$result = Item::get_by_slug('vladivostok');
		$next = $result->next(array("months"=>"2013-10"));
		$prev = $result->prev(array("months"=>"2013-10"));

		// this is off the end but keeps going
		// print "<p>prev off end {$prev->slug}<p/>";
		$this->assertFalse( is_null($prev));
		$this->assertEqual($prev->slug, "whatsbeenhappening");
		$this->assertEqual($next->slug, "130407");
	}
	function testNoNext()
	{
		$result = Item::get_by_slug('130427B');
		$next = $result->next(array("months"=>"2013-04"));
		$prev = $result->prev(array("months"=>"2013-04"));
		$this->assertEqual($prev->slug, "130427");

		// this is off the end but keeps going
		$this->assertFalse( is_null($next));
		$this->assertEqual($next->slug, "130428");

		// print "<p>next off end {$next->slug}<p/>";
	}
}


?>