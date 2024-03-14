 // Function to validate password and confirm password on input
 let a = document.getElementById("password").addEventListener("input", validatePassword);
 document.getElementById("confirmPassword").addEventListener("input", validatePassword);
 


 function validatePassword() {
    console.log("working");
   var password = document.getElementById("password").value;
   var confirmPassword = document.getElementById("confirmPassword").value;
   var passwordError = document.getElementById("passwordError");

   if (password !== confirmPassword) {
     passwordError.style.display = "block";
   } else {
     passwordError.style.display = "none";
   }
 }


 function checkUser(){
        
    var username = $('#username').val();
    
    console.log("check user function");
    
    $.ajax({
        
        type: "GET",
        url: '../../authapi.php',
        dataType: "json",
        success: function (response) { 
            console.log(response);
            
            var userExists = response.find(i => i.username === username && i.otp_verified === 'YES');

                  if(userExists){

                      document.getElementById('usernameerror').innerHTML = `${username} already exist, try different username`;
                      document.getElementById('usernameerror').style.color="red";
                      document.getElementById('username').value="";
                  }else{
                      document.getElementById('usernameerror').innerHTML = 'Perfect';
                      document.getElementById('usernameerror').style.color="green";
                  }
              
        }, 
        error: function () { 
            alert("SERVER ERROR! PLEASE TRY AGAIN WITH PROPER INTERNET CONNECTION"); 
        } 
        
        
    })

}

function checkEmail(){
    
    var email = $('#email').val();
    
    console.log("check emal");
    $.ajax({
        
        type: "GET",
        url: '../../authapi.php',
        dataType: "json",
        success: function (response) { 
                
                var userExists = response.find(i => i.email == email && i.otp_verified === 'YES');

                  if(userExists){
                      document.getElementById('emailerror').innerHTML = `${email} already exist`;
                      document.getElementById('email').value="";
                      document.getElementById('emailerror').style.color = "red";
                  }else{
                      document.getElementById('emailerror').innerHTML = 'Perfect';
                      document.getElementById('emailerror').style.color = "green";
                  }
       
        }, 
        error: function () { 
            alert("SERVER ERROR! PLEASE TRY AGAIN WITH PROPER INTERNET CONNECTION"); 
        } 
        
        
    })

}