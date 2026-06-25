<?php

$router = new Router();

// ── Halaman Utama ──
$router->get('/',      'HomeController@index');

// ── Store & Game ──
$router->get('/store',      'StoreController@index');
$router->get('/store/:id',  'StoreController@detail');

// ── Auth ──
$router->post('/login',    'AuthController@login');
$router->post('/register', 'AuthController@register');
$router->get('/logout',    'AuthController@logout');

// ── Library ──
$router->get('/library', 'LibraryController@index');

// ── Wishlist ──
$router->get('/wishlist',            'WishlistController@index');
$router->get('/wishlist/add/:id',    'WishlistController@add');
$router->get('/wishlist/remove/:id', 'WishlistController@remove');
$router->get('/wishlist/toggle/:id', 'WishlistController@toggle');

// ── Support ──
$router->get('/support',         'SupportController@index');
$router->post('/support/submit', 'SupportController@submit');
