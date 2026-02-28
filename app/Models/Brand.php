<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public static function brands() {
        $getBrands = Brand::where('status', 1)->get();
        $getBrands = json_decode(json_encode($getBrands), true);
        return $getBrands;
    }
}
