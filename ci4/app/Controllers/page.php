<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function home()
    {
        return view('layout/template', [
            'heading' => 'Halaman Home',
            'content' => 'Selamat datang di website kami. Ini adalah halaman utama.'
        ]);
    }

    public function artikel()
    {
        return view('layout/template', [
            'heading' => 'Halaman Artikel',
            'content' => 'Selamat datang di halaman artikel. Silahkan baca artikel-artikel menarik kami.'
        ]);
    }

    public function about()
    {
        return view('layout/template', [
            'heading' => 'Halaman About',
            'content' => 'Ini adalah halaman about yang menjelaskan tentang isi halaman ini.'
        ]);
    }

    public function kontak()
    {
        return view('layout/template', [
            'heading' => 'Halaman Kontak',
            'content' => 'Hubungi kami di: email@example.com | Telepon: (021) 123456789'
        ]);
    }
}