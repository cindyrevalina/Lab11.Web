<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class Artikel extends BaseController
{
    public function index()
    {
        $model = new ArtikelModel();
        $artikels = $model->findAll();
        
        // Tampilan langsung di sini, gak usah pake file view terpisah
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Portal Berita</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: Arial; background: #f4f4f4; }
                .container { width: 80%; margin: auto; background: white; padding: 20px; margin-top: 20px; }
                header { background: #35424a; color: white; padding: 20px; text-align: center; }
                nav { background: #2c3e50; padding: 10px; text-align: center; }
                nav a { color: white; margin: 0 15px; text-decoration: none; }
                .main { display: flex; margin-top: 20px; }
                .articles { flex: 3; margin-right: 20px; }
                .sidebar { flex: 1; background: #f4f4f4; padding: 15px; }
                .artikel-item { border-bottom: 1px solid #ddd; padding: 15px 0; }
                .artikel-item h2 { color: #35424a; }
                .btn-admin { background: orange; color: white; padding: 10px; display: inline-block; margin-bottom: 20px; text-decoration: none; }
                footer { background: #35424a; color: white; text-align: center; padding: 15px; margin-top: 20px; }
                .form-tambah { background: #f9f9f9; padding: 20px; margin-bottom: 20px; border: 1px solid #ddd; }
                input, textarea { width: 100%; padding: 10px; margin: 10px 0; }
                button { background: green; color: white; padding: 10px 20px; border: none; cursor: pointer; }
                .btn-hapus { background: red; color: white; padding: 5px 10px; text-decoration: none; }
                .btn-edit { background: orange; color: white; padding: 5px 10px; text-decoration: none; }
                .no-data { text-align: center; padding: 40px; color: #999; }
            </style>
        </head>
        <body>
            <header><h1>Portal Berita</h1></header>
            <nav>
                <a href="/artikel">Home</a>
                <a href="/artikel">Artikel</a>
                <a href="#">About</a>
                <a href="#">Kontak</a>
            </nav>
            
            <div class="container">
                <a href="/admin/artikel" class="btn-admin">🔐 Kelola Artikel</a>
                
                <div class="main">
                    <div class="articles">
                        <h2>Daftar Artikel</h2>';
                        
                        if (empty($artikels)) {
                            echo '<div class="no-data"><p>Belum ada artikel. Klik "Kelola Artikel" untuk menambah.</p></div>';
                        } else {
                            foreach ($artikels as $item) {
                                echo '
                                <div class="artikel-item">
                                    <h2>' . esc($item['judul']) . '</h2>
                                    <p>' . esc(substr($item['isi'], 0, 300)) . '...</p>
                                    <small>Tanggal: ' . $item['created_at'] . '</small>
                                </div>';
                            }
                        }
                        
                        echo '
                    </div>
                    
                    <div class="sidebar">
                        <h3>Widget Header</h3>
                        <p>Widget Link</p>
                        <h3>Widget Text</h3>
                        <p>Vestibulum lorem elit, iaculis in nisl volutpat, malesuada tincidunt arcu.</p>
                    </div>
                </div>
            </div>
            
            <footer>&copy; 2021 - Universitas Pelita Bangsa</footer>
        </body>
        </html>
        ';
    }
    
    // Admin panel - CRUD
    public function admin_index()
    {
        $model = new ArtikelModel();
        $artikels = $model->findAll();
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Admin - Kelola Artikel</title>
            <style>
                body { font-family: Arial; background: #f4f4f4; margin: 20px; }
                .container { max-width: 1000px; margin: auto; background: white; padding: 20px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { padding: 10px; border: 1px solid #ddd; }
                th { background: #35424a; color: white; }
                .btn { padding: 5px 10px; text-decoration: none; color: white; }
                .btn-add { background: green; display: inline-block; margin-bottom: 20px; }
                .btn-edit { background: orange; }
                .btn-delete { background: red; }
                .btn-back { background: blue; }
                .success { background: green; color: white; padding: 10px; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Admin - Kelola Artikel</h1>
                <a href="/admin/artikel/add" class="btn btn-add">+ Tambah Artikel</a>
                <a href="/artikel" class="btn btn-back">← Lihat Portal</a>';
                
                if (session()->getFlashdata('success')) {
                    echo '<div class="success">' . session()->getFlashdata('success') . '</div>';
                }
                
                echo '<table>
                    <tr><th>ID</th><th>Judul</th><th>Tanggal</th><th>Aksi</th></tr>';
                    
                    if (empty($artikels)) {
                        echo '<tr><td colspan="4" style="text-align:center">Belum ada data</td></tr>';
                    } else {
                        foreach ($artikels as $item) {
                            echo '<tr>
                                <td>' . $item['id'] . '</td>
                                <td>' . esc($item['judul']) . '</td>
                                <td>' . $item['created_at'] . '</td>
                                <td>
                                    <a href="/admin/artikel/edit/' . $item['slug'] . '" class="btn btn-edit">Edit</a>
                                    <a href="/admin/artikel/delete/' . $item['slug'] . '" class="btn btn-delete" onclick="return confirm(\'Hapus?\')">Hapus</a>
                                </td>
                            </tr>';
                        }
                    }
                    
                echo '</table>
            </div>
        </body>
        </html>';
    }
    
    // Form tambah artikel
    public function add()
    {
        $model = new ArtikelModel();
        
        if ($this->request->getMethod() === 'post') {
            $slug = url_title($this->request->getPost('judul'), '-', true);
            $model->save([
                'judul' => $this->request->getPost('judul'),
                'slug' => $slug,
                'isi' => $this->request->getPost('isi'),
            ]);
            return redirect()->to('/admin/artikel')->with('success', 'Artikel ditambahkan!');
        }
        
        // Tampilkan form
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Tambah Artikel</title>
            <style>
                body { font-family: Arial; background: #f4f4f4; margin: 20px; }
                .container { max-width: 600px; margin: auto; background: white; padding: 20px; }
                input, textarea { width: 100%; padding: 10px; margin: 10px 0; }
                button { background: green; color: white; padding: 10px 20px; border: none; cursor: pointer; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Tambah Artikel Baru</h1>
                <form method="POST">
                    <label>Judul</label>
                    <input type="text" name="judul" required>
                    <label>Isi Artikel</label>
                    <textarea name="isi" rows="8" required></textarea>
                    <button type="submit">Simpan</button>
                    <a href="/admin/artikel">Batal</a>
                </form>
            </div>
        </body>
        </html>';
    }
    
    // Form edit artikel
    public function edit($slug)
    {
        $model = new ArtikelModel();
        
        if ($this->request->getMethod() === 'post') {
            $id = $this->request->getPost('id');
            $newSlug = url_title($this->request->getPost('judul'), '-', true);
            $model->update($id, [
                'judul' => $this->request->getPost('judul'),
                'slug' => $newSlug,
                'isi' => $this->request->getPost('isi'),
            ]);
            return redirect()->to('/admin/artikel')->with('success', 'Artikel diupdate!');
        }
        
        $artikel = $model->where('slug', $slug)->first();
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Artikel</title>
            <style>
                body { font-family: Arial; background: #f4f4f4; margin: 20px; }
                .container { max-width: 600px; margin: auto; background: white; padding: 20px; }
                input, textarea { width: 100%; padding: 10px; margin: 10px 0; }
                button { background: orange; color: white; padding: 10px 20px; border: none; cursor: pointer; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Edit Artikel</h1>
                <form method="POST">
                    <input type="hidden" name="id" value="' . $artikel['id'] . '">
                    <label>Judul</label>
                    <input type="text" name="judul" value="' . esc($artikel['judul']) . '" required>
                    <label>Isi Artikel</label>
                    <textarea name="isi" rows="8" required>' . esc($artikel['isi']) . '</textarea>
                    <button type="submit">Update</button>
                    <a href="/admin/artikel">Batal</a>
                </form>
            </div>
        </body>
        </html>';
    }
    
    // Hapus artikel
    public function delete($slug)
    {
        $model = new ArtikelModel();
        $model->where('slug', $slug)->delete();
        return redirect()->to('/admin/artikel')->with('success', 'Artikel dihapus!');
    }
}