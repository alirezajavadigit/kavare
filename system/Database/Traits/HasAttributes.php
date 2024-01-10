<?php

namespace System\Database\Traits;

trait HasAttributes
{
    private function registerAttribute($object, string $attribute, $value)
    {
        $this->inCasteAttribute($attribute) == true ? $object->$attribute = $this->casteDcodeAttribute($attribute, $value) : $object->$attribute = $value;
    }

    protected function arrayToAttribute(array $array, $object = null)
    {
        if(!$object){
            $className = get_called_class();
            $object = new $className;
        }
        foreach($array as $attribute => $value) {
            if($this->inHiddenAttribute($attribute))
                continue;

            $this->registerAttribute($object, $attribute, $value);
        }
        return $object;
    }
    protected function arrayToOnjects(array $array)
    {
        $collection = [];
        foreach($array as $value){
            $object = $this->arrayToAttribute($value);
            array_push($collection, $object);
        }

        $this->collection = $collection;
    }
    private function inHiddenAttribute($attribute)
    {
        return in_array($this->hidden, $attribute);
    }

    private function inCasteAttribute($attribute)
    {
        return in_array($this->casts, array_keys($attribute));
    }

    private function caseDecodeValue()
    {
    }
    private function caseEncodeValue()
    {
    }
    private function arrayToCasteEncodeValue()
    {
    }
}
