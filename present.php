<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="style_css/bootstrap.min.css" rel="stylesheet">
  <script src="jscript/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="style_css/style.css">
  <script src="jscript/highchart/highcharts.js"></script>
  <script src="jscript/highchart/highcharts-more.js"></script>
  <script src="jscript/highchart/modules/solid-gauge.js"></script>
  <script src="jscript/highchart/modules/exporting.js"></script>
  <script src="jscript/highchart/modules/export-data.js"></script>
  <script src="jscript/highchart/modules/accessibility.js"></script>
  <link rel="stylesheet" href="style_css/my_style.css">

  <title>Презентация</title>
</head>
<body style="min-width: 570px">
  <?php require 'db.php'; ?>
  <div class="container">
    <?php require "navbar.php"; ?>
    <div class="col-sm-12 col-md-10 col-lg-8" id="fon">
      
        <div id="sol_pan" class="chart-container"></div>
        <div id="dg_out" class="chart-container"></div>
        <div id="d_ac_in" class="chart-container"></div>
        <div id="d_ac_out" class="chart-container"></div>
        <div id="batary" class="chart-container"></div>
        <div id="dc_dc_out" class="chart-container"></div>
        <div id="DGU"><img id="img" src="../image/smoke.png"/></div>
        <div id="DGU2"><img id="img2" src="../image/clear.png"/></div>
    </div>
  </div>
<script src="jscript/bootstrap.bundle.min.js"></script>
<script src="jscript/present.js"></script>
</body>
</html>
