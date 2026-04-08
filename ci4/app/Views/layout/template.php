<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Layout Sederhana'; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #e8f4f8 0%, #d1e9f0 100%);
            line-height: 1.6;
            min-height: 100vh;
        }
        
        /* Container Utama */
        .container {
            width: 1000px;
            margin: 30px auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        /* Header - BIRU SOFT */
        header {
            background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
            color: white;
            padding: 35px 25px;
        }
        
        header h1 {
            font-size: 32px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        /* Navigasi - BIRU SOFT LEBIH GELAP */
        nav {
            background: linear-gradient(135deg, #2C6B9E 0%, #1E4D73 100%);
            padding: 14px 25px;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            margin-right: 25px;
            font-size: 15px;
            font-weight: 500;
            padding: 8px 0;
            transition: all 0.3s ease;
            position: relative;
        }
        
        nav a:hover {
            color: #d4eaff;
        }
        
        nav a:hover::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #ffd700;
        }
        
        /* Layout 2 Kolom */
        .main-layout {
            display: flex;
            padding: 30px 25px;
            gap: 35px;
        }
        
        /* Konten Utama */
        .content {
            flex: 2;
        }
        
        .content h2 {
            color: #2C6B9E;
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .content hr {
            margin: 15px 0;
            border: none;
            border-top: 2px solid #4A90E2;
            width: 60px;
        }
        
        .content p {
            color: #444;
            line-height: 1.8;
            font-size: 15px;
        }
        
        /* Sidebar Widget */
        .sidebar {
            flex: 1;
        }
        
        .widget {
            background: linear-gradient(135deg, #f0f7fc 0%, #e8f0f5 100%);
            padding: 18px;
            margin-bottom: 20px;
            border-radius: 10px;
            border-left: 4px solid #4A90E2;
        }
        
        .widget h3 {
            color: #2C6B9E;
            font-size: 16px;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #c8dce8;
        }
        
        .widget ul {
            list-style: none;
        }
        
        .widget ul li {
            margin-bottom: 10px;
        }
        
        .widget ul li a {
            color: #4A90E2;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .widget ul li a:hover {
            color: #2C6B9E;
            text-decoration: underline;
        }
        
        .widget p {
            color: #555;
            font-size: 13px;
            line-height: 1.7;
        }
        
        /* Footer - BIRU SOFT */
        footer {
            background: linear-gradient(135deg, #2C6B9E 0%, #1E4D73 100%);
            color: white;
            text-align: center;
            padding: 18px;
            font-size: 13px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                margin: 15px auto;
            }
            
            .main-layout {
                flex-direction: column;
            }
            
            nav a {
                margin-right: 15px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header Biru Soft -->
    <header>
        <h1>Layout Sederhana</h1>
    </header>
    
    <!-- Navigasi Biru Soft -->
    <nav>
        <a href="/page/home">Home</a>
        <a href="/page/artikel">Artikel</a>
        <a href="/page/about">About</a>
        <a href="/page/kontak">Kontak</a>
    </nav>
    
    <!-- Layout 2 Kolom -->
    <div class="main-layout">
        <!-- KONTEN UTAMA -->
        <div class="content">
            <h2><?= $heading ?? 'Halaman About' ?></h2>
            <hr>
            <p><?= $content ?? 'Ini adalah halaman about yang menjelaskan tentang isi halaman ini.' ?></p>
        </div>
        
        <!-- SIDEBAR WIDGET -->
        <div class="sidebar">
            <div class="widget">
                <h3>Widget Header</h3>
                <ul>
                    <li><a href="#">Widget Link</a></li>
                    <li><a href="#">Widget Link</a></li>
                </ul>
            </div>
            <div class="widget">
                <h3>Widget Text</h3>
                <p>Vestibulum lorem elit, iaculis in nisl volutpat, malesuada tincidunt arcu. Proin in leo fringilla, vestibulum mi porta, faucibus felis. Integer pharetra est nunc, nec pretium nunc pretium ac.</p>
            </div>
        </div>
    </div>
    
    <!-- Footer Biru Soft -->
    <footer>
        <p>&copy; 2021 - Universitas Pelita Bangsa</p>
    </footer>
</div>

</body>
</html>