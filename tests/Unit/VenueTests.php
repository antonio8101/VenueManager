<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 14/10/2018
 * Time: 09:43
 */

namespace Tests\Unit;

use App\Facades\VenueFactory;
use App\Http\Controllers\Api\VenueController;
use App\Models\IDomainObjectFactory;
use App\Models\Venue;

use Tests\TestCase;

class VenueTests extends TestCase {}

class VenueControllerTests extends VenueTests {

	public function testInflateObject() {

		$factoryMock = $this->getMockBuilder('App\Models\VenueFactory')
		                    ->setMethods(array('get'))
		                    ->getMock();

		$service = new VenueController($factoryMock);

		$expectedValue       = 11;
		$notMatchingProperty = "notToBeInflatedProperty";

		$result = $service->InflateObject( [
			'test'                    => $expectedValue,
			'notToBeInflatedProperty' => 'foo'
		], new class {
			public $test;
		} );

		$this->assertTrue( true );
		$this->assertThat( $result->test, $this->equalTo( $expectedValue ), "Object MUST contains matching property" );
		$this->assertObjectNotHasAttribute( $notMatchingProperty, $result, "Object MUST not contains ANY non-matching property" );
	}

	public function testCreateVenueCommand(){

		$factoryMock = $this->getMockBuilder('App\Models\VenueFactory')
							->setMethods(array('get'))
		                    ->getMock();

		$service = new VenueController($factoryMock);

		$venueMock = $this->getMockBuilder('Venue')
		                         ->setMethods(array('save', 'create'))
		                         ->getMock();

		$venueMock->method('create')->willReturn("venueid");
		$factoryMock->method('get')->willReturn($venueMock);

		$venueMock->expects($this->atLeast(1))->method('save');

		$service->createVenueCommand([
			'name' => 'venue test name',
			'city' => 'Milano',
			'street' => 'via Tal dei Tali 1',
			'zip' => '20100'
		]);

	}

	public function testVenueCanUseFactoryWithFacade(){

		VenueFactory::shouldReceive('get')->with('id')->andReturn(new Venue());

		$venue = Venue::find("id");

		$this->assertThat($venue, !$this->isNull());
	}


}