<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Vertical (basic) form</h2>
  <form action="<?php echo e(url('/save')); ?>" method  = "post">
  
	 <?php echo e(csrf_field()); ?>

    <div class="form-group">
      <label for="email">Name</label>
      <input type="text" class="form-control" id="name"  name="productname">
    </div>
	
    <div class="form-group">
      <label for="pwd">Short Description</label>
      <textarea name ="short_description" class="form-control"></textarea>
    </div>
	
	
	<div class="form-group">
      <label for="pwd">Description</label>
      <textarea name = "description" class="form-control"> </textarea>
    </div>
	
	
    <div class="checkbox">
      <label><input type="checkbox" name="status" > Status</label>
    </div>
	
	<div class="form-group">
      <label for="pwd">Product Image</label>
     <input type="file" name="image">
    </div>
	
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>
