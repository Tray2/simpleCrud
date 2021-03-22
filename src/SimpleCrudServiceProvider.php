<?php

namespace Tray2\SimpleCrud;

use Illuminate\Support\ServiceProvider;
use Tray2\SimpleCrud\Console\SimpleCrudCommand;

class SimpleCrudServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    //
  }

  public function boot(): void
  {
      if ($this->app->runningInConsole()) {
          $this->commands([
              SimpleCrudCommand::class,
          ]);
      }
  }
}