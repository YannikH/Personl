<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Template;

class AddTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'template:add {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new PRS template';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('creating template ' . $this->argument('name'));
        $path = $this->ask('What path would you like to create the template on?');

        $split = explode('.', $path);
        $name = $split[count($split) - 1];
        $templateRoute = "";
        for ($i=0; $i < count($split) - 1; $i++) {
            $templateRoute = "\\" . $split[$i];
        }

        $viewPath = resource_path() . "\\views\\templates" . $templateRoute;
        if(!is_dir($viewPath)){
            $this->info('creating folder ' . $viewPath);
            mkdir($viewPath, 07777, true);
        }

        $publicPath = public_path() . "\\templates" . $templateRoute;
        if(!is_dir($publicPath)){
            $this->info('creating folder ' . $publicPath);
            mkdir($publicPath, 07777, true);
        }

        $this->info('creating template view');
        $template = fopen(resource_path() . "\\views\\templates" . $templateRoute . "\\$name.blade.php","w");
        fwrite($template, "@extends('templates.wrapper')" . PHP_EOL . PHP_EOL . 
            "@section('body')" . PHP_EOL . 
            "\t{{-- your html goes here --}}" . PHP_EOL . 
            "\t <h1>Hello World!</h1>" . PHP_EOL .
            "@stop");
        $this->info('creating template css and js');
        fopen(public_path() . "\\templates" . $templateRoute . "\\$name.css","w");
        fopen(public_path() . "\\templates" . $templateRoute . "\\$name.js","w");
        $this->info('template files generated');

        Template::create(['name' => $this->argument('name'), 'path' => $path]);
        
        $this->info('template registered in database');
    }
}
