<?php

namespace Irimold\LaravelCore\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Irimold\LaravelCore\Console\Commands\Concerns\WithStubResolver;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:constant', description: 'Create a new constant')]
class ConstantMakeCommand extends GeneratorCommand
{
    use WithStubResolver;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:constant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new constant';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Constant';

    
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/constant.stub');
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
        return "{$rootNamespace}\\Constants";
    }
}