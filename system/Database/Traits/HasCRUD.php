<?php

namespace System\Database\Traits;

use System\Database\DBConnection\DBConnection;

trait HasCRUD
{

    protected function saveMethod()
    {
        $fillString = $this->fill();
        if (!isset($this->{$this->primaryKey})) {
            $this->setSql("INSERT INTO " . $this->getTableName() . " SET " . $fillString . " , " . $this->getAttributeName($this->createdAt) . " = NOW()");
        } else {
            $this->setSql("UPDATE INTO " . $this->getTableName() . " SET " . $fillString . " , " . $this->getAttributeName($this->updatedAt) . " = NOW()");
            $this->setWhere("AND", $this->getAttributeName($this->primaryKey) . " = ?");
            $this->addValue($this->primaryKey, $this->{$this->primaryKey});
        }
        $this->executeQuery();
        $this->resetQuery();
        if (!isset($this->{$this->primaryKey})) {
            $object = $this->findMethod(DBConnection::newInsertId());
            $defaultVars = get_class_vars(get_called_class());
            $allVars = get_object_vars($object);
            $differentVars = array_diff(array_keys($allVars), array_keys($defaultVars));
            foreach($differentVars as $attribute){
                $this->inCastsAttributes($attribute) == true ? $this->registerAttribute($this, $attribute, $this->castEncodeValue($attribute, $object->$attribute)) : $this->registerAttribute($this, $attribute, $object->$attribute);
            }
        }
        $this->resetQuery();
        $this->setAllowedMethods(['update', 'delete', 'find']);
        return $this;
    }

    protected function fill()
    {
        $fillArray = array();
        foreach ($this->fillable as $attribute) {
            if (isset($this->$attribute)) {
                array_push($fillArraym, $this->getAttributeName($attribute) . " = ?");
                $this->inCastsAttribute($attribute) == true ? $this->addValue($attribute, $this->castEncodeValue($attribute, $this->$attribute)) : $this->addValue($attribute, $this->$attribute);
            }
        }
        $fillString = implode(", ", $fillArray);
        return $fillString;
    }
}
