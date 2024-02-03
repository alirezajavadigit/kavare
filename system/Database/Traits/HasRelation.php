<?php

namespace System\Database\Traits;

trait HasRelation
{
    protected function hasOne($model, $foreignKey, $localKey)
    {
        if ($this->{$this->primaryKey}) {
            $modelObject = new $model();
            return $modelObject->getHasOneRelation($this->table, $foreignKey, $localKey, $this->$localKey);
        }
    }

    public function getHasOneRelation($table, $foreignKey, $otherKey, $otherKeyValue)
    {
        // sql = 'SELECT phones.* FROM users JOIN phones ON users.id = phones.user_id'
        $this->setSql("SELECT `b`.* FROM `{$table}` AS `a` JOIN " . $this->getTableName() . " AS `b` on `a`.`{$otherKey}` = `b`.`{$foreignKey}` ");
        $this->setWhere('AND', "`a`.`$otherKey` = ? ");
        $this->table = 'b';
        $this->addValue($otherKey, $otherKeyValue);
        $statement = $this->executeQuery();
        $data = $statement->fetch();
        if ($data)
            return $this->arrayToAttributes($data);
        return null;
    }

    protected function hasMany($model, $foreignKey, $otherKey)
    {
        if ($this->{$this->primaryKey}) {
            $modelObject = new $model;
            return $modelObject->getHasManyRelation($this->table, $foreignKey, $otherKey, $this->$otherKey);
        }
    }

    public function getHasManyRelation($table, $foreignKey, $otherKey, $otherKeyValue)
    {
        // sql = 'SELECT posts.* FROM categories JOIN posts ON categories.id = posts.cat_id'
        // sql = 'SELECT categories.* FROM categories JOIN categories ON categories.id = categories.parent_id'
        $this->setSql("SELECT `b`.* FROM `{$table}` AS `a` JOIN " . $this->getTableName() . " AS `b` on `a`.`{$otherKey}` = `b`.`{$foreignKey}` ");
        $this->setWhere('AND', "`a`.`$otherKey` = ? ");
        $this->table = 'b';
        $this->addValue($otherKey, $otherKeyValue);
        return $this;
    }
}
