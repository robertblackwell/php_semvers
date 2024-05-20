<?php
namespace Unittests\CategorizedItem;

use \Database as Database;
use Database\DbObject as Db;
use Database\Models\CategorizedItem;
use Database\Models\TripCategory;
use Unittests\LocalTestcase;
use \DbPreloader as DbPreloader;
use \Trace as Trace;

// phpcs:disable

class AddRemoveTest extends LocalTestcase
{
	function setUp()
	{
		global $config;
		Db::init($config);
		DbPreloader::load();
		$db = Db::get_instance();
//        var_dump($db);exit();
	}
	// function test_1()
	// {
	
	// 	$this->assertFalse(CategorizedItem::exists("my_category_test", "thefirstrtw"));
	// 	CategorizedItem::add('my_category_test', "thefirstrtw");
	// 	$this->assertTrue(CategorizedItem::exists("my_category_test", "thefirstrtw"));
	// 	CategorizedItem::delete('my_category_test', "thefirstrtw");
	// 	$this->assertFalse(CategorizedItem::exists("my_category_test", "thefirstrtw"));
	// 	//Category::remove("my_category_test");
	// }
	function test_2()
	{
	
		$this->assertFalse(CategorizedItem::exists("my_category_test", "130417"));
		$this->assertFalse(CategorizedItem::exists("my_category_test", "120705"));
		CategorizedItem::add('my_category_test', "130417");
		CategorizedItem::add('my_category_test', "120705");
		$this->assertTrue(TripCategory::exists('my_category_test'));
		$this->assertTrue(CategorizedItem::exists("my_category_test", "130417"));
		$this->assertTrue(CategorizedItem::exists("my_category_test", "120705"));
		
		CategorizedItem::delete_slug("130417");
		
		$this->assertFalse(CategorizedItem::exists("my_category_test", "130417"));//one relatonship removed
		$this->assertTrue(CategorizedItem::exists("my_category_test", "120705"));//other one still there
		$this->assertTrue(TripCategory::exists('my_category_test'));

		CategorizedItem::delete_slug("120705");
	
		$this->assertFalse(CategorizedItem::exists("my_category_test", "130417"));//both relationships now removed
		$this->assertFalse(CategorizedItem::exists("my_category_test", "120705"));
		$this->assertFalse(TripCategory::exists('my_category_test'));
		/*
		** The next test is not implemented because I know that unused categories are not cleaned out of the
		** category table
		*/
		//$this->assertFalse($this->category_exists("my_category_test"));//and the category as nothing else referes to it
		//Category::remove("my_category_test");
	}
}
