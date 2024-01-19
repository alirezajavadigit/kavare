<?php

namespace System\Database\Traits;

trait HasSoftDelete
{
    protected function deleteMethod($id = null)
    {
        $object = $this;
        if ($id) {
            $this->resetQuery();
            $object = $this->findMethod($id);
        }
        if ($object) {
            $object->resetQuery();
            $object->setSql("UPDATE  " . $object->getTableName() . " SET " . $this->getAttributeName($this->deletedAt) . " = NOW()");
            $object->setWhere("AND", $this->getAttributeName($object->primaryKey) . " = ?");
            $object->addValue($object->primaryKey, $object->{$object->primartyKey});
            return $object->executeQuery();
        }
    }
}
