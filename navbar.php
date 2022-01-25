<div class="row">
         <div class="col-sm-12 col-md-10 col-lg-8">
            <nav class="navbar navbar-expand-lg navbar-light ">
              <div class="container-fluid">
                <a class="navbar-brand" href="index.php">СИГМА</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                  <ul class="navbar-nav">
                    <li class="nav-item ">
                      <a class= "nav-link active" href="present.php">Презентация</a>
                    </li>
                  </ul>
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item ">
                      <a class= <?php echo isset($_SESSION['logged_user']) && $_SESSION['logged_user']->role == 'admin' ? "nav-link active" : '"nav-link disabled" tabindex="-1" aria-disabled="true"' ; ?>  aria-current="page" href="oprch.php">ОПРЧ</a>
                    </li>
                  </ul>
                  <ul class="nav justify-content-end">

                     <?php if( isset($_SESSION['logged_user']) )
                     { ?>

                        <li class="nav-item">
                           <a class="nav-link nl-a">Привет <?php echo $_SESSION['logged_user']->username; ?></a>
                        </li> <?php

                        if( $_SESSION['logged_user']->username == 'admin')
                        { ?>
                           <li class="nav-item">
                              <a class="nav-link nl-a" href="signup.php">Регистрация</a>
                           </li> <?php
                        } ?>
                           <li class="nav-item">
                              <a class="nav-link nl-a" id="logout" aria-current="page" href="logout.php">Выход</a>
                           </li> <?php
                     }else
                     { ?>
                        <li class="nav-item">
                          <a class="nav-link nl-a" aria-current="page" href="login.php">Войти</a>
                        </li>
               <?php } ?>

                    
                    
                  </ul>
                </div>
              </div>
            </nav>
         </div>
      </div>
