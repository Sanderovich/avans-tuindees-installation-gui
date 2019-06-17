<?php

namespace App\Http\Controllers;

class BaseController
{
    public function foo()
    {
        return view("welcome.html.twig");
    }
}