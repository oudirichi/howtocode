<?php 

$router->get('/', "pages#index"); 

$router->get('/users/', "users#index"); 
$router->get('/users/login', "users#login"); 
$router->post('/users/login', "users#login"); 
$router->get('/users/logout', "users#logout"); 
$router->get('/users/register', "users#register"); 
$router->post('/users/register', "users#register"); 
$router->get('/users/account', "users#account"); 
$router->get('/users/forget', "users#forget"); 
$router->get('/users/reset/:id/:token', "users#reset"); 
$router->get('/users/confirm/:id/:token', "users#confirm"); 



$router->get('/participer/tutoriel', "participer#tutoriel");
$router->post('/participer/tutoriel', "participer#tutoriel");
$router->get('/participer/formation', "participer#tutoriel");
$router->post('/participer/formation', "participer#tutoriel");

$router->get('/formation/', "formation#index");
$router->get('/formation/:slug', "formation#view");
$router->get('/formation/:slug/:slug', "formation#view");

$router->get('/tutoriel/', "tutoriel#index");
$router->get('/tutoriel/:slug', "tutoriel#view");
$router->get('/tutoriel/:slug/:slug', "tutoriel#view");


$router->get('/admin/tutoriel/', "admin#tutoriel");
$router->get('/admin/tutoriel/:id/', "admin#tutoriel");



//$router->ressources('photos');
