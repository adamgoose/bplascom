@section('content')
		<div class="row">
			<div class="span12">
				<h2>{{$page->getText('page.title')}}</h2>
				<hr>
			</div>
		</div>

		<div class="row">
			<div class="span9">
				{{$page->get('page.content')->asHtml()}}
			</div>
			<div class="span3">
				<h4>Used Inventory Categories</h4>
				<ul>
				@foreach($categories as $category)
					<li>
						<a href="/inventory/{{$category->getSlug()}}">{{$category->getText('category.title')}}</a> ({{$inventory->filter(function($equipment) use ($category) {
								if($equipment->get('equipment.category')->getSlug() == $category->getSlug()) return true;
							})->count()}})
					</li>
				@endforeach
				</ul>
			</div>
		</div>
@stop