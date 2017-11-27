<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">

    <title>BASE</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('style/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('style/vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- Animate.css -->
    <!--<link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">-->
    <!--<link rel="stylesheet" href="{{ asset('style/vendors/animate.css/css/animate.min.css') }}">-->
    

    <!-- Custom Theme Style -->
 
    <link rel="stylesheet" href="{{ asset('style/css/custom.min.css') }}">
    
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
           
              <h1>直播加盟產品管理</h1>
              <form act="asdfasd" method="post" action="{!! URL::route('Sysadmin.auth.check', [] ) !!}" >
                    {{ csrf_field() }}
                  <div>
                    <input type="text" class="form-control" name="user" placeholder="帳號" required="" />
                  </div>
                  <div>
                    <input type="password" class="form-control" name="passwd"  placeholder="密碼" required="" />
                  </div>
                  <div>
                      
                    <!--<a class="btn btn-default submit" href="#">登入</a>-->
                    <input class="btn btn-default submit"  type="submit" name="登入" style="float: none;" />
                    <!--<a class="reset_pass" href="#">Lost your password?</a>-->
                  </div>
              </form>
        @if($errors->any())
                <font color="red">{{$errors->first()}}</font>
        @endif

              <div class="clearfix"></div>

              <div class="separator">
                <!--<p class="change_link">New to site?-->
                <!--  <a href="#signup" class="to_register"> Create Account </a>-->
                <!--</p>-->

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-shopping-cart"></i> FC SHOP WEB </h1>
                  <p>©2017 All Rights Reserved.  FC BASE WEB TEAM</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> FC TEAM BASE</h1>
                  <p>©2017 All Rights Reserved. FC TEAM</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>