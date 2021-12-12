<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="jscript/jquery-3.6.0.min.js"></script>
   <link rel="stylesheet" href="style_css/bootstrap.min.css">
   <link rel="stylesheet" href="style_css/my_style.css">
   <title>Регистрация</title>
</head>
<body>
   <?php require 'db.php'; ?>
   <div class="container">
      
   <?php 
      require "navbar.php";
      
      if ( isset($_POST['do_signup']) )
      {
         $err = array();
         if( $_SESSION['logged_user']->role != 'admin' )
         {
            $err[] = 'Вы не являетесь администратором';
         }

         if( !preg_match( "/^[a-zA-Z0-9]+$/",trim( $_POST['username'] ) ) )
         {
              $err[] = "Логин может состоять только из букв английского алфавита и цифр";
         }

         if( strlen( trim($_POST['username'] ) ) < 3 or strlen( trim( $_POST['username'] ) ) > 30)
         {
              $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
         }

         if( R::count('users', "username = ?", array($_POST['username'])) > 0 )
         {
            $err[] = 'Пользователь с таким именем существует';
         }

         if( $_POST['password'] == '' )
         {
            $err[] = 'Введите пароль!';
         }

         if( $_POST['password2'] != $_POST['password'] )
         {
            $err[] = 'Повторный пароль введен не верно!';
         }

         if( $_POST['role'] == '' )
         {
            $err[] = 'Введите роль!';
         }

         if( empty($err) )
         {
            // все хорошо регистрируемся
            $user = R::dispense('users');
            $user->username = $_POST['username'];
            $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user->role = $_POST['role'];
            R::store($user);
            echo ' <div class="row">
                     <div class="col-sm-12 col-md-10 col-lg-8">
                        <div class="alert alert-success" role="alert">Вы успешно зарегистрированны <a href = "login.php">Войти</a> </div>
                     </div>
                   </div>';


         }   
      }
         
    ?>
      <div class="row">
         <div class="col-sm-12 col-md-10 col-lg-8">
            <form  class="form-control-sm" method="POST">
               <h2>Регистрация</h2>
               <?php if( isset($err) )
               { foreach( $err as $error )
                        { ?>
                           <div class="alert alert-danger" role="alert"> <?php echo $error; ?> </div>
                  <?php }
               } ?>
               <input type="text" name="username" class="form-control" placeholder="Имя Пользователя" value="<?php echo $_POST['username']; ?>" required>
               <input type="password" name="password" class="form-control" placeholder="Пароль" required>
               <input type="password" name="password2" class="form-control" placeholder="Повторите пароль" required>
               <input type="text" name="role" class="form-control" placeholder="Роль пользователя" required>
               <div class="d-grid gap-2">
                  <button class="btn  btn-primary" type="submit" name="do_signup">Зарегистрироваться</button>
               </div>
            </form>
         </div>
      </div>
   </div>

<script src="jscript/bootstrap.bundle.min.js"></script>   
</body>
</html>
