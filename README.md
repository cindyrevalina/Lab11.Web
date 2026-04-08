## PRAKTIKUM 1: DASAR-DASAR FRAMEWORK CI4
## Tujuan:

Memahami konsep dasar Framework

Memahami konsep MVC (Model-View-Controller)

Mampu membuat program sederhana dengan CI4

## Yang Dipelajari:

Instalasi CI4 (manual & composer)

Konfigurasi environment (.env)

Routing dasar

Membuat Controller sederhana

Membuat View sederhana

Auto routing

Layout dengan CSS

## Output yang Dihasilkan:

Halaman About, Contact, FAQ, ToS yang statis (tidak ada database)

Tampilan layout sederhana dengan CSS

Belum ada CRUD, belum ada database

1. Contoh code
// Controller Page.php
public function about() 
{ 
    return view('about', [ 
        'title' => 'Halaman About', 
        'content' => 'Ini adalah halaman about...' 
    ]); 
}

2. Konfigurasi Environment
Copy file .env dari .env.example:

bash
copy .env.example .env
Ubah CI_ENVIRONMENT menjadi development:

env
CI_ENVIRONMENT = development
3. Menjalankan Server
bash
php spark serve
Server berjalan di: http://localhost:8080

Membuat Controller Page
Buat file app/Controllers/Page.php:

php
<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        echo "Ini halaman About";
    }

    public function contact()
    {
        echo "Ini halaman Contact";
    }

    public function faqs()
    {
        echo "Ini halaman FAQ";
    }

    public function tos()
    {
        echo "ini halaman Term of Services";
    }
}
5. Mengatur Routes
Buka app/Config/Routes.php, tambahkan:

php
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
$routes->get('/page/tos', 'Page::tos');
6. Membuat View dengan Layout
Buat file CSS public/style.css (copy dari praktikum layout sebelumnya).

Buat folder app/Views/template/ dengan file:

header.php:

php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
</head>
<body>
    <div id="container">
        <header>
            <h1>Layout Sederhana</h1>
        </header>
        <nav>
            <a href="<?= base_url('/'); ?>">Home</a>
            <a href="<?= base_url('/artikel'); ?>">Artikel</a>
            <a href="<?= base_url('/about'); ?>">About</a>
            <a href="<?= base_url('/contact'); ?>">Kontak</a>
        </nav>
        <section id="wrapper">
            <section id="main">
footer.php:

php
            </section>
            <aside id="sidebar">
                <div class="widget-box">
                    <h3 class="title">Widget Header</h3>
                    <ul>
                        <li><a href="#">Widget Link</a></li>
                        <li><a href="#">Widget Link</a></li>
                    </ul>
                </div>
                <div class="widget-box">
                    <h3 class="title">Widget Text</h3>
                    <p>Vestibulum lorem elit, iaculis in nisl volutpat, malesuada tincidunt arcu.</p>
                </div>
            </aside>
        </section>
        <footer>
            <p>&copy; 2021 - Universitas Pelita Bangsa</p>
        </footer>
    </div>
</body>
</html>
Buat app/Views/about.php:

php
<?= $this->include('template/header'); ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->include('template/footer'); ?>
Update method about() di Page.php:

php
public function about()
{
    return view('about', [
        'title' => 'Halaman About',
        'content' => 'Ini adalah halaman about yang menjelaskan tentang isi halaman ini.'
    ]);
}
## Ciri khas Praktikum 1:

❌ Belum pakai database

❌ Belum ada CRUD

✅ Hanya routing & tampilan statis

✅ Pengenalan MVC dasar

## Akses:
# PRAKTIKUM 1 (Dasar CI4)
http://localhost:8080
http://localhost:8080/about
http://localhost:8080/contact
http://localhost:8080/faqs
http://localhost:8080/page/tos

## Screenshot



## PRAKTIKUM 2: CRUD ARTIKEL
## Tujuan:

Membuat aplikasi dengan database

Implementasi CRUD (Create, Read, Update, Delete)

Membuat admin panel

## Yang Dipelajari:

Membuat database & tabel

Membuat Model (ArtikelModel)

Membuat Controller dengan method:

