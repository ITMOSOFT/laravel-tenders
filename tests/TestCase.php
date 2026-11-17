<?php
namespace ITMOSOFT\Tenders\Tests;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use ITMOSOFT\Tenders\TendersServiceProvider;
abstract class TestCase extends Orchestra {
 protected function getPackageProviders($app): array { return [TendersServiceProvider::class]; }
 protected function defineEnvironment($app): void {
  $app['config']->set('database.default','testing');
  $app['config']->set('database.connections.testing',['driver'=>'sqlite','database'=>':memory:','prefix'=>'','foreign_key_constraints'=>true]);
 }
 protected function setUp(): void {
  parent::setUp();
  $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
  Schema::create('users', function(Blueprint $table): void { $table->id(); $table->string('name'); $table->timestamps(); });
 }
}
