<?php
namespace App\Http\RequestHandlers ;

use App\Models\Relatable;

use App\Models\Post;

use App\Models\Comment;


/**
 *
 * Link one resource to another resource
 *
 * Example usage:
 * $related = (new CreateResourceRequest($parent_type, $parent_guid, $child_type, $child_guid))->handle();
 *
 **/

class CreateRelatedResourcesRequest {


    /**
     * @param string we can use this to set the parent table scope
     */
    private $parent_type = false ;

    /**
     * @param string the globally unique parent identifier
     */
    private $parent_guid = false ;

    /**
     * @param object the parent model instance
     */
    private $parent_resource = false ;

    /**
     * @param string the related guid
     */
    private $child_type = false ;

    /**
     * @param string the globally unique child identifier
     */
    private $child_guid ;

    /**
     * @param object the child model instance
     */
    private $child_resource = false ;

    /**
     * @param array add errors here
     */
    private $errors = null ;


    /**
     * example
     */
    public function __construct($parent_type, $parent_guid, $child_type, $child_guid){

        $this->validateRequest($parent_type, $parent_guid, $child_type, $child_guid);

    }


    /**
     * Relate the resources
     */
    public function handle(){


        if(count($this->errors)) {

            return $this->errors;

        }


        $this->parent_resource = $this->getResource($this->parent_type, $this->parent_guid);

        $this->child_resource  = $this->getResource($this->child_type, $this->child_guid);


        if($this->isRelated()) {

            return 'The resources are already related' ;

        }

        $relatable                = new Relatable ;

        $relatable->guid          = makeGuid();

        $relatable->parent_id     = $this->parent_resource->id ;

        $relatable->parent_guid   = $this->parent_resource->guid ;

        $relatable->parent_type   = $this->parent_type ;


        $relatable->child_id      = $this->child_resource->id ;

        $relatable->child_guid    = $this->child_resource->guid ;

        $relatable->child_type    = $this->child_type ;


        $relatable->save();

        return $relatable ;


    }

    private function validateRequest($parent_type, $parent_guid, $child_type, $child_guid){


        if(isGuid($parent_guid)) {

            $this->parent_guid = $parent_guid ;

        } else {

            $this->errors[] = 'The resource guid format was not recognised' ;

        }

        if(array_key_exists($parent_type, config('resourcemap'))) {

            $this->parent_type = $parent_type ;

        } else {

            $this->errors[] = 'The parent resource type was not recognised. Check the config for allowed types.' ;

        }

        if(isGuid($child_guid)) {

            $this->child_guid = $child_guid ;

        } else {

            $this->errors[] = 'The related child guid format was not recognised' ;

        }

        if(array_key_exists($child_type, config('resourcemap'))) {

            $this->child_type = $child_type ;

        } else {

            $this->errors[] = 'The related resource type was not recognised. Check the config for allowed types.' ;

        }

    }


    /**
     * @param string $type the resource type
     * @param string $guid the resource identifier
     */
    private function getResource($type, $guid) {

        $resource = false ;

        switch($type){
            case 'posts' :
                $resource =  Post::byGuid($guid)->first();
            break;
            case 'comments' :
                $resource =  Comment::byGuid($guid)->first();
            break;
        }

        return $resource ;

    }

    /**
     * Check if the two resources are already related
     */
    private function isRelated() {

        return Relatable::where(['parent_guid' => $this->parent_guid, 'child_guid' => $this->child_guid])->first();

    }


} // end class