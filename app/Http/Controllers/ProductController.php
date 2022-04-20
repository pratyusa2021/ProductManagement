<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Repositories\ProductImageRepository;

class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductRepository $productRepository,ProductImageRepository $productImageRepository)
    {
        $this->productRepository = $productRepository;
        $this->productImageRepository = $productImageRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            return  $this->productRepository->getAll();
        }
        else{
            return view('product.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input=$request->all();
        $request->validate([
            'product_name' => 'required',
            'product_price' => 'required|integer',
            'product_description' => 'required',
        ], [
            'product_name.required' => 'Product Name is required',
            'product_price' => 'Product Price is required',
            'product_price.integer' => 'Price should be a number',
            'product_description' => 'Product Description is required'
        ]);

        $data = $this->productRepository->insert($input);

        if ($data['success']==true) {
            $inputImage['product_id'] = $data['product_id'];

            if($request->images != null){
                foreach($request->images as $image){
                    $rand_val           = date('YMDHIS') . rand(11111, 99999);
                    $image_file_name    = md5($rand_val);
                    $file               = $image;
                    $fileName           = $image_file_name.'.'.$file->getClientOriginalExtension();
                    $destinationPath    = public_path().'/product_images';
                    $file->move($destinationPath,$fileName);
                    $inputImage['image']    = $fileName ;

                    $data = $this->productImageRepository->insert($inputImage);
                }
            }
            return redirect()->action('ProductController@index');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $input=$request->only(['product_name','product_price','product_description']);
        $id=$request->product_id;

        $request->validate([
            'product_name' => 'required',
            'product_price' => 'required|integer',
            'product_description' => 'required',
        ], [
            'product_name.required' => 'Product Name is required',
            'product_price' => 'Product Price is required',
            'product_price.integer' => 'Price should be a number',
            'product_description' => 'Product Description is required'
        ]);

        $inputImage['product_id'] = $id;
        if($request->images != null){
            foreach($request->images as $image){
                $rand_val           = date('YMDHIS') . rand(11111, 99999);
                $image_file_name    = md5($rand_val);
                $file               = $image;
                $fileName           = $image_file_name.'.'.$file->getClientOriginalExtension();
                $destinationPath    = public_path().'/product_images';
                $file->move($destinationPath,$fileName);
                $inputImage['image']    = $fileName ;

                $data = $this->productImageRepository->insert($inputImage);
            }
        }
        $data = $this->productRepository->update($input,$id);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->productRepository->delete($id);
    }
    public function destroyImage($id)
    {
        //
        $this->productImageRepository->delete($id);
    }
}
