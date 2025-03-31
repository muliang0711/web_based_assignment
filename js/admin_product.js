// admin_product.js
$(document).ready(function() {

    // Show the Search Overlay
    $("#search").click(function() {
      // Fade in slowly (400ms is default, you can use 'slow' too)
      $(".search-overlay").fadeIn("slow");
    });
  
    // Hide the Search Overlay
    $("#cancelSearch").click(function(){
      $(".search-overlay").fadeOut("slow");
    });
  
    // Show the Add Product Overlay
    $("#add").click(function(){
      $(".add-overlay").fadeIn("slow");
    });
  
    // Hide the Add Product Overlay
    $("#cancelAdd").click(function(){
      $(".add-overlay").fadeOut("slow");
    });
  
    // Show the Update Overlay & fill data
    $(".updateProductBtn").click(function() {
      // We can fill data in the form if we like:
      var productId   = $(this).data("productid");
      var productName = $(this).data("productname");
      var seriesId    = $(this).data("seriesid");
      var seriesName  = $(this).data("seriesname");
      var price       = $(this).data("price");
      var stock       = $(this).data("stock");
      var sizeId      = $(this).data("sizeid");
  
      // Fill fields in the update form
      $("#updateForm input[name='productId']").val(productId);
      $("#updateForm input[name='productName']").val(productName);
      $("#updateForm input[name='seriesId']").val(seriesId);
      $("#updateForm input[name='seriesName']").val(seriesName);
      $("#updateForm input[name='price']").val(price);
      $("#updateForm input[name='stock']").val(stock);
      $("#updateForm input[name='sizeId']").val(sizeId);
      $("#updateForm input[name='oldSizeID']").val(sizeId);
  
      // Show the overlay
      $(".update-overlay").fadeIn("slow");
    });
  
    // Hide the Update Overlay
    $(".cancelUpdateBtn").click(function() {
      $(".update-overlay").fadeOut("slow");
    });
  
    // Delete confirmation
    $(".btn-delete").click(function(e) {
      e.preventDefault(); // Prevent default button click
  
      var row         = $(this).closest("tr");
      var deleteForm  = row.find(".deleteForm").first(); 
      // Adjust if your hidden form is not in the same row
  
      if (deleteForm.length === 0) {
        console.error("Delete form not found! Check your HTML structure.");
        return;
      }
  
      var productName = $(this).data("productname");
      var productId   = $(this).data("productid");
      var seriesId    = $(this).data("seriesid");
      var seriesName  = $(this).data("seriesname");
      var price       = $(this).data("price");
      var stock       = $(this).data("stock");
      var sizeId      = $(this).data("sizeid");
  
      var confirmMessage = "Are you sure you want to delete the following product?\n\n";
      confirmMessage += "Product Name: " + productName + "\n";
      confirmMessage += "Product ID: " + productId + "\n";
      confirmMessage += "Series ID: " + seriesId + "\n";
      confirmMessage += "Series Name: " + seriesName + "\n";
      confirmMessage += "Price: $" + price + "\n";
      confirmMessage += "Stock: " + stock + "\n";
      confirmMessage += "Size ID: " + sizeId + "\n";
  
      if (confirm(confirmMessage)) {
        deleteForm.submit(); // Submit the hidden form
      }
    });

    
  
  });
  