index() → menampilkan artikel

view($slug) → detail artikel

admin_index() → daftar artikel (admin)

add() → tambah artikel

edit($id) → edit artikel

delete($id) → hapus artikel

Membuat form tambah & edit

Routing untuk frontend & admin

## Output yang Dihasilkan:

Portal berita dengan data dari database

Admin panel untuk kelola artikel

Bisa tambah/edit/hapus artikel

## Contoh code
// Controller Artikel.php
public function add()
{
    $model = new ArtikelModel();
    $model->insert([
        'judul' => $this->request->getPost('judul'),
        'isi' => $this->request->getPost('isi'),
    ]);
    return redirect('admin/artikel');
}

Membuat Database
Buka phpMyAdmin, jalankan:

sql
CREATE DATABASE lab_ci4;

USE lab_ci4;

CREATE TABLE artikel (
    id INT(11) AUTO_INCREMENT,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    slug VARCHAR(200),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
);
2. Konfigurasi Database
Edit file .env:

env
database.default.hostname = localhost
database.default.database = lab_ci4
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
3. Membuat Model
Buat app/Models/ArtikelModel.php:

php
<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'isi', 'slug'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}
4. Membuat Controller Artikel
Buat app/Controllers/Artikel.php:

php
<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class Artikel extends BaseController
{
    // Frontend - menampilkan semua artikel
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->orderBy('created_at', 'DESC')->findAll();
        return view('artikel/index', compact('title', 'artikel'));
    }

    // Frontend - detail artikel
    public function view($slug)
    {
        $model = new ArtikelModel();
        $artikel = $model->where('slug', $slug)->first();

        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $title = $artikel['judul'];
        return view('artikel/detail', compact('artikel', 'title'));
    }

    // Admin - daftar artikel
    public function admin_index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->findAll();
        return view('artikel/admin_index', compact('artikel', 'title'));
    }

    // Admin - tambah artikel
    public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);

        if ($this->request->getMethod() === 'post' && $validation->withRequest($this->request)->run()) {
            $model = new ArtikelModel();
            $model->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul'), '-', true),
            ]);
            return redirect('admin/artikel');
        }

        $title = "Tambah Artikel";
        return view('artikel/form_add', compact('title'));
    }

    // Admin - edit artikel
    public function edit($id)
    {
        $model = new ArtikelModel();
        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);

        if ($this->request->getMethod() === 'post' && $validation->withRequest($this->request)->run()) {
            $model->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
            ]);
            return redirect('admin/artikel');
        }

        $data = $model->where('id', $id)->first();
        $title = "Edit Artikel";
        return view('artikel/form_edit', compact('title', 'data'));
    }

    // Admin - hapus artikel
    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);
        return redirect('admin/artikel');
    }
}
5. Membuat View
Buat folder app/Views/artikel/

index.php (halaman depan):

php
<?= $this->include('template/header'); ?>

<?php if($artikel): foreach($artikel as $row): ?>
<article class="entry">
    <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></h2>
    <p><?= substr($row['isi'], 0, 200); ?></p>
    <small>Diposting: <?= $row['created_at']; ?></small>
</article>
<hr class="divider" />
<?php endforeach; else: ?>
<article class="entry"><h2>Belum ada data.</h2></article>
<?php endif; ?>

<?= $this->include('template/footer'); ?>
detail.php:

php
<?= $this->include('template/header'); ?>
<article class="entry">
    <h2><?= $artikel['judul']; ?></h2>
    <p><?= $artikel['isi']; ?></p>
    <small>Diposting: <?= $artikel['created_at']; ?></small>
</article>
<?= $this->include('template/footer'); ?>
admin_index.php:

php
<?= $this->include('template/admin_header'); ?>
<h2>Dashboard | Artikel</h2>
<a href="<?= base_url('/admin/artikel/add'); ?>" class="btn">Tambah Artikel</a>
<table class="table">
    <thead><tr><th>ID</th><th>Judul</th><th>Aksi</th></tr></thead>
    <tbody>
        <?php if($artikel): foreach($artikel as $row): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><b><?= $row['judul']; ?></b><p><small><?= substr($row['isi'], 0, 50); ?></small></p></td>
            <td>
                <a class="btn" href="<?= base_url('/admin/artikel/edit/' . $row['id']); ?>">Edit</a>
                <a class="btn btn-danger" onclick="return confirm('Yakin hapus?')" href="<?= base_url('/admin/artikel/delete/' . $row['id']); ?>">Hapus</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="3">Belum ada data</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?= $this->include('template/admin_footer'); ?>
