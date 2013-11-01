@extends('layouts.master')

@section('content')
		<div class="row">
			<div class="span12">
				<h2>Used Equipment Inventory</h2>
				<hr>
			</div>
		</div>

		<div class="row">
			<div class="span3">

				<ul class="filter">
					<li><span>Categories:</span></li>
					<li><a class="active" href="#" data-filter="*">Show All</a></li>
				@foreach($categories as $category)
					<li>
						<a href="#" data-filter=".cat-{{$category->getSlug()}}">
							{{$category->getText('category.title')}}
							<span class="badge" style="margin-right: 0px;">
								{{$inventory->filter(function($equipment) use ($category) {
									if($equipment->get('equipment.category')->getId() == $category->getId()) return true;
								})->count()}}
							</span>
						</a>
					</li>
				@endforeach
				</ul>
			</div>
			<div class="span9">

				<!--Portfolio Items-->
				<ul class="thumbnails portfolio">
				@foreach($inventory as $equipment)
					<li class="span3 cat-{{$equipment->get('equipment.category')->getSlug()}}">
						<div class="thumbnail">
							<a class="js-fancybox" rel="album-{{$equipment->getSlug()}}" title="{{$equipment->getText('equipment.title')}}" href="{{$equipment->get('equipment.image1')->getMain()->getUrl()}}">
								<img src="{{$equipment->get('equipment.image1')->getView('gallery')->getUrl()}}" alt="{{$equipment->getText('equipment.title')}}" />
							</a>
						@if(key_exists('equipment.image2', $equipment->getFragments()))
							<a class="js-fancybox" rel="album-{{$equipment->getSlug()}}" title="{{$equipment->getText('equipment.title')}}" href="{{$equipment->get('equipment.image2')->getMain()->getUrl()}}"></a>
						@endif
						@if(key_exists('equipment.image3', $equipment->getFragments()))
							<a class="js-fancybox" rel="album-{{$equipment->getSlug()}}" title="{{$equipment->getText('equipment.title')}}" href="{{$equipment->get('equipment.image3')->getMain()->getUrl()}}"></a>
						@endif
							<h5>{{$equipment->getText('equipment.title')}}</h5>
							{{$equipment->get('equipment.content')->asHtml()}}
						</div>
					</li>
				@endforeach
				</ul>
			</div><!-- /.span12 -->
		</div><!-- /.row -->
	</div><!-- /.container (page container)-->
@stop

@section('scripts')
	<script src="/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script src="/fancybox/jquery.easing-1.3.pack.js"></script>
	<script src="/js/jquery.isotope.min.js"></script>
	<script>
		$(document).ready(function(){
			// fancybox gallery
			$("a.js-fancybox").fancybox({
				'transitionIn'  :   'elastic',
				'transitionOut' :   'elastic',
				'speedIn'       :   600, 
				'speedOut'      :   200, 
				'overlayShow'   :   true
			});
		});

		// initialize Isotope inside $(window).load() instead of $(document).ready()
		// because Isotope needs to measure media size to avoid items overlapping
		$(window).load(function(){
			// isotope filter setup
			var $container = $(".portfolio");
			$container.isotope({
				filter: "*",
				animationOptions: {
					duration: 750,
					easing: 'linear',
					queue: false,
				}
			});
			// isotope filter button
			$(".filter a").click(function(){
				var selector = $(this).attr('data-filter');
				$container.isotope({ 
					filter: selector,
					animationOptions: {
						duration: 750,
						easing: 'linear',
						queue: false,
					}
				});
				return false;
			});
			// filter button behavior
			var $optionSets = $('.filter'),
			$optionLinks = $optionSets.find('a');
			$optionLinks.click(function(){
				var $this = $(this);
				// don't proceed if already selected
				if ( $this.hasClass('active') ) {
					return false;
				}
				// add active class to selected filter button
				var $optionSet = $this.parents('.filter');
				$optionSet.find('.active').removeClass('active');
				$this.addClass('active');
			});

		@if($focus != null)
			$("a[data-filter='.cat-{{$focus}}']", ".filter").click();
		@endif
		});
	</script>
@stop