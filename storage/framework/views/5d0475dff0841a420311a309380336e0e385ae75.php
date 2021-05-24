<!DOCTYPE html>
<html lang="en">
<head>
 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
.heading{
	margin: 45px 500px
}
 .container{
	 margin-top: 50px;
    border: 1px solid #e9dfdf;
    padding: 30px 50px;
    width: 500px;
 }
 .row{
	 margin-top:20px
 }
 label{
	 font-weight:normal;
 }
 .container1{
	 margin: 10px 500px
 }
 .container1 button{
	 margin-left : 20px
 }
</style>
<body>
<div class="heading">
	<h2>Product Management</h2>
	
</div>

<div class="container1">
	<a href = "<?php echo e(url('/Product')); ?>"><button style="border: 1px solid #d3caca;color:black">List</button></a>
	<a href = "<?php echo e(url('/create')); ?>"><button style="border: 1px solid #d3caca;color:black">Add</button></a>
	<a href = "<?php echo e(url('create/'.$productDetail['alldetails'][0]->product_id)); ?>"><button style="border: 1px solid #d3caca;color:black">Edit</button></a>
</div>

<div class="container">

	<div class="row">
		<div class="col-sm-6">
			<label><b>Product Name</b></label>
		</div>
		<div class="col-sm-6">
			<label><?php echo e($productDetail['alldetails'][0]->product_name); ?></label>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6">
			<label><b>Short Description</b></label>
		</div>
		<div class="col-sm-6">
			<label><?php echo e($productDetail['alldetails'][0]->short_description); ?></label>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6">
			<label><b>Description</b></label>
		</div>
		<div class="col-sm-6">
			<label><?php echo e($productDetail['alldetails'][0]->description); ?></label>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-sm-6">
			<label><b>Status</b></label>
		</div>
		<div class="col-sm-6">
			<?php if($productDetail['alldetails'][0]->status == 1): ?> <label>Active</label>
			<?php endif; ?> <label>In Active</label>
			
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6">
			<label><b>Product Image</b></label>
		</div>
		<div class="col-sm-6">
			<?php if(count($productDetail['productImage'])): ?>
				
				<?php $__currentLoopData = $productDetail['productImage']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div style="margin-top:10px"><img src = "<?php echo e(url($img->image_path)); ?>" style="width:50%;height:50%"></div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				
			<?php endif; ?>
			
		</div>
	</div>
	
</div>

</body>
</html>
