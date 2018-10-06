<?php

namespace Qh\Twig\Console;

use RuntimeException;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ViewTwigClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:twig:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all compiled twig view files';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = $this->laravel['config']['twig.compiled'];

        if ($this->files->exists($path)) {
            $this->files->deleteDirectories($path);
        } else {
            $this->files->makeDirectory($path, 0755, true);
        }

        $this->info('Compiled twig views cleared!');
    }
}
