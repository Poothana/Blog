

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
td{
	font-weight:normal;
}


</style>

<div class="container">
  <h2>Product Management</h2>
	<div style="margin-bottom:30px;margin-top:30px" class="list_btn">
		<a href = "{{ url('create') }}"><button style="border: 1px solid #d3caca;color:black">Add Product</button></a>
		<a><button onclick = "exportProduct();" style="border: 1px solid #d3caca;color:black">Export</button></a>
	</div>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
		@if(count($products['product']))
		 <tr>
			<td></td>
			<td style="width:50px"><input type="text" name="search_name" class="form-control" value="{{$products['searchname']}}"></td>
			<td style="width:100px"><input type="text" name="search_status" class="form-control" value="{{$products['searchstatus']}}"></td>
			<td style="width:100px"><button class="listsearch" onclick = "ListSearch();" style="border: 1px solid #d3caca;color:black">Search</button></td>
		 </tr>
		
			@foreach($products['product']  as $P)
			  <tr class="productrow_{{$P['id']}}">
				<td style="width:50px">
					@if(count($P['image']))
						@foreach($P['image']  as $img)
							@if($img->image_path != "")
								<div style="margin-top:20px"><img src="{{url($img->image_path)}}" style="width:50px;height:50px"></div>
							@endif
						@endforeach
					@endif
				
				</td>
				<td>{{$P['name']}}</td>
				<td>
					@if($P['status'] == 1)
						Active
					@else
						In Active
					@endif
				</td>
				<td>
					<a href="{{ url( '/create/'.$P['id']) }}"><i class="fa fa-pencil" style="color: #a8a1a1;"></i></a>
					<a  href="{{ url( '/detail/'.$P['id']) }}"><i class="fa fa-list" style="color: #a8a1a1;"></i></a>
					<i class="fa fa-trash" onclick  = "ProductDelete(this);" data-deleteid = "{{$P['id']}}" style="color: #a8a1a1;"></i> 
				</td>
			  </tr>
			@endforeach
		@endif
    </tbody>
  </table>
</div>

<script>
 function ProductDelete(thisval){
	var productid  = thisval.getAttribute('data-deleteid');
	 var r = confirm("Are you sure you want to delete this product?");
		 if (r == true) {
			$.ajax({
				url: "{{ url('/imagedelete') }}",
				data:{
					_token: '{{csrf_token()}}', 
					productid:productid
					
				},
				method: 'POST',					
				success: function() {
					alert('product Delete Successfully'); 
					$('.productrow_'+productid).remove();
				}
			});
		 } 
 }
 
 function exportProduct(){
	 var url = window.location.href;
	 $.ajax({
		type: "POST", 
		url: "{{ url('/ProductExport') }}",
		data: {
			_token: '{{csrf_token()}}',	
			url :url
		},
		success: function( data ) {	
			var obj = JSON.parse(data);	
			if(obj.flag == 1){
				var csv = obj['header']+'\n';
				obj['bodycontent'].forEach(function(row) {
					csv += '"'+row.join('","')+'"';
					csv += "\n";
				});
				var hiddenElement = document.createElement('a');
				hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
				hiddenElement.target = '_blank';
				hiddenElement.download = 'Product.csv';
				hiddenElement.click();
			}else{
				alert('No data fount for exporting');
			}			
			
		}	
	});
 }
 
 function ListSearch(){
	 var searchname 	 = $('input[name=search_name]').val();
	 var searchstatus  = $('input[name=search_status]').val();
	 
	 var url = window.location.href;
	 
	 var split  = url.split('?');
	 
	 url = split[0]+'?searchname='+searchname+'&searchstatus='+searchstatus;
	 window.location.href = url;
 }
</script>

</body>
</html>
