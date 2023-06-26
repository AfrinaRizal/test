<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Generate Application

//generate key melalui route
//output= 49978c7fb60aef8178a8dd789a4fbd7a
$router->get('/key', function(){
    return md5('afrina');
    
});

// //location @ function
// //tujuan untuk request key daripada controller
// $router->get('/key', 'ExampleController@generateKey');
   
// $router->post('/foo', 'ExampleController@fooExample');

// // http://localhost:8000/user/2
// // return -> User ID = 2
// $router->get('/user/{id}', 'ExampleController@getUser');

// //menerima 2 parameter sekaligus
// //http://localhost:8000/post/cat1/1/cat2/3
// $router->get('/post/cat1/{cat1}/cat2/{cat2}', 'ExampleController@getPost');


// //profile 
// //http://localhost:8000/profile
// $router->get('/profile', ['as' => 'profile', 'uses' => 'ExampleController@getProfile']);
// $router->get('/profile/action', ['as' => 'profile.action', 'uses' => 'ExampleController@getProfileAction']);


// $router -> get('/admin/home', ['middleware' => 'age', function () {
//     return 'Old Enough'; 
// }]);


// $router -> get ('/fail', function(){
//     return 'Not Yet Mature';
// });

// $router->get('/foo', function(){
//     return 'Hello, GET Method!';
// });

// //guna insomnia
// $router->get('/bar', function(){
//     return 'Hello, POST Method!';
// });

// $router->get('/get', function(){
//     return 'GET'; 
// });

// $router->post('/post', function(){
//     return 'POST';
// });

// $router->put('/put', function(){
//     return 'PUT';
// });

// $router->patch('/patch', function(){
//     return 'PATCH';
// });

// $router->delete('/delete', function(){
//     return 'DELETE';
// });

// $router->options('/options', function(){
//     return 'OPTIONS';
// });

// //jadi http://localhost:8000/user/1
// $router->get('/user/{id}', function($id){
//     return 'User ID = '.$id;
// });

// //jadi guna http://localhost:8000/post/1/comments/1
// $router->get('/post/{postId}/comments/{commentId}', function($postId, $commentId){
//     return 'Post ID = '.$postId. ' Comment ID = ' . $commentId ;
// });

// //http://localhost:8000/optional/1
// $router->get('/optional[/{param}]', function($param = null){
//     return $param ;
// });

// $router->get('profile', function() {
//     // return route('route.profile') ;
//     return redirect() ->route('route.profile') ;
// });

// $router->get('profile/idstack', ['as' => 'route.profile', function() {
//     //return route('route.profile') ;
//     return 'Route ID stack' ;
// }]);

// // $router->group(['prefix' => 'admin'], function() use ($router) {
//     $router->group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => ''], function() use ($router) {
//     $router->get('home', function() {
//     return 'Home Admin' ;
//     });

//     $router->get('profile', function() {
//         return 'Profile Admin' ;
//     }); 

// });

$router->post('/createProduct', 'productController@createProduct');
$router->post('/createCategory', 'categoryController@createCategory');
$router->post('/deleteProduct', 'productController@deleteProduct');
$router->post('/deleteCategory', 'categoryController@deleteCategory');
$router->post('/listCategory', 'categoryController@listCategory');
$router->post('/list', 'productController@list');
$router->post('/updateProduct', 'productController@updateProduct');
$router->post('/updateCategory', 'categoryController@updateCategory');
$router->get('/showProduct/{product_id}', 'productController@showProduct');
$router->get('/showCategory/{category_id}', 'categoryController@showCategory');
$router->post('/totalProduct', 'productController@totalProduct');
$router->post('/total', 'productController@total');


//users
$router->post('/register', 'usersController@register');
// $router->post('/login','usersController@login');
$router->post('/updatepassword','usersController@updatepassword');
$router->post('/logout','usersController@logout');
$router->post('/login','authController@login');



//product
$router->post('/joinCategory', 'productController@joinCategory');

//admin
$router->post('/upload', 'adminController@upload');
$router->post('/listAdmin', 'adminController@listAdmin');
$router->post('/deleteAdmin', 'adminController@deleteAdmin');
$router->get('/showAdmin/{admin_id}', 'adminController@showAdmin');
$router->post('/updateAdmin', 'adminController@updateAdmin');




// $router->post('/register','authController@register');

