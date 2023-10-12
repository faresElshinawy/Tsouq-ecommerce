<?php

namespace App\Traits;

use App\Models\ProductSize;
use App\Models\ProductColor;

trait ProductExtra
{



    public function addProductAttributes($attrubites, $product, $table)
    {
        $attrName = ucfirst(substr($table, 0, -1));
        $controller = "\App\Models\Product{$attrName}";
        foreach ($attrubites as $attr) {
            $controller::create([
                'product_id' => $product->id,
                substr($table, 0, -1) . '_id' => $attr
            ]);
        }
    }



    public function updateProductAttributes($attrubites, $product, $table)
    {
        $attrName = ucfirst(substr($table, 0, -1));
        $controller = "\App\Models\Product{$attrName}";
        $controller::whereIn(substr($table, 0, -1) . '_id', $product->$table->pluck('id'))->where('product_id', $product->id)->delete();
        $this->addProductAttributes($attrubites, $product, $table);
    }
}
