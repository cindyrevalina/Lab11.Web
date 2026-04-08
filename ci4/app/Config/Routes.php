<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Page');
$routes->setDefaultMethod('home');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// ========== ROUTES UNTUK PAGE (Layout Sederhana) ==========
$routes->get('/', 'Page::home');
$routes->get('/page/home', 'Page::home');
$routes->get('/page/artikel', 'Page::artikel');
$routes->get('/page/about', 'Page::about');
$routes->get('/page/kontak', 'Page::kontak');
$routes->get('/page/services', 'Page::services');

// ========== ROUTES UNTUK ARTIKEL (CRUD) ==========
// Routes Frontend Artikel
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');

// Routes Admin (CRUD)
$routes->group('admin', function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->get('artikel/add', 'Artikel::add');
    $routes->post('artikel/add', 'Artikel::add');
    $routes->get('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->post('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

$routes->get('/artikel', 'Artikel::index');
$routes->get('/admin/artikel', 'Artikel::admin_index');
$routes->get('/admin/artikel/add', 'Artikel::add');
$routes->post('/admin/artikel/add', 'Artikel::add');
$routes->get('/admin/artikel/edit/(:any)', 'Artikel::edit/$1');
$routes->post('/admin/artikel/edit/(:any)', 'Artikel::edit/$1');
$routes->get('/admin/artikel/delete/(:any)', 'Artikel::delete/$1');