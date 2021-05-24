<?php
namespace App\Http\Services; 
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Http\Model\Product;


class ProductService{
	
	public function getAllProduct($searchname,$searchstatus){
		
		
		$allProducts  = Product::where('product_id','!=',"");
		
		if($searchname != "" ){
			
			$allProducts = $allProducts->where('product_name','like','%'.$searchname.'%');
		} 
		
		if($searchstatus != "" ) {
			if($searchstatus == 'Active' || $searchstatus == 'active') $searchstatus = 1;
			else if($searchstatus == 'Inactive' || $searchstatus == 'inactive') $searchstatus = 0;
			
			$allProducts = $allProducts->where('status',$searchstatus);
		}
		
		$allProducts = $allProducts->get();
		
		$All = array();
		foreach($allProducts as $P){
			
			$product = array();
			
			$product['id'] 		= 	$P->product_id;
			$product['name'] 	= 	$P->product_name;
			$product['status'] 	= 	$P->status;
			$product['image']	=	array();
			
			if($P->product_image_id != ""){
				$ids	= explode(',',$P->product_image_id);
				$images = DB::table('product_attachment')->whereIn('attachment_id',$ids)->get()->toArray();
				$product['image'] = $images;
			}
			
			$All[]  = $product;
			
		}
		
		$returnArray['product'] = $All;
		$returnArray['searchname'] = $searchname;
		$returnArray['searchstatus'] = "";
		
		if($searchstatus != ""){
			if($searchstatus == 1) $returnArray['searchstatus'] = 'Active';
			else if($searchstatus == 0) $returnArray['searchstatus'] = 'In Active';
		}
		
		return $returnArray;
	}
		
	public function ProductSave($data){
		
		$product = array();
		
		$product['product_name']		=	$data['productname'];
		$product['short_description']	=	$data['short_description'];
		$product['description']			=	$data['description'];
		
		$product['status']				=	0;
		if(isset($data['status']) && $data['status'] == 'on') $product['status'] = 1;
		
		$product['product_image_id']	=	"";
		
		if(isset($data['image']) && count($data['image'])){
			
			$imageid  = $this->StoreProductImages($data['image']);
			$product['product_image_id'] = $imageid;
			
			if($data['productid'] != ""){
				
				$existimage = array();
				$deleteimage = array();
				
				$imagedatas  = DB::table('product')->where('product_id',$data['productid'])->get();
				
				if(count($imagedatas) && $imagedatas[0]->product_image_id != ""){
					$existimage = explode(',',$imagedatas[0]->product_image_id);
				}
				
				if($data['deleteimage'] != ""){
					$deleteimage= explode(',',$data['deleteimage']);
				}
				
			
				$existImg = array();
				if(count($deleteimage)) {
					$existImg = array_diff($existimage,$deleteimage);
				}else{
					$existImg = $existimage; 
				}
				
				$existImg_str = "";
				
				if(count($existImg)){
					$existImg_str = implode(',',$existImg);
					if($product['product_image_id'] != "") $product['product_image_id'] = $product['product_image_id'].','.$existImg_str;
					else  $product['product_image_id'] = $existImg_str;
				} 
				
			}
		}
		
		if($data['productid'] == ""){
			$productid  = Product::insertGetId($product);
		}else{
			$productid = $data['productid'];
			DB::table('Product')->where('product_id',$productid)->update($product);
		}
		
		return $productid;
	}
	
	public function StoreProductImages($all_images){
		
		$attchmentid = array();
		
		foreach($all_images as $image){
			
			$originalname	=  $image->getClientOriginalName();
			$ext			=  $image->getClientOriginalExtension();
			
			$today_datetime	=	date('Y-m-dH:i:s');
			
			$filetoupload	=	$originalname;
			
			$filepath		=	public_path().'\ProductImage';
			
			
			$image->move($filepath, $filetoupload);

			$Create['image_path'] =  '/ProductImage/'.$filetoupload;
			
			$attchmentid[] = DB::table('product_attachment')->insertGetId($Create);
		
		}
		
		$imageid  = "";
		if(count($attchmentid)) $imageid = implode(',',$attchmentid);
		
		return $imageid;
		
	}
	
	public function getProductDetails($productid){
		
		$productDetails  = Product::where('product_id',$productid)->get();
		
		$productimages  = $productDetails[0]->product_image_id;
		
		$images = array();
		if($productimages != ""){
			$ids	= explode(',',$productimages);
			$images = DB::table('product_attachment')->whereIn('attachment_id',$ids)->get()->toArray();
		}
		
		$productFullDetails['alldetails'] = $productDetails;
		$productFullDetails['productImage'] = $images;
		
		return $productFullDetails;
		
	}
	
	public function getProductEdit($productid){
		
		$productDetails  = Product::where('product_id',$productid)->get();
		
		$productimages  = $productDetails[0]->product_image_id;
		
		$images = array();
		if($productimages != ""){
			$ids	= explode(',',$productimages);
			$images = DB::table('product_attachment')->whereIn('attachment_id',$ids)->get()->toArray();
		}
		
		$productFullDetails['alldetails'] = $productDetails;
		$productFullDetails['productImage'] = $images;
		
		return $productFullDetails;
		
	}

}

?>