<?php
namespace App\Models\Traits ;

// add this trait to any models you need to find by guid
// example usage:
// $post = Post::byGuid($guid)->first();
trait ByGuid {

    public function scopeByGuid($query, $guid)
    {
        return $query->where('guid', $guid);
    }

}