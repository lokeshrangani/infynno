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
  <div class="alert " id="alertDiv" role="alert"></div>
  <form id='signup-form'>
    <h2>Register</h2>
    @csrf
    <div class="form-group">
      <label>Username:</label>
      <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username">
    </div>
    <div class="form-group">
      <label>Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label>Password:</label>
      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
    </div>
    <a class="btn btn-default" onclick='submitForm("signup")'>SignUp</a>
    <a class="btn btn-default" onclick='openForm("signin")'>SignIn</a>
  </form>
  <form id='login-form'>
    <h2>Login</h2>
    @csrf
    <div class="form-group">
      <label>Username/Email:</label>
      <input type="text" class="form-control" id="username1" placeholder="Enter Username/Email" name="username1">
    </div>
   
    <div class="form-group">
      <label>Password:</label>
      <input type="password" class="form-control" id="password1" placeholder="Enter password" name="password1">
    </div>
    <a class="btn btn-default" onclick='submitForm("signin")'>SignIn</a>
    <a class="btn btn-default" onclick='openForm("signup")'>SignUp</a>
  </form>
</div>

</body>
<script>
$( document ).ready(function() {
    $('#login-form').hide();
    $('#signup-form').show();
    $('#toastDiv').hide();
    $("#alertDiv").hide();
});
function openForm(action){
    if(action == 'signin'){
        $('#signup-form').hide();
        $('#login-form').show();
    }else{
        $('#signup-form').show();
        $('#login-form').hide();
    }
}
function submitForm(action){
    if(action == 'signup'){
        var check=1,email,password,username;
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var username=$('#username').val();
        var email=$('#email').val();
        var password=$('#password').val();
        if(!regex.test(email)){
            check=0;
            alert('Email is not valid');
        }else if(!username.length){
            check=0;
            alert('Username is not valid');
        }else if(password.length < 3){
            check=0;
            alert('Password Length must be > 3');
        }
        if(check){
            var data = $("#signup-form").serializeArray();
            $.ajax({
                url: 'register',
                type: 'POST',
                data: data,
                success:function(info){
                    if(info.status){
                        $("#alertDiv").removeClass('alert-danger').addClass('alert-success');
                    }
                    else{
                        $("#alertDiv").removeClass('alert-success').addClass('alert-danger');
                    }

                    $("#alertDiv").text(info.msg);
                    $("#alertDiv").show();
                    $('#signup-form')[0].reset();
                    setTimeout(function () {  
                        $("#alertDiv").hide();
                    }, 3000);
                }
            });
        }
        return false;
    }else{
        var data = $("#login-form").serializeArray();
        $.ajax({
            url: 'login',
            type: 'POST',
            data: data,
            success:function(info){
              if(info.status){
                    location.href='blog'
                }
                else{
                    $("#alertDiv").removeClass('alert-success').addClass('alert-danger');
                }
                $("#alertDiv").text(info.msg);
                $('#signup-form')[0].reset();
                $("#alertDiv").show();
                setTimeout(function () {  
                    $("#alertDiv").hide();
                }, 1000);
            }
        });
    }
    return false;
}
</script>
</html>
