<?php
namespace Unittests\Model;

use \Database as Database;
use Database\DbObject as Db;
use Unittests\LocalTestcase;
use \Trace as Trace;
use \DbPreloader as DbPreloader;

// phpcs:disable


class BannersTest extends LocalTestcase
{
	public function setUp()
	{
		global $config;
		Db::init($config);
		$db = Db::get_instance();
		// $this->load_database();
		$this->test_trip = "rtw";
		$this->test_slug = "active";
	}
	function assert_test_banner($result)
	{
		assert($result !== null, "Banner test - rtw/active not found");
		$this->assertEqual($result->version, "2.0");
		$this->assertEqual($result->type, "banner");
		$this->assertEqual($result->slug, "active");
		$this->assertEqual($result->status, "draft");
		$this->assertEqual($result->trip, "rtw");
		$this->assertEqual($result->creation_date, "2014-02-06");
		$this->assertEqual($result->published_date, "2014-02-06");
		$this->assertEqual($result->last_modified_date, "2014-02-06");

		// $this->assertNotEqual($result->content_path, null);
		// $this->assertNotEqual($result->entity_path, null);

		$this->assertEquals(count($result->getImages()), 17);
	}
	function testGetByTripSlug()
	{
		// print "Lets get started\n";
		$result = Database\Models\Banner::get_by_trip_slug($this->test_trip, $this->test_slug);
		$this->assert_test_banner($result);
	}
	function testGetBySlug()
	{
		$result = Database\Models\Banner::get_by_slug($this->test_slug);
	}

	function testCreateWithSkeleton()
	{
		$trip = 'rtw';
		$slug='170707';
		$edate = '2017-07-07';
		$p1 = dirname(__FILE__)."/output2/content_2.php";
		$p2 = dirname(__FILE__)."/correct_content_2.php";
		$verbose = "";// set to "v" to get output
		// print system("rm -Rv ".dirname(__FILE__)."/output");
		$oput = system("rm -R{$verbose} ".dirname(__FILE__)."/output2");
		// print $oput."\n";
		// \Database\HED\HEDFactory::create_banner(dirname(__FILE__)."/output/content.php", $trip, $slug, $edate, $de);
		$hed_obj = \Database\HED\Skeleton::make_banner($p1, $trip, $slug, $edate, "AN_IMAGE_URL");
		$x = file_get_contents($p1);
		// print $x;
		$this->assertEqual(file_get_contents($p1), file_get_contents($p2));

		$model = \Database\Models\Factory::model_from_hed($hed_obj);

		// var_dump($model);

	}

	function testInsertDelete()
	{
		$r = Database\Models\Banner::get_by_slug($this->test_slug);
		$this->assertNotEqual($r, null);
		$this->assert_test_banner($r);

		$r->sql_delete();
		$r = Database\Models\Banner::get_by_slug($this->test_slug);
		$this->assertEqual($r, null);

		$new_r = Database\Models\Banner::get_by_trip_slug($this->test_trip, $this->test_slug);
		$new_r->sql_insert();

		$r2 = Database\Models\Banner::get_by_slug($this->test_slug);
		$this->assertNotEqual($r2, null);
		$this->assert_test_banner($r2);
	}


	function testImportExport()
	{
		// confirm we have the test album
		$result = Database\Models\Banner::get_by_slug($this->test_slug);
		$this->assert_test_banner($result);
		$util = new \Database\Utility();

		$util->deport_banner($this->test_slug);
		// no prove its gone
		$result = Database\Models\Banner::get_by_slug($this->test_slug);
		$this->assertEqual($result, null);

		$util->import_banner($this->test_trip, $this->test_slug);
		// now prove its back with all its data
		$result = Database\Models\Banner::get_by_slug($this->test_slug);
		$this->assert_test_banner($result);

	}
	function testGetLatestBanner()
	{
		$result = Database\Models\Banner::find_latest_for_trip($this->test_trip);
		// var_dump($result);
		$s = get_class($result);
		$this->assert_equals(get_class($result), "Database\Models\Banner");
	}
}
