<?php


namespace App\Repositories;


use DateTime;
use App\Models\Product;

class ProductRepository
{
    public function insert($inputData)
    {
        $row = Product::create($inputData);
        if ($row && $row->id > 0) {
            return ['success' => true,'product_id'=>$row->id];
        } else {
            return ['success' => false];
        }
    }

    public function getAll(){
        $products = Product::with('images')->get();
        return datatables()->of($products)
        ->addColumn('action', function ($row) {
            $html = '<button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#viewProduct-'.$row->id.'">View</button> ';
            $html .= '<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#editProduct-'.$row->id.'">Edit</button> ';
            $html .= '<button class="btn btn-xs btn-danger" onclick="deleteProduct('.$row->id.')">Delete</button>';
            $html .= '<div class="modal fade" id="viewProduct-'.$row->id.'" role="dialog">
                        <div class="modal-dialog"> 
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">View Product</h4>
                                </div>
                                    <ul>';
                                    foreach($row->images as $image){
                                        $html .= '<li><img src="product_images/'.$image->image.'" width="200" height="100"> </li>';
                                    }
                                    $html .=    '<li>
                                            <label for="name">Name:</label>
                                            <small>'.$row->product_name.'</small>
                                        </li>
                                        <li>
                                            <label for="name">Description:</label>
                                            <small>'.$row->product_description.'</small>
                                        </li>
                                        <li>
                                            <label for="name">Price:</label>
                                            <small>'.$row->product_price.'</small>
                                        </li>
                                    </ul>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>';
                $html .= '<div class="modal fade" id="editProduct-'.$row->id.'" role="dialog">
                        <div class="modal-dialog"> 
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Product</h4>
                                </div>
                                    <ul>';
                                    foreach($row->images as $image){
                                        $html .= '<li><img src="product_images/'.$image->image.'" width="200" height="100"><button class="btn btn-xs btn-danger" onclick="deleteImage('.$image->id.')">Delete</button></li>';
                                    }
                                    $html .=    '<form method="post" enctype="multipart/form-data" id="editProductForm">
                                                    <ul>
                                                        <input type="hidden" id="product_id" name="product_id" value="'.$row->id.'" />
                                                        <li>
                                                            <label for="name">Name:</label>
                                                            <input type="text" id="product_name" name="product_name" value="'.$row->product_name.'" />
                                                            <small id="ProductNameEditError" style="display: none;"></small>
                                                        </li>
                                                        <li>
                                                            <label for="price">Price:</label>
                                                            <input type="number" id="product_price" name="product_price" value="'.$row->product_price.'"/>
                                                            <small id="ProductPriceEditError" style="display: none;"></small>
                                                        </li>
                                                        <li>
                                                            <label for="description">Message:</label>
                                                            <textarea id="product_description" name="product_description">'.$row->product_description.'</textarea>
                                                            <small id="ProductDescriptionEditError" style="display: none;"></small>
                                                        </li>
                                                        <li class="add_images">
                                                            <label for="image">Image:</label>
                                                            <input type="file" name="images[]" id="image"><br>
                                                        </li>       
                                                            <button type="submit" class="btn btn-primary"> Submit</button>
                                                    </ul>
                                                </form>
                                    </ul>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>';
            return $html;
        })->toJson();
    }

    public function update($input,$id){
        if ($id > 0) {
            $row = Product::where('id',$id)->update($input);
            if ($row) {
                return ['success' => true];
            } else {
                return ['success' => false];
            }
        } else {
            return ['success' => false];
        }
    }

    public function delete($id){
        if ($id > 0) {
            $row = Product::find($id);
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
