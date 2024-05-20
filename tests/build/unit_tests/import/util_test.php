<?php
namespace Unittests\Utility;

use Database\DbObject as Db;
use Database\Models\Item as Item;
use Database\Models\Album as Album;
use Database\Utility as Utility;
use \Trace as Trace;
use Unittests\LocalTestcase;
use \DbPreloader;

// phpcs:disable

class DeportImportTest extends LocalTestcase
{
	function setUp()
	{
        global $config;
		Db::init($config);
		\DbPreloader::load();
		$this->db = Db::get_instance();
        $this->locator = \Database\Locator::get_instance();
        $this->utility = new Utility();
	}
	function testAlbum()
	{
	    $slug = "scotland";
	    $r = Album::get_by_slug($slug);
	    $this->assertNotEqual($r, null);
	    $trip = $r->trip;
	        
	    $this->utility->deport_album($slug);
	    
        $r = Album::get_by_slug($slug);
	    $this->assertEqual($r, null);

        $this->utility->import_album($trip, $slug);
        
	    $r = Album::get_by_slug($slug);
	    $this->assertNotEqual($r, null);
	}
	function testArticle()
	{
	    $slug = "tires";
	    $r = Item::get_by_slug($slug);
	    $this->assertNotEqual($r, null);
	    $trip = $r->trip;
	        
	    $this->utility->deport_item($slug);
	    
        $r = Item::get_by_slug($slug);
	    $this->assertEqual($r, null);

        $this->utility->import_item($trip, $slug);
        
	    $r = Item::get_by_slug($slug);
	    $this->assertNotEqual($r, null);
	}
	function testEntry()
	{
	    $slug = "130417";
	    $r = Item::get_by_slug($slug);
	    $this->assertNotEqual($r, null);
		$trip = $r->trip;	        
	    $this->utility->deport_item($slug);
	    
        $r = Item::get_by_slug($slug);
	    $this->assertEqual($r, null);

        $x = $this->utility->import_item($trip, $slug);
        // var_dump($x);
	    $r = Item::get_by_slug($slug);
	    $this->assertNotEqual($r, null);
	}
	function testPost()
	{
	    $r = Item::get_by_slug('electricalpart1');
	    $this->assertNotEqual($r, null);
 		$trip = $r->trip;   
	    $this->utility->deport_item('electricalpart1');
	    
        $r = Item::get_by_slug('electricalpart1');
	    $this->assertEqual($r, null);

        $this->utility->import_item($trip, 'electricalpart1');
        
	    $r = Item::get_by_slug('electricalpart1');
	    $this->assertNotEqual($r, null);
	}
}
