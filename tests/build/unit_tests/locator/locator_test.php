<?php
namespace Unittests\Locator;

use Database\Locator as Locator;
use Unittests\LocalTestcase;

// phpcs:disable

class LocatorTest extends LocalTestcase
{
	function setUp()
	{
		global $config;
		//var_dump($config);
		Locator::init($config['hed']);
	}
	// We create a locator object
	function testCreateLocator()
	{
		$locator = Locator::get_instance();
		$this->assertNotEqual($locator, null);
		$this->assertEqual(get_class($locator), "Database\Locator");
		
	}
	// Test content item path methods
	function testItemPath()
	{
		$locator = Locator::get_instance();
		$d = $locator->item_dir('rtw', 'slug');
		$this->assertEqual($d, \UnitTestRegistry::$package_dir."/tests/test_data/data/rtw/content/slug");
		$d = $locator->item_relative_dir('rtw', 'slug');
		$this->assertEqual($d, "/data/rtw/content/slug");
		$d = $locator->item_filepath('rtw', 'slug');
		$this->assertEqual($d, \UnitTestRegistry::$package_dir."/tests/test_data/data/rtw/content/slug/content.php");
		
	}
	// Test content item URL methods
	function testItemUrl()
	{
		$locator = Locator::get_instance();
		$d = $locator->url_item_dir('rtw', 'slug');
		$this->assertEqual($d, "/data/rtw/content/slug");
		$d = $locator->url_item_thumbnail('rtw', 'slug', 'gal','img' );
		$this->assertEqual($d, "/data/rtw/content/slug/gal/Thumbnails/img");
		$d = $locator->url_item_attachment('rtw', 'slug', 'ref');
		$this->assertEqual($d, "/data/rtw/content/slug/ref");
		
	}
	// Test album path methods
	function testAlbumPath()
	{
		$locator = Locator::get_instance();
		$d = $locator->album_dir('rtw', 'slug');
		$this->assertEqual($d, \UnitTestRegistry::$package_dir."/tests/test_data/data/rtw/photos/galleries/slug");
		$d = $locator->album_relative_dir('rtw', 'slug');
		$this->assertEqual($d, "/data/rtw/photos/galleries/slug");
		$d = $locator->album_filepath('rtw', 'slug');
		$this->assertEqual($d, \UnitTestRegistry::$package_dir."/tests/test_data/data/rtw/photos/galleries/slug/content.php");
		
	}
	// Test content item URL methods
	function testAlbumUrl()
	{
		$locator = Locator::get_instance();
		$d = $locator->url_album_dir('rtw', 'slug');
		$this->assertEqual($d, "/data/rtw/photos/galleries/slug");
		$d = $locator->url_album_thumbnail('rtw', 'slug', 'img' );
		$this->assertEqual($d, "/data/rtw/photos/galleries/slug/Thumbnails/img");
		$d = $locator->url_album_image('rtw', 'slug', 'img');
		$this->assertEqual($d, "/data/rtw/photos/galleries/slug/Images/img");
	}
}
