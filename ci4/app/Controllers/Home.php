<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('template/header')
             . view('home')
             . view('template/footer');
    }
    
    public function about()
    {
        return view('template/header')
             . view('about')
             . view('template/footer');
    }
    
    public function kontak()
    {
        return view('template/header')
             . view('kontak')
             . view('template/footer');
    }
}