<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inoviffy</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>


<div class="container">
  <form id='add-form' enctype="multipart/form-data">
    <h2>Add Blog</h2> 
    <div class="alert " id="alertDiv" role="alert"></div>
    @csrf
    <div class="form-group">
      <label>Blog title:</label>
      <input type="text" value=""  class="form-control" placeholder="Enter Title" name="title" required>
    </div>
    <div class="form-group">
      <label>Description :</label>
      <textarea class="form-control" value=""  aria-label="With textarea" name='description' required></textarea>
    </div>
    <div class="form-group">
      <label>Upload:</label>
      <input type="file" name="blogimage" >
      <div id="previewImage"></div>
    </div>
    <div class="form-group">
      <label>Expiry Date:</label>
      <input type="date" value="" name="expirydate" >
    </div>
    <div class="form-group">
      <label>Select Type:</label>
      <select name="type">
        <option value="private">Private</option>
        <option value="pulic">Public</option>
      </select>
    </div>
    <input type="hidden" name="id">
    <input type="submit" class="btn btn-default" value="Save Changes" />
    <a class="btn btn-default" onclick='logoutClick()'>Logout</a>


  </form><hr>
    <table id="blog-list" class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Image</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Exp Date</th>
          <th scope="col">Type</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
</div>

</body>
<script>
$( document ).ready(function() {
    $('#add-form').show();
    $('#toastDiv').hide();
    $("#previewImage").empty();
    getAllBlogList();
    $('#add-form').on('submit', function(e) {
      e.preventDefault();
      var data = new FormData(this);
      $.ajax({
          url: '/blog/add',
          type: 'POST',
          data: data,
          cache:false,
          contentType: false,
          processData: false,
          success:function(info){
            console.log(info.msg);
              $("#alertDiv").addClass('alert-success');
					    $("#alertDiv").text(info.msg);   
              getAllBlogList();
              $("#previewImage").empty();
              $('#add-form')[0].reset();
              setTimeout(function () {  
                $("#alertDiv").removeClass('alert-success');
					      $("#alertDiv").empty(); 
              }, 3000);
          }
      });
     return false;
});   
});
function getAllBlogList() {
  $.ajax({
    type:'GET',
    url:'blog/all',
    success:function(data) {
      $('#blog-list tbody').empty();
				$.each(data.data, function(key, value) {
					$('#blog-list tbody').append( '<tr><th scope="row">'+value.id+'</th><td><img src=storage/image/'+value.image+' alt="blog" width="50" height="50"></td><td>'+value.title+'</td><td>'+value.description+'</td><td>'+value.expirydate+'</td><td>'+value.type+'</td><td><a class="btn btn-primary" onclick="showDetails('+value.id+')">Edit</a><a class="btn btn-danger" onclick="deleteDetails('+value.id+')">Delete</a></td></tr>');
				});
    }
  });
}
function showDetails(id){
  $.ajax({
    type:'GET',
    url:'blog/details/'+id,
    success:function(data) {
      $("#previewImage").empty();
      $( "input[name*='id']" ).val(data.data.id);
      $( "input[name*='title']" ).val(data.data.title);
      $( "textarea[name*='description']" ).val(data.data.description);
      $( "input[name*='expirydate']" ).val(data.data.expirydate);
      $( "select[name*='type']" ).val(data.data.type);
      $("#previewImage").html('<img src=storage/image/'+data.data.image+' alt="blog" width="50" height="50">');
    }
  });
}
function deleteDetails(id){
  $.ajax({
    type:'GET',
    url:'blog/delete/'+id,
    success:function(data) {
      getAllBlogList();
      $('#add-form')[0].reset();
      $("#previewImage").empty();
    }
  });
}
function logoutClick(){
  $.ajax({
    type:'get',
    url:'logout',
    success:function(data) {
      if(data.status){
        $("#alertDiv").addClass('alert-success');
        $("#alertDiv").text('Logout Success Will redirect you in 1 seconds');   
        setTimeout(function () {
          $("#alertDiv").removeClass('alert-success');
          $("#alertDiv").empty(); 
          location.reload();
        }, 1000);
      }
    }
  });
}
</script>
</html>
