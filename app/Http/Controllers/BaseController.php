<?php

namespace App\Http\Controllers;

use Symfony\Component\Routing\RequestContext;

class BaseController
{
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