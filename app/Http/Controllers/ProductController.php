<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Model\Product;
use App\Http\Services\ProductService;
use DB;
class ProductController extends Controller{
	
	public function index(){
		
		$searchname  = "";
		$searchstatus  = "";
		
		if(isset($_GET['searchname'])) $searchname  = $_GET['searchname'];
		if(isset($_GET['searchstatus'])) $searchstatus  = $_GET['searchstatus'];
		
		
		$productService  = new ProductService();
		$products  = $productService->getAllProduct($searchname,$searchstatus);
		return view('Product.List',['products' => $products]);
	}
	
	public function Edit($id = ""){
		
		$Details  = array();
		$Details['product_id'] = $id;
		if($id != ""){
			$productService  = new ProductService();
			$product_details  = $productService->getProductEdit($id);
			
			$Details['product_details'] = $product_details;
		}
		
		return view('Product.Edit',['details' => $Details]);
	}
	
	public function store(Request $request){
		
		$productService  = new ProductService();
		$product_id  = $productService->ProductSave($request->all());
		
		return redirect('/detail/'.$product_id);
		
	}
	
	public function Detail($producid){
		$productService  = new ProductService();
		$product_details  = $productService->getProductDetails($producid);
		return view('Product.Detail',['productDetail'=>$product_details]);
	}
	
	public function DeleteProduct(Request $request){
		$id  = $request->productid;
		Product::where('product_id',$id)->delete();
	}
	
	public function productExport(Request $request){
		
		$url = $request->url;
		
		$n_serach	= "";
		$st_serach	= "";
		
		$ex = explode('?',$url);
		if(count($ex) == 2){
			$search  = $ex[1];
			
			if($search != ""){
				$searchex  = explode('&',$search);
			}
			
			if(count($searchex)){
				$name_search = explode('=',$searchex[0]);
				$sttaus_search = explode('=',$searchex[1]);
			}
			
			if(count($name_search) == 2) $n_serach  = $name_search[1];
			if(count($sttaus_search) == 2) $st_serach  = $sttaus_search[1];
			
		}
		
		if($st_serach == 'Active' || $st_serach == 'active') $st_serach = 1;
		else if($st_serach == 'Inactive' || $st_serach == 'inactive') $st_serach = 0;
		
		$sql  = "SELECT product_name,status,short_description,description, CASE  WHEN status = 1 THEN 'Active' ELSE 'Inactive' END AS status  FROM product";
		$sql .= " WHERE product_id  != 0";
		
		
		if($n_serach != "") $sql .= " AND ( product_name LIKE  '%".$n_serach."%' OR product_name = '".$n_serach."')";
		if($st_serach != "") $sql .= " AND status = ".$st_serach;
		
		
		$products  = DB::select($sql);
		
		$returnarray = array();
		$returnarray['flag'] = 0;
		if(count($products)){
			$returnarray['flag'] = 1;
		
			$setData = ''; 
			foreach($products as $row_obj) {
				$content[] = (array) $row_obj;
				$columnHeader = "";
				$row = (array) $row_obj;							
				$rowData = ''; 
				$a = array();
				foreach ($row as $value) {  
					$a[] = $value;	
				}
				$setdata[] = $a;
			}
			$columnHeader  = 'Product Name, status , Short Description , Description';
			
			$returnarray['header'] = $columnHeader;
			$returnarray['bodycontent'] = $setdata;
			
		}
		
		echo json_encode($returnarray);
		
	}
	
}

?>