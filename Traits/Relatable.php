<?php
namespace App\Models\Traits ;


/**
 *
 * Add this trait to any model that you want to be relatable
 *
 */

trait Relatable {

    /**
     *
     * @param string $type = the type is the table name and is also used in the url
     *
     */
    protected function relatable($type){

        // hasMany relatables that match the current instance guid
        return $this->hasMany('App\Models\Relatable', 'parent_guid', 'guid')

            // scope the relatable table to match the resource we're looking for
            ->ChildType($type)

            // join the $type ($type is synonymous with table)
            ->leftJoin($type, "$type.id", '=', 'relatables.child_id');

    }

    public function related_posts(){
        return $this->relatable('posts');
    }

    public function related_comments(){
        return $this->relatable('comments');
    }

}