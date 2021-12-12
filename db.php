<?php 
   require 'asset/rb-sqlite.php';

   R::setup('sqlite:data/chart.db');

   if ( !R::testConnection() )
   {
           exit ('Нет соединения с базой данных');
   }

   session_start();
 ?>
