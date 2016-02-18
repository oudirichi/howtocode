<?php 

$router->get('/', "pages#index"); 

$router->get('/users/', "users#index"); 
$router->get('/users/login', "users#login"); 
$router->post('/users/login', "users#login"); 
$router->get('/users/logout', "users#logout"); 
$router->post('/users/register', "users#register"); 
$router->get('/users/account', "users#account"); 
$router->get('/users/forget', "users#forget"); 
$router->get('/users/reset/:id/:token', "users#reset"); 
$router->get('/users/confirm/:id/:token', "users#confirm"); 

$router->get('/posts', function(){ echo "Tous les articles"; });
$router->get('/posts/:id', function($id){ echo "Afficher l'article $id"; });
$router->get('/posts/:id-:slug', function($id,$slug){ echo "post  $id - $slug"; });
$router->get('/posts/:lol', function($lol){ echo "lol: $lol"; })->with('lol', '[a-z\-0-9]+');

$router->ressources('photos');