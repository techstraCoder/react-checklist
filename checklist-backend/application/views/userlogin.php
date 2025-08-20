<!DOCTYPE html>
<html>
   <head>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Login Page</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <style>
         body {
         background-color: #f5f5f5;
         display: flex;
         align-items: center;
         justify-content: center;
         height: 100vh;
         margin: 0;
         }
         .login-container {
         background-color: #fff;
         padding: 20px;
         border-radius: 5px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         }
      </style>
   </head>
   <body>
      <div class="container">
         <div class="row">
            <div class="col-md-6 offset-md-3">
               <div class="login-container">
                  <h2 class="text-center">Login</h2>
                  <div class="form-group">
                     <label for="username">Username</label>
                     <input type="text" class="form-control" id="username" placeholder="Enter your username" required>
                  </div>
                  <div class="form-group">
                     <label for="password">Password</label>
                     <input type="test" class="form-control" id="password" placeholder="Enter your password" required>
                  </div>
                  <button  class="btn btn-primary btn-block" id="login" onclick="loginUser()">Login</button>
               </div>
            </div>
         </div>
      </div>
      <script>
         function loginUser(){
          
           var  user_name = $('#username').val();
                var  pass_word = $('#password').val();
                 var loginApi="<?PHP echo base_url('index.php/login_user'); ?>";
                
                 if(user_name!='' && user_name!=undefined){
                 $.ajax({
                 url: loginApi,
                 type: 'POST',
                 dataType: 'json',
                 data: {
                     'user_name': user_name,
                     'pass_word': pass_word,
                 },
                 
                 success: function(response){
                     
                    var responseData= JSON.stringify(response);
                     
                      var data  = JSON.parse(responseData);
                      if(data.status === true){
                       window.location.href = '<?PHP echo base_url('index.php/users/dashboard'); ?>';
                       alert(data.msg);
                      }else{
                       alert(data.msg);
                      }
         
         
                     
                     
                 },
                 error: function(xhr, status, error) {
                     console.error('Error:', error);
                   }
                   
             });
           }else{
             alert("fill the fields");
           }
         
           
         }
      </script>
   </body>
</html>