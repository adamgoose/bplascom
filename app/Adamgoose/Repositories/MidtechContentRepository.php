<?php namespace Adamgoose\Repositories;

use Page;
use Slide;
use Category;
use Inventory;
use Illuminate\Support\Collection;

class MidtechContentRepository implements ContentRepositoryInterface {

  public function slides()
  {
    return Slide::get();
  }

  public function inventory()
  {
    $midtech = Inventory::get();
    $bplascom = new Inventory;
    $bplascom = $bplascom->configure('https://bplascom.prismic.io/api', 'MC5Vbk14a2JPNTMwWm9sZ3g4.Tu-_ve-_ve-_ve-_vWIY77-9Vu-_ve-_vTJhdCMgYu-_ve-_vQIAHT_vv70r77-977-9Ju-_ve-_vVgb')->get();

    $inventory = $midtech->merge($bplascom);

    return $inventory;
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
            if($equipment->get('equipment.category')->getSlug() == $category->getSlug()) return true;
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
    $midtech = Inventory::fulltext('my.equipment.content', $query)->get();
    $bplascom = $bplascom->configure('https://bplascom.prismic.io/api', 'MC5Vbk14a2JPNTMwWm9sZ3g4.Tu-_ve-_ve-_ve-_vWIY77-9Vu-_ve-_vTJhdCMgYu-_ve-_vQIAHT_vv70r77-977-9Ju-_ve-_vVgb')->fulltext('my.equipment.content', $query)->get();

    return $midtech->merge($bplascom);
  }

}