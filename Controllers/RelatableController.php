<?php

namespace App\Http\Controllers\Authorised;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RequestHandlers\CreateRelatedResourcesRequest;

/**
 * Relate on resource to another
 */
class RelatableController extends Controller
{


    /**
     * Relate a resource to another resource
     */
    public function store($parent_type, $parent_guid, $child_type, $child_guid)
    {

        $handler = (new CreateRelatedResourcesRequest($parent_type, $parent_guid, $child_type, $child_guid))->handle();

        $this->setErrors($handler->errors);

        $this->setData(['related' => $handler->data]);

        return $this->APIResponse();

    }

    /**
     * Unrelate a resource
     */
    public function destroy($relatable_guid)
    {

        $resource = Relatable::where('guid', $relatable_guid)->first();

        if(!$resouce) {

            $this->setErrors('Could not find related record');

            $this->sendResponseAndDie();

        }

        $resource->delete();

        $this->setData(['message' => 'Resource was unrelated']);

        return $this->APIResponse();

    }




} // end class