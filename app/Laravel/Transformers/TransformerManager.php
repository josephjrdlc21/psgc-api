<?php

namespace App\Laravel\Transformers;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use App\Laravel\Services\DataArraySerializer;

class TransformerManager{
    
    public function transform($data, $transformer, $type = 'item'){
        $request = Request();
        
        $manager = new Manager;
        $manager->setSerializer(new DataArraySerializer());

        if($request->has('include')){
            $manager->parseIncludes(str_replace(" ", "", $request->get('include')));
        }

        $resource = $type == 'item' ? new Item($data, $transformer) : new Collection($data, $transformer);

        $data = $manager->createData($resource)->toArray();

        return $data;
    }
}