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

## Contoh code
// Controller Page.php
public function about() 
{ 
    return view('about', [ 
        'title' => 'Halaman About', 
        'content' => 'Ini adalah halaman about...' 
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
## Codelgniter
<img width="736" height="297" alt="image" src="https://github.com/user-attachments/assets/8a832a83-c520-485f-a9d2-d046f42b5276" />

## Halaman about
<img width="379" height="222" alt="image" src="https://github.com/user-attachments/assets/9b37982a-d9be-49fa-80a2-0d1c7ba039dc" />

## Halaman contack
<img width="381" height="250" alt="image" src="https://github.com/user-attachments/assets/3b50bae4-4214-4aa1-9ccc-38605212bb75" />

## Halaman Faqs
<img width="414" height="298" alt="image" src="https://github.com/user-attachments/assets/1ac10788-78dd-4f99-a0af-1e99b6009af5" />

## Halaman tos
<img width="1289" height="375" alt="image" src="https://github.com/user-attachments/assets/5724ede2-b2fe-4ba1-aeaa-7e1678e33d65" />

## Halaman services
<img width="382" height="186" alt="image" src="https://github.com/user-attachments/assets/61168265-9dfc-457f-808f-22788ea1ec3d" />




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


