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
            'APP_NAME' => $_SESSION['information']['name'],
            'APP_URL' => $_SESSION['information']['url'],
            'DB_DATABASE' => $_SESSION['information']['db_name'],
            'DB_USERNAME' => $_SESSION['information']['db_user'],
            'DB_PASSWORD' => $_SESSION['information']['db_user_password'],
            'MAIL_DRIVER' => 'smtp',
            'MAIL_HOST' => $_SESSION['information']['email_host'],
            'MAIL_PORT' => $_SESSION['information']['email_port'],
            'MAIL_USERNAME' => $_SESSION['information']['email_user'],
            'MAIL_PASSWORD' => $_SESSION['information']['email_user_password'],
            'MAIL_FROM_ADDRESS' => $_SESSION['information']['email_from_address'],
            'MAIL_FROM_NAME' => $_SESSION['information']['email_from_name'],
            'MAIL_ENCRYPTION' => $_SESSION['information']['email_encryption'],
        ]);

        return json_encode([
            'status' => 'OK',
            'message' => 'Setup Finished'
        ]);
    }

    public function setupInformation()
    {
        session_start();

        $_SESSION['information'] = $_POST;

        return view('information-setup.html.twig');
    }

    public function done()
    {
        return view('done.html.twig');
    }
}