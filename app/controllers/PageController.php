<?php

use Adamgoose\Repositories\ContentRepositoryInterface;

class PageController extends BaseController {

  public $layout = 'layouts.master';
  protected $content;

  public function __construct(ContentRepositoryInterface $content)
  {
    $this->content = $content;
  }

  public function getIndex()
  {
    $slides = $this->content->slides();
    $inventory = $this->content->inventory();
    $this->layout->content = View::make('index', compact('slides', 'inventory'));
  }

  public function getInventory($focus = null)
  {
    $categories = $this->content->categories();
    $inventory = $this->content->inventory();
    $this->layout->content = View::make('portfolio', compact('focus', 'categories', 'inventory'));
  }

  public function getContact()
  {
    $this->layout->content = View::make('contact');
  }

  public function postContact()
  {
    $input = Input::all();
    $recipient = Config::get('site.contact.email');
    $siteName = Config::get('site.name');

    try {
      Mail::send('emails.contact', $input, function($mail) use ($input, $recipient, $siteName)
      {
        $mail->from($input['email'], $input['name']);

        $mail->to($recipient['email'], $recipient['name']);

        if(array_key_exists('cc', $input))
          $mail->to($input['email'], $input['name']);

        $mail->subject('Contact Form Submission on '.$siteName);
      });
    } catch(Exception $e) {
      return Response::json(['status' => 'false']);
    }

    return Response::json(['status' => 'true']);
  }

  public function getPage($slug)
  {
    $page = $this->content->page($slug);

    if(!($page instanceof Page))
      return App::abort(404);

    $categories = $this->content->categories();
    $inventory = $this->content->inventory();
    
    $this->layout->content = View::make('page', compact('page', 'categories', 'inventory'));
  }

  public function postSearch()
  {
    $focus = null;
    $categories = $this->content->categories();
    $inventory = $this->content->searchInventory(Input::get('query'));
    
    $this->layout->content = View::make('portfolio', compact('focus', 'categories', 'inventory'));
  }

}