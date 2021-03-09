<?php

namespace Tray2\SimpleCrud\Tests;

use Tray2\SimpleCrud\SimpleCrudServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    $this->app->setBasePath(__DIR__ . '/laravel');
    // additional setup
  }

  protected function getPackageProviders($app): array
  {
    return [
      SimpleCrudServiceProvider::class,
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
      $app['config']->set('database.default', 'mysql');
      $app['config']->set('database.connections.mysql', [
          'driver'   => 'mysql',
          'database' => 'mediabase',
          'prefix'   => '',
          'username' => 'root',
          'host' => '127.0.0.1'
      ]);
  }
}