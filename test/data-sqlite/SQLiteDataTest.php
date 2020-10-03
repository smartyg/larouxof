<?php

namespace LaRouxOf\Test;

require_once __DIR__ . "/../autoloader.php";

class TestPage extends \PHPUnit\Framework\TestCase
{
	use Traits\testLoadPage;
	use Traits\testLoadPageGetTitle;
	use Traits\testLoadPageGetCategory;
	use Traits\testLoadPageGetLink;
	use Traits\testLoadPageIsDynamicLoadable;
	use Traits\testLoadPageToHTML;
	use Traits\testLoadPageId;
/*
	use Traits\testLoadGallery;
	use Traits\testLoadGalleryGetTitle;
	use Traits\testLoadGalleryGetCategory;
	use Traits\testLoadGalleryGetLink;
	use Traits\testLoadGalleryIsDynamicLoadable;
	use Traits\testLoadGalleryToHTML;
	use Traits\testLoadGalleryGetItems;
	use Traits\testLoadGalleryId;

	use Traits\testLoadItem;
	use Traits\testLoadItemGetTitle;
	use Traits\testLoadItemGetCategory;
	use Traits\testLoadItemIsDynamicLoadable;
	use Traits\testLoadItemGetLink;
	use Traits\testLoadItemGetImage;
	use Traits\testLoadItemGetItem;
	use Traits\testLoadItemGetNumOfImages;
	use Traits\testLoadItemGetPrice;
	use Traits\testLoadItemGetId;
	use Traits\testLoadItemToHTML;
	use Traits\testLoadItemId;
*/
	use Traits\databaseTesterSQLite;

	use Traits\dataSet1;
}

?>