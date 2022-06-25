<?php

namespace App;

class CollectionMacro
{
    public function columns() {

        return function ($columns) {

            if (!is_array($columns)) {
                $columns = [$columns];
            }

            return $this->map(function ($item) use ($columns) {
                $newItem = [];
                foreach ($columns as $column) {
                    if (array_key_exists($column, $item)) {
                        $newItem[$column] = $item[$column];
                    }
                }

                return $newItem;
            });
        };
    }
}
