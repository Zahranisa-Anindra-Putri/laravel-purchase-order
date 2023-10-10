<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseOrderLine;
use Validator;
use \DateTime;

use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    // Products
    public function getProductList(){
        $products = Product::paginate(10);
        return view('admin.products.index', ["products" => $products]);
    }
    public function getProductShow(){
        $products = Product::paginate(10);
        return view('admin.products.index');
    }
    public function getProductEdit(){
        $products = Product::paginate(10);
        return view('admin.products.index', ["products" => $products]);
    }
    public function getProductDestroy(){
        $products = Product::paginate(10);
        return view('admin.products.index', ["products" => $products]);
    }

    // Purchase Order Lines
    public function getPurchaseOrderLineList(){
        $purchaseorderlines = PurchaseOrderLine::paginate(10);
        return view('admin.purchaseorderlines.index', ["purchaseorderlines" => $purchaseorderlines]);
    }
    public function getPurchaseOrderLineCreate(){
        $products = Product::all();
        return view('admin.purchaseorderlines.create', ["products" => $products]);
    }
    public function postPurchaseOrderLineInsert(Request $Request, PurchaseOrderLine $PurchaseOrderLine){
        // validator untuk menghindari SQL Injection
        $Validator = Validator::make($Request->all(), [
            'product' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'discount' => 'required',
        ]);

        if ($Validator->fails()) return redirect()->back()->withErrors($Validator->errors());
        
        // Jika form sudah valid,
        // maka input-an akan dimasukkan ke dalam db
        $PurchaseOrderLine->product_id = $Request->post('product');
        $PurchaseOrderLine->qty = $Request->post('qty');
        $PurchaseOrderLine->price = $Request->post('price');
        $PurchaseOrderLine->discount = $Request->post('discount');
        $PurchaseOrderLine->total = (int)$Request->post('qty') * (int)$Request->post('price') - ((int)$Request->post('discount')/100 * (int)$Request->post('price'));
        $PurchaseOrderLine->created_at = new DateTime();
        $PurchaseOrderLine->updated_at = new DateTime();
        $PurchaseOrderLine->save();
        return redirect()->intended(route('admin.purchase.order.lines'));
    }
    public function getPurchaseOrderLineShow($id){

    }
    public function getPurchaseOrderLineEdit($id){

    }
    public function getPurchaseOrderLineDestroy($id){

    }
    public function postPurchaseOrderLineUpdate(){
        
    }
}
