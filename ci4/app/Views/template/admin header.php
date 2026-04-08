<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - <?= $title ?? 'Dashboard' ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { width: 1000px; margin: 20px auto; background: white; padding: 20px; border-radius: 10px; }
        h2 { margin-bottom: 20px; color: #333; }
        nav { background: #333; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        nav a { color: white; text-decoration: none; margin-right: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        .btn { background: #0066cc; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; display: inline-block; font-size: 12px; }
        .btn-danger { background: #cc0000; }
        input, textarea { width: 100%; padding: 10px; margin: 5px 0 15px 0; border: 1px solid #ddd; border-radius: 5px; }
        input[type="submit"] { background: #0066cc; color: white; width: auto; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <nav>
        <a href="/admin/artikel">Daftar Artikel</a>
        <a href="/admin/artikel/add">Tambah Artikel</a>
        <a href="/artikel">Lihat Website</a>
    </nav>