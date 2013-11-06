<?php

Route::group(['before' => 'cache.get', 'after' => 'cache.put'], function()
{

  Route::get('/', function()
  {
    $slides = Slide::get();
    $inventory = Inventory::get();
  	return View::make('index', compact('slides', 'inventory'));
  });

  Route::get('inventory/{focus?}', function($focus = null)
  {
    $categories = Category::get()->sortBy(function($category) {
      return $category->getText('category.title');
    });
    $inventory = Inventory::get();
    return View::make('portfolio', compact('focus', 'categories', 'inventory'));
  });

  Route::get('contact', function()
  {
    return View::make('contact');
  });

  Route::post('contact', function()
  {
    $input = Input::all();
    $emails = Config::get('site.contact.emails');
    $siteName = Config::get('site.name');

    try {
      Mail::send('emails.contact', $input, function($mail) use ($input, $emails, $siteName)
      {
        $mail->from($input['email'], $input['name']);

        foreach($emails as $name => $email)
          $mail->to($email, $name);

        if(array_key_exists('cc', $input))
          $mail->to($input['email'], $input['name']);

        $mail->subject('Contact Form Submission on '.$siteName);
      });
    } catch(Exception $e) {
      return Response::json(['status' => 'false']);
    }

    return Response::json(['status' => 'true']);
  });

  Route::get('{slug}', function($slug)
  {
    $page = Page::findSlug($slug);

    if(!($page instanceof Page))
      return App::abort(404);

    $categories = Category::get()->sortBy(function($category) {
      return $category->getText('category.title');
    });
    $inventory = Inventory::get();
    return View::make('page', compact('page', 'categories', 'inventory'));
  });

});

Route::post('search', function()
{
  $focus = null;
  $categories = Category::get()->sortBy(function($category) {
    return $category->getText('category.title');
  });
  $inventory = Inventory::fulltext('my.equipment.content', Input::get('query'))->get();
  return View::make('portfolio', compact('focus', 'categories', 'inventory'));
});

Route::get('cache/clear', function()
{
  Cache::flush();
  return Redirect::to('/');
});

View::composer('layouts.master', function($view)
{
  $pages = Page::get();
  $inventory = Inventory::get();
  $categories = Category::get()->sortBy(function($category) use ($inventory)
    {
      return $inventory->filter(function($equipment) use ($category)
        {
          if($equipment->get('equipment.category')->getId() == $category->getId()) return true;
        })->count();
    })->reverse();

  $view->with(compact('pages', 'inventory', 'categories'));
});