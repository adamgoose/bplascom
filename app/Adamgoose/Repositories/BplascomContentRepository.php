<?php namespace Adamgoose\Repositories;

use Page;
use Slide;
use Category;
use Inventory;
use Illuminate\Support\Collection;

class BplascomContentRepository implements ContentRepositoryInterface {

  public function slides()
  {
    return Slide::get();
  }

  public function inventory()
  {
    return Inventory::get();
  }

  public function categories()
  {
    return Category::get()->sortBy(function($category) {
      return $category->getText('category.title');
    });
  }

  public function heavyCategories(Collection $inventory)
  {
    return Category::get()->sortBy(function($category) use ($inventory)
      {
        return $inventory->filter(function($equipment) use ($category)
          {
            if($equipment->get('equipment.category')->getId() == $category->getId()) return true;
          })->count();
      })->reverse();
  }

  public function pages()
  {
    return Page::get();
  }

  public function page($slug)
  {
    return Page::findSlug($slug);
  }

  public function searchInventory($query)
  {
    return Inventory::fulltext('my.equipment.content', $query)->get();
  }

}