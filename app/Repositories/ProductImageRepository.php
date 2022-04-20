<?php


namespace App\Repositories;


use DateTime;
use App\Models\ProductImage;

class ProductImageRepository
{
    public function insert($inputData)
    {
        $row = ProductImage::create($inputData);
        if ($row && $row->id > 0) {
            return ['success' => true,'product_id'=>$row->id];
        } else {
            return ['success' => false];
        }
    }

    public function delete($id){
        if ($id > 0) {
            $row = ProductImage::find($id);
            if ($row) {
                $row->delete();
                return ['success' => true];
            } else {
                return ['success' => false];
            }
        } else {
            return ['success' => false];
        }
    }
}
