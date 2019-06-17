<?php

namespace App\Http\Controllers;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Routing\RequestContext;

class BaseController
{
    /** @var string $installDirectory The directory where the site will be installed. */
    private $installDirectory;

    public function index()
    {
        return view("welcome.html.twig");
    }

    public function initialSetup()
    {
        return view("initial-setup.html.twig");
    }

    public function startInitialSetup()
    {
        $this->installDirectory = $_SESSION['information']['install-folder'] ?? './../test';

        // Delete old dir
        runCommand('rm -rf ' . $this->installDirectory);

        // Pull the Git repository
        runCommand('git clone https://github.com/stevenliebregt/tuindees-install-gui-test-repo.git ' . $this->installDirectory);

        // Run Composer and NPM
        runCommand('composer install', $this->installDirectory);
        runCommand('npm install', $this->installDirectory);
        runCommand('npm run prod', $this->installDirectory);

        // Create necessary directories
        $directories = [
            'storage/app',
            'storage/app/public',
            'storage/logs',
            'storage/framework',
            'storage/framework/cache',
            'storage/framework/views',
            'storage/framework/sessions',
            'storage/framework/testing',
        ];

        foreach ($directories as $directory) {
            if (!is_dir($this->installDirectory . '/' . $directory)) {
                mkdir($this->installDirectory . '/' . $directory, 0777, true);
            }
        }

        return json_encode([
            'status' => 'OK',
            'message' => 'Setup Finished'
        ]);
    }

    public function information()
    {
        return view("information.html.twig");
    }

    public function startInformationSetup()
    {
        // Copy .env
        copy($this->installDirectory . '/.env.exampmle', $this->installDirectory . '/.env');

        // Update .env
        changeEnv($this->installDirectory, [
            'KEY' => 'NEW_VALUE',
        ]);

        return json_encode([
            'status' => 'OK',
            'message' => 'Setup Finished'
        ]);
    }

    public function setupInformation()
    {
        var_dump($_POST);
        return "";
    }

    public function done()
    {
        return view('done.html.twig');
    }
}