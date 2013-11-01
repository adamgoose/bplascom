@extends('layouts.master')

@section('content')			
		<div class="row">
			<div class="span12">
				<div id="home-carousel" class="carousel slide">
					<!-- Carousel items -->
					<div class="carousel-inner">
					@foreach($slides as $slide)
						<div class="active item">
							<img src="{{$slide->get('slide.image')->getView('slide')->getUrl()}}" alt="">
						</div>
					@endforeach
					</div>
					<!-- Carousel nav -->
					<a class="carousel-control left" href="#home-carousel" data-slide="prev">&lsaquo;</a>
					<a class="carousel-control right" href="#home-carousel" data-slide="next">&rsaquo;</a>
				</div><!-- /.carousel -->
			</div><!-- /.span -->
		</div><!-- /.row -->
			
		<div class="row">
			<div class="span12">
				<div class="well centered">
					<h3>Browse our used equipment today!&nbsp;&nbsp;<a class="btn btn-primary btn-large" href="/inventory">Inventory <i class="icon icon-caret-right"></i></a></h3>
				</div>
			</div>
		</div>
			
		<div class="row">
		@foreach($inventory->slice(0,4) as $equipment)
			<div class="span3">
				<div class="info-column">
					<img class="img-rounded" src="{{$equipment->get('equipment.image1')->getView('home')->getUrl()}}" alt="{{$equipment->getText('equipment.title')}}">
					<p><strong>{{$equipment->getText('equipment.title')}}</strong></p>
					<p>{{nl2br($equipment->get('equipment.content')->getFirstParagraph()->getText())}}</p>
					<a class="btn btn-primary" href="/inventory/{{$equipment->get('equipment.category')->getSlug()}}">See More &raquo;</a>
				</div>
			</div>
		@endforeach
		</div><!-- /.row -->
@stop