form_add.php:

php
<?= $this->include('template/admin_header'); ?>
<h2><?= $title; ?></h2>
<form action="" method="post">
    <p><label>Judul</label><input type="text" name="judul" required></p>
    <p><label>Isi Artikel</label><textarea name="isi" rows="10" required></textarea></p>
    <p><input type="submit" value="Simpan" class="btn"></p>
</form>
<?= $this->include('template/admin_footer'); ?>
form_edit.php:

php
<?= $this->include('template/admin_header'); ?>
<h2><?= $title; ?></h2>
<form action="" method="post">
    <p><label>Judul</label><input type="text" name="judul" value="<?= $data['judul']; ?>" required></p>
    <p><label>Isi Artikel</label><textarea name="isi" rows="10" required><?= $data['isi']; ?></textarea></p>
    <p><input type="submit" value="Update" class="btn"></p>
</form>
<?= $this->include('template/admin_footer'); ?>
Buat file template admin:

app/Views/template/admin_header.php:

php
<!DOCTYPE html>
<html>
<head>
    <title>Admin Portal Berita</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        .btn { background: #007bff; color: white; padding: 5px 10px; text-decoration: none; display: inline-block; margin: 5px 0; }
        .btn-danger { background: #dc3545; }
    </style>
</head>
<body>
<div class="container">
    <h1>Admin Portal Berita</h1>
app/Views/template/admin_footer.php:

php
</div>
</body>
</html>
6. Menambahkan Data Awal
sql
INSERT INTO artikel (judul, isi, slug) VALUES 
('Artikel pertama', 'Lorem Ipsum adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting.', 'artikel-pertama'),
('Artikel kedua', 'Tidak seperti anggapan banyak orang, Lorem Ipsum bukanlah teks-teks yang diacak.', 'artikel-kedua');
7. Mengatur Routes
Buka app/Config/Routes.php, tambahkan:

php
// Frontend
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');

// Admin
$routes->group('admin', function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->get('artikel/add', 'Artikel::add');
    $routes->post('artikel/add', 'Artikel::add');
    $routes->get('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->post('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

## Ciri khas Praktikum 2:

✅ Pakai database

✅ Ada CRUD lengkap

✅ Ada admin panel

❌ Belum ada sistem login

## Akses:
# PRAKTIKUM 2 (CRUD)
http://localhost:8080/artikel
http://localhost:8080/artikel/artikel-pertama
http://localhost:8080/artikel/artikel-kedua
http://localhost:8080/admin/artikel
http://localhost:8080/admin/artikel/add
http://localhost:8080/admin/artikel/edit/1
http://localhost:8080/admin/artikel/edit/2


## Screenshot

## PRAKTIKUM 3: VIEW LAYOUT & VIEW CELL
## Tujuan:

Memahami View Layout (template)

Memahami View Cell (komponen modular)

## Yang Dipelajari:

Membuat layout utama (layout/main.php)

Menggunakan $this->extend() dan $this->section()

Membuat View Cell untuk widget sidebar

Menampilkan 5 artikel terbaru di sidebar

## Output yang Dihasilkan:

Tampilan dengan layout yang rapi

Sidebar berisi artikel terbaru (dinamis)

Komponen reusable (View Cell)

## Contoh code:

php
// View Cell
public function render()
{
    $model = new ArtikelModel();
    $artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();
    return view('components/artikel_terkini', ['artikel' => $artikel]);
}

1. Membuat Layout Utama
Buat app/Views/layout/main.php:

php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?? 'Portal Berita'; ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
</head>
<body>
    <div id="container">
        <header><h1>Layout Sederhana</h1></header>
        <nav>
            <a href="<?= base_url('/'); ?>">Home</a>
            <a href="<?= base_url('/artikel'); ?>">Artikel</a>
            <a href="<?= base_url('/about'); ?>">About</a>
            <a href="<?= base_url('/contact'); ?>">Kontak</a>
        </nav>
        <section id="wrapper">
            <section id="main">
                <?= $this->renderSection('content') ?>
            </section>
            <aside id="sidebar">
                <div class="widget-box">
                    <h3 class="title">Widget Header</h3>
                    <ul><li><a href="#">Widget Link</a></li></ul>
                </div>
                <div class="widget-box">
                    <h3 class="title">Artikel Terkini</h3>
                    <?= view_cell('App\Cells\ArtikelTerkini::render') ?>
                </div>
            </aside>
        </section>
        <footer><p>&copy; 2021 - Universitas Pelita Bangsa</p></footer>
    </div>
</body>
</html>
2. Membuat View Cell
Buat folder app/Cells/

app/Cells/ArtikelTerkini.php:

php
<?php

namespace App\Cells;

use App\Models\ArtikelModel;

class ArtikelTerkini
{
    public function render()
    {
        $model = new ArtikelModel();
        $artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();
        return view('components/artikel_terkini', ['artikel' => $artikel]);
    }
}
Buat app/Views/components/artikel_terkini.php:

php
<ul>
    <?php foreach($artikel as $row): ?>
    <li><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></li>
    <?php endforeach; ?>
</ul>
3. Memodifikasi View
app/Views/artikel/index.php menjadi:

php
<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Daftar Artikel<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if($artikel): foreach($artikel as $row): ?>
<article class="entry">
    <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></h2>
    <p><?= substr($row['isi'], 0, 200); ?></p>
</article>
<hr class="divider" />
<?php endforeach; else: ?>
<article class="entry"><h2>Belum ada data.</h2></article>
<?php endif; ?>
<?= $this->endSection() ?>

## Ciri khas Praktikum 3:

✅ Pakai layout template

✅ Ada View Cell

✅ Sidebar dinamis

❌ Belum ada login

## Akses:
# PRAKTIKUM 3 (Layout) - URL sama seperti Praktikum 2
# PRAKTIKUM 2 (CRUD)
http://localhost:8080/artikel
http://localhost:8080/artikel/artikel-pertama
http://localhost:8080/artikel/artikel-kedua
http://localhost:8080/admin/artikel
http://localhost:8080/admin/artikel/add
http://localhost:8080/admin/artikel/edit/1
http://localhost:8080/admin/artikel/edit/2

## Screenshot


## PRAKTIKUM 4: MODUL LOGIN
## Tujuan:

Memahami Authentication (Auth)

Memahami Filter (middleware)

Membuat sistem login untuk proteksi halaman admin

## Yang Dipelajari:

Membuat tabel user

Membuat Model User

Membuat Controller User (login, logout)

Membuat view login

Membuat seeder untuk user default

Membuat Auth Filter

Mendaftarkan filter ke routes

## Output yang Dihasilkan:

Halaman login

Halaman admin yang terlindungi (harus login dulu)

Session management

## Contoh code:

php
// Auth Filter
class Auth implements FilterInterface 
{ 
    public function before(RequestInterface $request, $arguments = null) 
    { 
        if(! session()->get('logged_in')){ 
            return redirect()->to('/user/login'); 
        } 
    } 
}

1. Membuat Tabel User
sql
CREATE TABLE user (
    id INT(11) AUTO_INCREMENT,
    username VARCHAR(200) NOT NULL,
    useremail VARCHAR(200),
    userpassword VARCHAR(200),
    PRIMARY KEY(id)
);
2. Membuat Model User
Buat app/Models/UserModel.php:

php
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['username', 'useremail', 'userpassword'];
}
3. Membuat Controller User
Buat app/Controllers/User.php:

php
<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function login()
    {
        helper(['form']);
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$email) {
            return view('user/login');
        }

        $session = session();
        $model = new UserModel();
        $login = $model->where('useremail', $email)->first();

        if ($login) {
            $pass = $login['userpassword'];
            if (password_verify($password, $pass)) {
                $login_data = [
                    'user_id' => $login['id'],
                    'user_name' => $login['username'],
                    'user_email' => $login['useremail'],
                    'logged_in' => TRUE,
                ];
                $session->set($login_data);
                return redirect('admin/artikel');
            } else {
                $session->setFlashdata("flash_msg", "Password salah.");
                return redirect()->to('/user/login');
            }
        } else {
            $session->setFlashdata("flash_msg", "Email tidak terdaftar.");
            return redirect()->to('/user/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user/login');
    }
}
4. Membuat View Login
Buat app/Views/user/login.php:

php
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial; background: #e9ecef; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        #login-wrapper { background: white; padding: 40px; border-radius: 5px; width: 380px; }
        .form-control { width: 100%; padding: 10px; margin: 10px 0; }
        .btn-primary { background: #6c757d; color: white; padding: 10px; width: 100%; border: none; cursor: pointer; }
        .alert { padding: 10px; background: #f8d7da; color: #721c24; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div id="login-wrapper">
        <h1>Sign In</h1>
        <?php if(session()->getFlashdata('flash_msg')):?>
            <div class="alert"><?= session()->getFlashdata('flash_msg') ?></div>
        <?php endif;?>
        <form action="" method="post">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
5. Membuat Seeder User
bash
php spark make:seeder UserSeeder
Buka app/Database/Seeds/UserSeeder.php:

php
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = model('UserModel');
        $model->insert([
            'username' => 'Cindy Revalina',
            'useremail' => 'cindy@email.com',
            'userpassword' => password_hash('cindy123', PASSWORD_DEFAULT),
        ]);
    }
}
Jalankan seeder:

bash
php spark db:seed UserSeeder
6. Membuat Auth Filter
Buat folder app/Filters/ dan file Auth.php:

php
<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
7. Mendaftarkan Filter
Buka app/Config/Filters.php, tambahkan di $aliases:

php
public array $aliases = [
    // ... yang sudah ada
    'auth' => \App\Filters\Auth::class,
];
8. Memproteksi Routes Admin
Update routes di app/Config/Routes.php:

php
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->get('artikel/add', 'Artikel::add');
    $routes->post('artikel/add', 'Artikel::add');
    $routes->get('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->post('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

// Routes login (tanpa filter)
$routes->get('/user/login', 'User::login');
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');


## Ciri khas Praktikum 4:

✅ Ada sistem login

✅ Admin panel diproteksi

✅ Session & password hash

❌ Fokus ke keamanan halaman

## CARA AKSES SETELAH LOGIN (Praktikum 4)
Login dulu di: http://localhost:8080/user/login

Email: admin@email.com
Password: admin123

Setelah login baru bisa akses:

http://localhost:8080/admin/artikel

http://localhost:8080/admin/artikel/add

http://localhost:8080/admin/artikel/edit/1

## Screenshot


## ALUR BELAJAR YANG BENAR:
text
Praktikum 1 (Dasar CI4)
       ↓
Praktikum 2 (CRUD Database)
       ↓
Praktikum 3 (Layout & View Cell)
       ↓
Praktikum 4 (Login & Filter)

## Kesimpulan:
 Dari praktikum 1 sampai 4 yang telah dilakukan, dapat disimpulkan:

Praktikum 1 berhasil memahami dasar-dasar CodeIgniter 4 mulai dari instalasi, routing, controller, view, hingga layout sederhana.

Praktikum 2 berhasil membuat aplikasi CRUD artikel lengkap dengan database MySQL. Aplikasi dapat menampilkan, menambah, mengedit, dan menghapus artikel.

Praktikum 3 berhasil mengimplementasikan View Layout untuk template yang rapi dan View Cell untuk komponen sidebar yang reusable.

Praktikum 4 berhasil menambahkan sistem authentication/login untuk memproteksi halaman admin agar hanya bisa diakses oleh user yang sudah login.



| Author |
|------------|-----|
| **Nama** | Cindy Revalina Simanullang|
| **NIM** | 312410417 |
| **Kelas** | I.24.C.1 |
| **Mata Kuliah** | Pemrograman Web 2 |


