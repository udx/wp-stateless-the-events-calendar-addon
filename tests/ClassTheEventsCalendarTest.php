<?php

namespace WPSL\TheEventsCalendar;

use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;
use Brain\Monkey\Actions;
use Brain\Monkey\Filters;
use Brain\Monkey\Functions;
use wpCloud\StatelessMedia\WPStatelessStub;

/**
 * Class ClassTheEventsCalendarTest
 */

class ClassTheEventsCalendarTest extends TestCase {
  const TEST_SKIP_PATH = 'path/to/the-events-calendar/';
  const TEST_NOT_SKIP_PATH = 'path/to/something/';

  public static $backTracePath = '';

  // Adds Mockery expectations to the PHPUnit assertions count.
  use MockeryPHPUnitIntegration;

  public function setUp(): void {
		parent::setUp();
		Monkey\setUp();

    self::$backTracePath = self::TEST_SKIP_PATH;
  }
	
  public function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

  public function testShouldInitHooks() {
    $theEventsCalendar = new TheEventsCalendar();

    $theEventsCalendar->module_init([]);

    self::assertNotFalse( has_filter('stateless_skip_cache_busting', [ $theEventsCalendar, 'skip_cache_busting' ]) );
  }

  public function testShouldSkipCacheBusting() {
    $theEventsCalendar = new TheEventsCalendar();

    $this->assertEquals(
      self::TEST_SKIP_PATH,
      $theEventsCalendar->skip_cache_busting(null, self::TEST_SKIP_PATH) 
    );
  }

  public function testShouldNotSkipCacheBusting() {
    $theEventsCalendar = new TheEventsCalendar();

    self::$backTracePath = self::TEST_NOT_SKIP_PATH;

    $this->assertEquals(
      self::TEST_NOT_SKIP_PATH,
      $theEventsCalendar->skip_cache_busting(self::TEST_NOT_SKIP_PATH, null) 
    );
  }
}

function debug_backtrace() {
  return [
    7 => [
      'file' => ClassTheEventsCalendarTest::$backTracePath,
    ]
  ];
}