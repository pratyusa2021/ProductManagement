@extends('product.layout')
@section('content')
<div class="container">
  	<h2>Product Page</h2>
  	<!-- Trigger the modal with a button -->
  	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addProduct" id="addProductModal">Add Product</button>
  	<!-- Modal -->
  	<div class="modal fade" id="addProduct" role="dialog">
    	<div class="modal-dialog"> 
	      	<!-- Modal content-->
	      	<div class="modal-content">
	        	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 class="modal-title">Add Product</h4>
	        	</div>
	        	<form method="post" enctype="multipart/form-data" id="addProductForm">
	        		@csrf
				 	<ul>
				  		<li>
				    		<label for="name">Name:</label>
				    		<input type="text" id="name" name="product_name" />
				    		<small id="ProductNameAddError" style="display: none;"></small>
				  		</li>
				  		<li>
				    		<label for="price">Price:</label>
				    		<input type="number" id="price" name="product_price" />
				    		<small id="ProductPriceAddError" style="display: none;"></small>
				  		</li>
				  		<li>
				    		<label for="description">Message:</label>
				    		<textarea id="description" name="product_description"></textarea>
				    		<small id="ProductDescriptionAddError" style="display: none;"></small>
				  		</li>
				  		<li class="add_image">
				    		<label for="image">Image:</label>
				    		<input type="file" name="images[]" id="images"><br>
				    		<div class="input-group-addon"> 
                                <a href="javascript:void(0)" class="btn btn-success addMore"><span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Add Image</a>
                            </div>
				  		</li>  		
				  			<button type="submit" class="btn btn-primary"> Submit</button>
				 	</ul>
				</form>
				<li class="add_image_copy"  style="display: none;">
		    		<label for="image">Image:</label>
		    		<input type="file" name="images[]" id="images"><br>
		    		<div class="input-group-addon"> 
                        <a href="javascript:void(0)" class="btn btn-danger remove"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove Image</a>
                    </div>
		  		</li>
	        	<div class="modal-footer">
	          		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        	</div>
	      	</div>
    	</div>
  	</div>

	<div class="row">
        <div class="col-md-8">
            <h3>Products</h3>
            <hr>
            <button type="button" class="btn btn-primary reload float-right mb-3">Reload</button>
            <table id="products" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
@endsection
