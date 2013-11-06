<?php namespace Adamgoose\Repositories;

use Inventory;
use Illuminate\Support\Collection;

interface ContentRepositoryInterface {

  public function slides();

  public function inventory();

  public function categories();

  public function heavyCategories(Collection $inventory);

  public function pages();

  public function page($slug);

  public function searchInventory($query);

}