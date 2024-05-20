<?php
namespace Unitests\FeaturedImage;

use Database\DbObject as Db;
use Database\Models\Item;
use Database\Models\Album;
use Database\Models\Entry;
use Database\HED\HEDObject;
use Database\HED\HEDFactory;
use Database\HED\Skeleton;
use Unittests\LocalTestcase;
use Database\Models\FeaturedImage;

// phpcs:disable

/**
* Tests that \Database\Models\FeaturedImage::getPath() correctly decodes featured image text 
* into path/url. 
*/
class FeaturedImageTest extends LocalTestcase
{
	function setUp()
	{
		global $config;
		Db::init($config);
	}
	/**
	* featured_image = "[2]"
	*/
	function testFromHEDDefaultGallery()
	{
		$p = dirname(__FILE__)."/data/featured_image_entry_1/content.php";
		$correct = dirname(__FILE__)."/data/featured_image_entry_1/Thumbnails/pict-3.jpg";
		$nobj = new HEDObject();
		$nobj->get_from_file($p);
		$fi1 = FeaturedImage::getPath($nobj);
		$this->assertEqual($fi1, $correct);
	}
	/**
	* featured_image = "[pict, 2]"
	*/
	function testFromHEDSpecificGallery()
	{
		$p = dirname(__FILE__)."/data/featured_image_entry_2/content.php";
		$correct = dirname(__FILE__)."/data/featured_image_entry_2/picts/Thumbnails/pict-3.jpg";
		$nobj = new HEDObject();
		$nobj->get_from_file($p);
		$fi1 = FeaturedImage::getPath($nobj);
		$this->assertEqual($fi1, $correct);
	}
	/**
	* featured_image = ""
	*/
	function testFromHEDBlank()
	{
		$p = dirname(__FILE__)."/data/featured_image_entry_3/content.php";
		$correct = dirname(__FILE__)."/data/featured_image_entry_3/Thumbnails/pict-1.jpg";
		$nobj = new HEDObject();
		$nobj->get_from_file($p);
		$fi1 = FeaturedImage::getPath($nobj);
		$this->assertEqual($fi1, $correct);
	}
	/**
	* featured_image = "picts/Thumbnails/pict-5.jpg"
	*/
	function testFromHEDPartialUrl()
	{
		$p = dirname(__FILE__)."/data/featured_image_entry_4/content.php";
		$correct = dirname(__FILE__)."/data/featured_image_entry_4/picts/Thumbnails/pict-5.jpg";
		$nobj = new HEDObject();
		$nobj->get_from_file($p);
		$fi1 = FeaturedImage::getPath($nobj);
		$this->assertEqual($fi1, $correct);
	}

}
