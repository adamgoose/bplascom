<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{Config::get('site.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
  @foreach(Config::get('site.styles') as $style)
    <link rel="stylesheet" href="{{$style}}">
  @endforeach
    <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Patua+One'>
    <link rel="stylesheet" href="/fancybox/jquery.fancybox-1.3.4.css">
    <link rel="stylesheet" href="/css/isotope.css">
    <!--[if lt IE 9]>
      <link rel="stylesheet" href="/css/font-awesome-ie7.css">
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
  <!-- page wrapper -->
  <div class="container wrapper">
    <header>
      <div class="row">
        <div class="span8">
          <h1>
            <a href="/"><img src="{{Config::get('site.logo')}}" alt="{{Config::get('site.name')}}"></a>
          </h1>
        </div>
        <div class="span4">
          {{Form::open(['url' => '/search', 'method' => 'post'])}}
            <div class="input-append">
              <input class="span2" id="appendedInputButtons" type="text" name="query" value="{{Input::get('query')}}">
              <button class="btn btn-primary" type="submit">Search</button>
            </div>
          {{Form::close()}}
        </div><!-- /.span -->
      </div><!-- /.row -->
    </header>
      
    <div class="row">
      <div class="span12">
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">Menu</a>
              <a class="brand" href="/">{{Config::get('site.name')}}</a>
              <div class="nav-collapse collapse">
                <ul class="nav">
                  <li class="{{Request::is('/') ? 'active' : ''}}"><a href="/">Home</a></li>
                @foreach($pages as $page)
                  <li class="{{Request::is($page->getSlug()) ? 'active' : ''}}"><a href="/{{$page->getSlug()}}">{{$page->getText('page.title')}}</a></li>
                @endforeach
                  <li class="{{(Request::is('inventory') || Request::is('inventory/*')) ? 'active' : ''}}"><a href="/inventory">Inventory</a></li>
                  <li class="{{Request::is('contact') ? 'active' : ''}}"><a href="/contact">Contact Us</a></li>
                </ul> <!-- /.nav -->
              </div> <!-- /.nav-collapse -->
            </div><!-- /container -->
          </div><!-- /navbar-inner -->
        </div><!-- /navbar -->
      </div><!-- /row -->
    </div><!-- /span12 whoa! -->

@yield('content')

  </div><!-- /.container (page container)-->

  <footer>
    <div class="container">
      <!-- row of widgets -->
      <div class="row">
        <div class="span4">
          <h4>About Us</h4>
          {{Config::get('site.footer_about_prefix')}}
          @foreach($categories->slice(0, 4) as $category)
            <a href="/inventory/{{$category->getSlug()}}">{{$category->getText('category.title')}}</a>, 
          @endforeach
          and
          @foreach($categories->slice(4, 1) as $category)
            <a href="/inventory/{{$category->getSlug()}}">{{$category->getText('category.title')}}</a>.
          @endforeach

        </div> <!-- /.span4 -->

        <hr class="visible-phone">
        
        <div class="span4">
          <h4>Recently Added Used Equipment</h4>
          <ul>
          @foreach($inventory->slice(0, 7) as $equipment)
            <li>
              <a href="/inventory/{{$equipment->get('equipment.category')->getSlug()}}">{{$equipment->getText('equipment.title')}}</a>
              <small>
                {{$categories->filter(function($category) use ($equipment)
                  {
                    if($category->getSlug() == $equipment->get('equipment.category')->getSlug())
                      return true; 
                  })->first()->getText('category.title')}}
              </small>
            </li>
          @endforeach
          </ul>
        </div><!-- /.span4 -->

        <hr class="visible-phone">
        
        <div class="span4">
          <h4>Heavily Stocked Used Equipment Categories</h4>
          <ul class="tag-cloud">
          @foreach($categories->slice(0, 10) as $category)
            <li><a href="/inventory/{{$category->getSlug()}}">{{$category->getText('category.title')}}</a></li>
          @endforeach
          </ul>
        </div><!-- /.span4 -->
      </div> <!-- /.row -->
    </div><!-- /.container -->

    <div class="bottom-line">
      <div class="container">
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2013 {{Config::get('site.name')}} | Site by <a href="http://dannenga.com" target="_blank" class="dannenga">dannenga., LLC</a></p>
      </div>
    </div>
  </footer>

  <!-- last but not least the javascript -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="/js/jquery-1.8.2.min.js"><\/script>')</script>
  <script src="/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function(){
      //bootstrap tooltip trigger
      $('[rel="tooltip"]').tooltip();
    });
  </script>

  @yield('scripts')

  </body>
</html>
