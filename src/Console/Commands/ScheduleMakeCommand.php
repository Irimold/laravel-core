<?php

namespace Irimold\LaravelCore\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Irimold\LaravelCore\Console\Commands\Concerns\WithStubResolver;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:schedule', description: 'Create a new schedule')]
class ScheduleMakeCommand extends GeneratorCommand
{
    use WithStubResolver;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new schedule handler';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Schedule';

    
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/schedule.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    #[Override]
    protected function getDefaultNamespace($rootNamespace)
    {
        return "{$rootNamespace}\\Console\\Schedules";
    }

}