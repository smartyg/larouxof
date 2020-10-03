<?php

namespace LaRouxOf\Test\Traits;

trait dataSet1
{
	protected static function getTestSet(): array
	{
		return array(
			'pages' => __DIR__ . '/../../data-sets/pagesSet1.csv',
			'items' => __DIR__ . '/../../data-sets/itemsSet1.csv',
			'content' => __DIR__ . '/../../data-sets/contentSet1.csv',
			'images' => __DIR__ . '/../../data-sets/imagesSet1.csv',
		);
	}
}

?>