<?php
  require_once  "../admin/main.php";
  require_once "../../_base.php"; 
  require_once "../../db_connection.php";

  $stylesheetArray = ['../../css/adminProductAnlysis.css'];
  link_stylesheet($stylesheetArray);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Report Generator UI</title>
  <style>

  </style>
</head>
<body>
<div class="main-content xx"> 
  <div class="contanier"> 

    <div class="upPart">

      <!-- Top Bar -->
      <div class="top-bar">
        <h2>📊 Generate Admin Report</h2>
      </div>

      <!-- Filter Bar -->
      <div class="filter-bar">
        <form action="" class="filter-form">
          <label for="reportType">Report Type:</label>
      <!--Product Name -->
          <select id="reportType">
            <option>All</option>
            <option></option>
            <option>Inventory</option>
          </select>
      <!--Product SizeId -->
          <select id="reportType">
            <option>All</option>
            <option></option>
            <option>Inventory</option>
          </select>

        <label for="fromDate">From:</label>
        <input type="date" id="fromDate">

        <label for="toDate">To:</label>
        <input type="date" id="toDate">

        <button class="sub-button" type="submit">Generate report</button>

        </form>

      </div>

      <!-- Action Buttons -->
      <div class="decision-bar">
        <button>Clear Filters</button>
        <button>Save Template</button>
      </div>
      
    </div>

    <div class="downpart">

      <!-- Preview Area -->
       <div class="preview-container">

        <div class="preview">
          <h3>📄 Table Report Preview</h3>
          <p>Your report will appear here after generation...</p>
        </div>

        <div class="preview">
          <h3>📄 pdf Report Preview</h3>
          <p>Your report will appear here after generation...</p>
        </div>

        <div class="preview">
          <h3>📄 chart Report Preview</h3>
          <p>Your report will appear here after generation...</p>
        </div>

       </div>
      

      <!-- Export / Download Buttons -->
      <div class="decision-bar" style="margin-top: 20px;">
        <button>Export as PDF</button>
        <button>Export as Excel</button>
        <button>Send to Email</button>
      </div>

    </div>

  </div> 
</div>
    


</body>
</html>
