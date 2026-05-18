<?php

namespace Irimold\LaravelCore;

use Illuminate\Support\ServiceProvider;
use Irimold\LaravelCore\Console\Commands\ConstantMakeCommand;
use Irimold\LaravelCore\Console\Commands\LogicMakeCommand;
use Irimold\LaravelCore\Console\Commands\ScheduleMakeCommand;

class IriServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ConstantMakeCommand::class,
                LogicMakeCommand::class,
                ScheduleMakeCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/Console/Commands/stubs/constant.stub'   => base_path('stubs/constant.stub'),
            __DIR__ . '/Console/Commands/stubs/logic.stub'      => base_path('stubs/logic.stub'),
            __DIR__ . '/Console/Commands/stubs/schedule.stub'   => base_path('stubs/schedule.stub'),
        ], 'stubs');
    }
}