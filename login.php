<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="jscript/jquery-3.6.0.min.js"></script>
   <link rel="stylesheet" href="style_css/bootstrap.min.css">
   <link rel="stylesheet" href="style_css/my_style.css">
   <title>Авторизация</title>
</head>
<body>
   <?php require 'db.php'; ?>
   <div class="container">
      
   <?php 
      require "navbar.php";
      
      if( isset( $_POST['do_login']) )
      {
         $err = array();

         $user = R::findOne('users', 'username = ?', array($_POST['username']) );
         if( $user )
         {
            //имя существует
            if( password_verify($_POST['password'] , $user->password) )
            {
               //все хорошо логиним пользователя
               $_SESSION['logged_user'] = $user;
               header("Location: /"); 
            }else
            {
               $err[] = 'Не правильно введен пароль!';
            }

         }else
         {
            $err[] = 'Пользователь с таким именем не найден!';
         }

      }

   ?>
   
      <div class="row">
         <div class="col-sm-12 col-md-10 col-lg-8">
            <form  class="form-control-sm" method="POST">
               <h2>Аутентификация</h2>
               <?php if( isset($err) )

                        { foreach( $err as $error )
                                 { ?>
                                    <div class="alert alert-danger" role="alert"> <?php echo $error; ?> </div>
                           <?php }
                        } ?>

               <input type="text" name="username" class="form-control" placeholder="Имя Пользователя" value="<?php echo $_POST['username']; ?>" required>
               <input type="password" name="password" class="form-control" placeholder="Пароль" required>
               <div class="d-grid gap-2">
                  <button class="btn btn-primary" type="submit" name="do_login">Войти</button>
               </div>
            </form>
         </div>
      </div>   
   </div>

<script src="jscript/bootstrap.bundle.min.js"></script>   
</body>
</html>      
