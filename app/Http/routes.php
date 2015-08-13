<?php

Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);

Route::controllers([
    'auth' => 'Auth\AuthController',
]);
get('/js/routes.js', 'HomeController@routesJs');

get('views/{view}.html', ['as' => 'view', 'uses' => 'ViewHandlerController@getViewsOfPublic']);

Route::resource('project', 'ProjectController');
Route::resource('category', 'CategoryController');
get('project/{project_id}/image', ['as' => 'project.edit.image', 'uses' => 'ProjectController@createImage']);
post('project/{project_id}/image', ['as' => 'project.store.image', 'uses' => 'ProjectController@storeImage']);
get('category/{category}/projects', ['as' => 'category.show.projects', 'uses' => 'CategoryController@showProjects']);
get('category/{category}/add', ['as' => 'category.add.projects', 'uses' => 'CategoryController@addProjects']);
post('category/{category}/add', ['as' => 'category.store.projects', 'uses' => 'CategoryController@storeProjects']);
delete('category/{category}/project/{project_id}', ['as' => 'category.delete.project', 'uses' => 'CategoryController@deleteProject']);