<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Home | SPK Padi Terbaik',
        ];
        return view('welcome_message', $data);
    }
}
