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