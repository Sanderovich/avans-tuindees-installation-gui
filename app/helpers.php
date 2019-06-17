<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/../vendor/autoload.php';

if (!function_exists("view")) {
    /**
     * Render a Twig template
     *
     * @param string $path
     * @param array $data
     * @return void
     */
    function view(string $path, array $data = []): void
    {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $twig = new Environment($loader);

        try {
            $twig->display($path, $data);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}

if (!function_exists("assets")) {
    /**
     * Return assets path
     *
     * @param string $path
     */
    function assets(string $path)
    {

    }
}

if (!function_exists('runCommand')) {

    /**
     * Run a command, optionally in a given working directory.
     *
     * @param string $command The command to run.
     * @param string $cwd The working directory.
     */
    function runCommand(string $command, string $cwd = ''): void
    {
        $run = '';

        if ($cwd !== '') {
            $run = "cd ${cwd} && ";
        }

        $run .= $command;

        exec($run);
    }
}

if (!function_exists('changeEnv')) {

    /**
     * Change the .env with this function.
     *
     * Stolen from: https://laravel-tricks.com/tricks/change-the-env-dynamically and edited a bit.
     *
     * @param string $installDirectory
     * @param array $data
     * @return bool
     */
    function changeEnv(string $installDirectory, array $data = [])
    {
        if (count($data) > 0) {
            // Read .env-file
            $env = file_get_contents($installDirectory . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach ((array) $data as $key => $value) {

                // Loop through .env-data
                foreach ($env as $env_key => $env_value) {

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if ($entry[0] == $key) {
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . "\"" . $value . "\"";
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents($installDirectory . '/.env', $env);

            return true;
        } else {
            return false;
        }
    }
}