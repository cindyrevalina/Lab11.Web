<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class Artikel extends BaseController
{
    // Frontend: menampilkan semua artikel di /artikel
    public function index()
    {
        $model = new ArtikelModel();
        $data['artikels'] = $model->findAll();
        return view('artikel', $data);
    }
    
    // Frontend: menampilkan detail artikel (kalau perlu)
    public function view($slug)
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->where('slug', $slug)->first();
        return view('artikel_detail', $data);
    }
    
    // Admin: menampilkan semua artikel dengan tombol edit/hapus
    public function admin_index()
    {
        $model = new ArtikelModel();
        $data['artikels'] = $model->findAll();
        return view('admin/artikel_index', $data);
    }
    
    // Admin: form tambah & proses simpan artikel
    public function add()
    {
        $model = new ArtikelModel();
        
        // Jika ada data POST, berarti proses simpan
        if ($this->request->getMethod() === 'post') {
            $slug = url_title($this->request->getPost('judul'), '-', true);
            
            $model->save([
                'judul' => $this->request->getPost('judul'),
                'slug' => $slug,
                'isi' => $this->request->getPost('isi'),
            ]);
            
            return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil ditambahkan!');
        }
        
        // Jika GET, tampilkan form tambah
        return view('admin/artikel_form');
    }
    
    // Admin: form edit & proses update artikel
    public function edit($slug)
    {
        $model = new ArtikelModel();
        
        // Jika ada data POST, berarti proses update
        if ($this->request->getMethod() === 'post') {
            $id = $this->request->getPost('id');
            $newSlug = url_title($this->request->getPost('judul'), '-', true);
            
            $model->update($id, [
                'judul' => $this->request->getPost('judul'),
                'slug' => $newSlug,
                'isi' => $this->request->getPost('isi'),
            ]);
            
            return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil diupdate!');
        }
        
        // Jika GET, tampilkan form edit dengan data lama
        $data['artikel'] = $model->where('slug', $slug)->first();
        return view('admin/artikel_form', $data);
    }
    
    // Admin: hapus artikel
    public function delete($slug)
    {
        $model = new ArtikelModel();
        $model->where('slug', $slug)->delete();
        
        return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil dihapus!');
    }
}