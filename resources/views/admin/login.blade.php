<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mega Market Việt Nam</title>

    <!-- Bootstrap -->
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/css/admin.css" rel="stylesheet">
  </head>

  <body class="login">
    
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
      
        <div class="animate form login_form">
          <section class="login_content">
            <form id="admin-login" method="POST" action="/admin/login">
              @csrf
              <h1>MM MEGA MARKET</h1>
              <?php
                $tb = '<h6 style="color: red;">Tên tài khoản hoặc mật khẩu không hợp lệ.</h6>';
                if(isset($login) && $login == false )
                  echo $tb;
              ?>
              
              <div>
                <input type="text" name="email" class="form-control" placeholder="Tài khoản" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required="" />
              </div>
              <div>
              <button class="btn btn-secondary">
                  Đăng nhập
              </button>
              </div>
              <div class="clearfix"></div>
              <div class="separator">
                <div class="clearfix"></div>
                <br />
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <script type="text/javascript" src=/js/admin.js>

    </script>
  </body>
</html>
 