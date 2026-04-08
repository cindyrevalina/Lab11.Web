<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Web Artikel' ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { width: 1000px; margin: 0 auto; background: white; }
        header { background: #333; color: white; padding: 20px; text-align: center; }
        nav { background: #444; padding: 10px; text-align: center; }
        nav a { color: white; text-decoration: none; margin: 0 15px; }
        .content { padding: 20px; min-height: 400px; }
        footer { background: #333; color: white; text-align: center; padding: 15px; }
        .entry { margin-bottom: 30px; }
        .entry h2 a { color: #333; text-decoration: none; }
        .divider { border: none; border-top: 1px solid #ddd; margin: 20px 0; }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Web Artikel Sederhana</h1>
    </header>
    <nav>
        <a href="/artikel">Home</a>
        <a href="/admin/artikel">Admin</a>
    </nav>
    <div class="content">