

<div class="modal fade" id="loginSignup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="loginModalTitle">Login</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="loginSignupForm" method="post">
            <input type="hidden" id="action" name="action" value="login">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Email address">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="password">
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <div class="col-md-4">
                    <a class="btn btn-default" href="#" id="toggleLogin" style="text-decoration:none;">Signup</a>
                </div>    
                <div class="col-md-4">
                    <button type="button" id="loginSignupButton" class="btn btn-primary">Login</button>
                </div>
            </div>
        </form>
      </div>
        
    </div>
  </div>
</div>

<script>
    $('#toggleLogin').click(function(evt){

        let loginActive = $('#action');
        let modalTitle = $('#loginModalTitle');
        let loginSignupButton = $('#loginSignupButton');
        let loginLink = $('#toggleLogin');
        evt.preventDefault();

        if(loginActive.val() === 'login'){
            loginActive.val('signup');
            modalTitle.html('Sign up');
            loginSignupButton.html('Sign up');
            loginLink.html('Login');
        }else{
            loginActive.val('login');
            modalTitle.html('Login');
            loginSignupButton.html('Login');
            loginLink.html('Sign up');

        }
    });

    $('#loginSignupButton').click(function(evt){
        evt.preventDefault();

        $.ajax({
            method: 'POST',
            url: 'actions.php',
            data: $('#loginSignupForm').serialize(),
            success: function(data){
                const result = JSON.parse(data);

                alert(result.msg);
                if(result.success){
                  location.href="index.php"; 
                }
                
            },
            failure: function(data){
                console.log(data)
            }
        });

    });

    $('#logout').click(function(evt){
        evt.preventDefault();
        $.ajax({
        method: 'POST',
        url:'actions.php',
        data : $('#logoutForm').serialize(),
        success: function(data){
            alert(data);
            location.href="index.php";
        },
        failure: function(data){
            console.log(data)
        }


        });

    });



</script>

