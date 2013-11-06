<?php

Route::group(['before' => 'cache.get', 'after' => 'cache.put'], function()
{

  Route::get('/', 'PageController@getIndex');

  Route::get('inventory/{focus?}', 'PageController@getInventory');

  Route::get('contact', 'PageController@getContact');

  Route::post('contact', 'PageController@postContact');

  Route::get('{slug}', 'PageController@getPage');

});

Route::post('search', 'PageController@postSearch');

Route::get('cache/clear', function()
{
  Cache::flush();
  return Redirect::to('/');
});

View::composer('layouts.master', function($view)
{
  $content = App::make('Adamgoose\Repositories\ContentRepositoryInterface');
  $pages = $content->pages();
  $inventory = $content->inventory();
  $categories = $content->heavyCategories($inventory);

  $view->with(compact('pages', 'inventory', 'categories'));
});