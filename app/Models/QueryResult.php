<?php

/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 26/10/2018
 * Time: 23:28
 */

namespace App\Models;

class QueryResult {

	public $items;

	public $totalResults;

	public $hasMore;

	public function __construct($items = array(), $totalResults = null, $hasMore = false) {

		$this->items = $items;

		$this->totalResults = $totalResults;

		$this->hasMore = $hasMore;

	}

}