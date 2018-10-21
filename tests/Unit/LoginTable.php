<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 21/10/2018
 * Time: 20:12
 */

namespace Tests\Unit;

use Tests\TestCase;

class LoginTable extends TestCase {

	public function testSpecifiedAssignment(){

		$duration = \App\Models\LoginTable::getExpiration(0);

		$this->assertThat($duration, $this->equalTo(0));
	}

	public function testDefaultAssignment(){

		$duration = \App\Models\LoginTable::getExpiration();

		$sessionLifeTime = env('SESSION_LIFETIME') * 60 * 1000;

		$this->assertThat($duration, $this->equalTo($sessionLifeTime));

	}

}