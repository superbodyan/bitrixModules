<?php

namespace superBIT;

use Bitrix\Main\Type;

trait OrmDefault
{
    protected function addItemsToOrmTable($table, $fields = array())
    {
        if (empty($fields))
            return json_encode("NO INPUT DATA");

         try {
             $result = $table::add($fields);
             if ($result->isSuccess()) {
                 return json_encode($result->getId());
             }
         } catch (\Exception $e) {
             return json_encode($e->getMessage());
         }
     }
}