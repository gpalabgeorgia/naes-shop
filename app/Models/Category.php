<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    public function subcategories() {
        return $this->hasMany('App\Models\Category', 'parent_id')->where('status', 1);
    }

    public function section() {
        return $this->belongsTo('App\Models\Sections', 'section_id')->select('id', 'name');
    }

    public function brand() {

    }

    public function parentcategory() {
        return $this->belongsTo('App\Models\Category', 'parent_id')->select('id', 'category_name');
    }
    public static function catDetails($url) {
       $catDetails = Category::select('id', 'parent_id', 'category_name', 'url', 'description')->with(['subcategories'=>function($query) {
            $query->select('id','parent_id', 'category_name', 'url', 'description')->where('status',1);
       }] )->where('url', $url)->first()->toArray();
       if($catDetails['parent_id']==0) {
        // Only show main  Category in  breadcrumbs
        $breadcrumbs = '<a href="'.url($catDetails['url']).'">'. $catDetails['category_name'].'</a>';
       }else {
        // Show main and sub category in breadcrumbs 
        $parentCategory = Category::select('category_name', 'url')->where('id', $catDetails['parent_id'])->first()->toArray();
        $breadcrumbs = '<a href="'.url($parentCategory['url']).'">'. $parentCategory['category_name'].'</a>&nbsp;<span class="divider">/</span>&nbsp;<a href="'.url($catDetails['url']).'">'. $catDetails['category_name'].'</a>';
       }
       $catIds = array();
       $catIds[] = $catDetails['id'];
       foreach($catDetails['subcategories'] as $key => $subcat) {
        $catIds[] = $subcat['id'];
       }
       return array('catIds'=>$catIds, 'catDetails'=>$catDetails, 'breadcrumbs'=>$breadcrumbs); 
    }
}
