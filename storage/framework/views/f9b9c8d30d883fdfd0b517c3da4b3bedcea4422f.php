<!DOCTYPE html>
<html lang="en">
<head>
 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<style>
form{
	border: 1px solid #e9dfdf;
    width: 600px;
    padding: 50px;
	border-radius: 5px;
}

</style>
<div class="container">
	<div style="margin-bottom:30px;margin-top:30px" class="list_btn">
		<a href = "<?php echo e(url('Product')); ?>"><button style="border: 1px solid #d3caca;color:black">All Product</button></a>
		<?php if($details['product_id'] != ""): ?>
			<a  href="<?php echo e(url( '/detail/'.$details['product_id'])); ?>"><button style="border: 1px solid #d3caca;color:black">Detail</button></a>
		<?php endif; ?>
	</div>
  <h2><?php if($details['product_id'] == ""): ?> Create <?php else: ?> Edit <?php endif; ?> Product</h2>
  <form action="<?php echo e(url('/save')); ?>" method  = "post" enctype = 'multipart/form-data'>
  
	 <?php echo e(csrf_field()); ?>

	 <input type="hidden" name="productid" value  = "<?php echo e($details['product_id']); ?>">
	 
    <div class="form-group">
      <label for="email">Name</label>
      <input type="text" class="form-control" id="name"  name="productname" value = "<?php if($details['product_id'] != ""): ?> <?php echo e($details['product_details']['alldetails'][0]->product_name); ?> <?php endif; ?>" style="width: 300px;">
    </div>
	
    <div class="form-group">
      <label for="pwd">Short Description</label>
      <textarea name ="short_description" class="form-control"  style="width: 300px;"><?php if($details['product_id'] != ""): ?> <?php echo e($details['product_details']['alldetails'][0]->short_description); ?> <?php endif; ?></textarea>
    </div>
	
	
	<div class="form-group">
      <label for="pwd">Description</label>
      <textarea name = "description" class="form-control"  style="width: 300px;"> <?php if($details['product_id'] != ""): ?> <?php echo e($details['product_details']['alldetails'][0]->description); ?> <?php endif; ?></textarea>
    </div>
	
	
    <div class="checkbox">
      <label><input type="checkbox" name="status" <?php if($details['product_id'] != "" && $details['product_details']['alldetails'][0]->status == 1): ?> checked <?php endif; ?>> Status</label>
    </div>
	
	<div class="form-group" style="margin-top:30px">
      <label for="pwd">Product Image</label>
     <input type="file" name="image[]" multiple>
		 <div>
			<input type="hidden" name="deleteimage">
			 <?php if($details['product_id'] != "" && count($details['product_details']['productImage'])): ?> 
				
				<?php $__currentLoopData = $details['product_details']['productImage']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div style="margin-top:20px"  class="imagerow_<?php echo e($image->attachment_id); ?>">
						<span><img src = "<?php echo e(url($image->image_path)); ?>" style="width:10%;height:10%"></span>
						<span style="margin-left:10px"><button type="button" onclick = "ImageDelete(this);" data-id = "<?php echo e($image->attachment_id); ?>">Delete</button></span>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				
			 <?php endif; ?>
		 </div>
    </div>
	
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

<script>
	function ImageDelete(thisval){
		var  imagedelete  = thisval.getAttribute('data-id');
		var exitsdeletid  = $('input[name=deleteimage]').val();
		var r = confirm("Are you sure you want to delete this product?");
		if(r == true){
			if(exitsdeletid == "") {
				$('input[name=deleteimage]').val(imagedelete);
			}else{
				var id  = exitsdeletid.split(',');
				id.push(imagedelete);
				$('input[name=deleteimage]').val(id.join(','));
			}
			
			$('.imagerow_'+imagedelete).remove();
		}
		
	}
</script>
</body>
</html>
