<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Product Management with QR Restock</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f9f9f9;
    }

    .body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .top-part {
      background-color: #222;
      color: white;
      padding: 1rem;
      position: relative;
    }

    .alertbar {
      text-align: center;
      font-weight: bold;
    }

    .popup {
      background-color: #ff4d4f;
      color: white;
      padding: 0.8rem;
      position: absolute;
      top: 100%;
      left: 50%;
      transform: translateX(-50%);
      z-index: 10;
      margin-top: 10px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      display: none;
    }

    .middle-part {
      flex-grow: 1;
      padding: 2rem;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 1.5rem;
    }

    .product-card-placeholder {
      background: #fff;
      padding: 1rem;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      text-align: center;
      color: #999;
    }

    .bottom-part {
      padding: 1rem;
      background: #fff;
      display: flex;
      justify-content: center;
      gap: 1rem;
      border-top: 1px solid #ddd;
    }

    .btn {
      padding: 0.7rem 1.5rem;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #0056b3;
    }

    #qr-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 999;
      justify-content: center;
      align-items: center;
    }

    #qr-container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      max-width: 400px;
      width: 90%;
      text-align: center;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    #qr-reader {
      width: 100%;
      margin-bottom: 1rem;
    }

    #product-info,
    #restock-form {
      display: none;
      text-align: left;
    }

    input[type="number"] {
      width: 100px;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-left: 10px;
    }

    .close-btn {
      background: #dc3545;
      margin-top: 10px;
    }

    #restock-status {
      margin-top: 10px;
      font-weight: bold;
    }

    @media (max-width: 600px) {
      .bottom-part {
        flex-direction: column;
        align-items: center;
      }
    }
    .container {
  width: 100%;
  max-width: 410px;
  max-height: 900px;
  background-color: transparent;
  display: flex;
  justify-content: center;
  align-items: flex-start; /* allow top alignment if it grows */
  padding: 15px;
}

.product-card {
  width: 100%;
  background-color: #ffffff;
  border-radius: 10px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 10px;
  box-sizing: border-box;
}


.top-side,
.middle-side,
.bottom-side {
  width: 100%;
  background-color: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 10px 0;
}


    .true-card {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 95%;
      height: 90%;
      background-color: transparent;
    }

    .picture-card {
      width: 100%;
      height: 100%;
      background-color: #fff;
      border-radius: 10px;
    }

    .picture {
      width: 100%;
      height: 100%;
      overflow: hidden;
      border-radius: 10px;

      display: flex;
      justify-content: center;
      align-items: center;
    }

    .picture img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      display: block;
      cursor: pointer;
    }

    .information {
      width: 100%;
      height: 100%;
      color: #333;
      background-color: #ffffff;
      text-align: center;
      padding: 10px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .information .dsc {
      margin: 5px 0;
      font-size: 16px;
      background-color: transparent;
      color: #444;
    }

    .function {
      display: flex;
      justify-content: space-evenly;
      align-items: center;
      width: 100%;
    }

    .btn button {
      padding: 10px 15px;
      background-color: #ff6f61;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
      flex: 1;
    }

    .btn button:hover {
      background-color: #e0544b;
    }
    
.product-card {
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;
}

/* Hide bottom-side by default */
.bottom-side {
  transform: translateY(100%);
  opacity: 0;
  transition: all 0.3s ease;
}

/* Show it on hover */
.product-card:hover .bottom-side {
  transform: translateY(0);
  opacity: 1;
}


  </style>


</head>

<body>
  <div class="body">
    <div class="top-part">
      <div class="alertbar" id="alertBar">Checking stock...</div>
      <div class="popup" id="popup"></div>
    </div>

    <div class="middle-part" id="productList"></div>
    <?php
// 1. include needed file
include __DIR__ . "/../../../db/lowStock_alert.php";
// 2. create class 
$check = new CheckStock($_db);
$low_stock_product = $check->get_low_stock_product();
?>

<div class="middle-part">
  <?php if (!$low_stock_product || count($low_stock_product) === 0): ?>
    <div class="product-card-placeholder">🎉 All products are well stocked!</div>
  <?php else: ?>
    <?php foreach ($low_stock_product as $productObject): ?>
      <!-- start -->
      <div class="container">
        <div class="product-card">
          <!-- top side -->
          <div class="top-side">
            <div class="true-card">
              <div class="picture-card">
                <div class="picture">
                  <img width="150px" height="250px" id="productImage"
                    src="../../../File/<?php echo $productObject->image_path; ?>" alt="Product Image" />
                </div>
              </div>
            </div>
          </div>
          <!-- middle side -->
          <div class="middle-side">
            <div class="true-card">
              <div class="information">
                <div class="product-name dsc">
                  <h2><?php echo $productObject->productName ?></h2>
                </div>
                <div class="product-series-name dsc">
                  <p>RM <?php echo $productObject->price ?>.00</p>
                </div>
                <div class="size-id dsc"><span>3UG5 / 4UG5</span></div>
              </div>
            </div>
          </div>
          <!-- bottom side -->
          <div class="bottom-side">
            <div class="true-card">
              <div class="function">
                <div class="btn">
                  <button class="btn"
                    onclick="window.location.href='../product/productDetail.php?racket=<?php echo $productObject->productID ?>'">
                    View Details
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

      <div class="bottom-part">
        <button class="btn" id="openScannerBtn">Restock</button>
        <button class="btn" onclick="window.location.href='../product/admin_product.php'">Back</button>
      </div>
  </div>

  <!-- QR Scanner Modal -->
  <div id="qr-modal">
    <div id="qr-container">
      <div id="qr-reader"></div>

      <div id="product-info"></div>

      <div id="restock-form">
        <p>
          <label for="newQty">New Quantity:</label>
          <input type="number" id="newQty" min="1" required />
          <button id="restock-btn">Confirm Restock</button>
        </p>
        <p id="restock-status"></p>
      </div>

      <button class="btn close-btn" onclick="closeScanner()">Close</button>
    </div>
  </div>

  <script>
    const lowStockThreshold = 5;

    function checkLowStock(products) {
      return products.filter(p => p.stock <= lowStockThreshold);
    }

    function showPopup(message) {
      const popup = document.getElementById('popup');
      popup.innerText = message;
      popup.style.display = 'block';
    }

    function initAlertBar() {
      const alertBar = document.getElementById('alertBar');
      const lowStockItems = checkLowStock(products);
      if (lowStockItems.length > 0) {
        alertBar.innerText = "⚠️ Low stock detected!";
        showPopup("Low stock items:\n" + lowStockItems.map(p => `${p.name} (Stock: ${p.stock})`).join(", "));
      } else {
        alertBar.innerText = "✅ No product in low stock";
      }
    }

    function renderProducts() {
      const container = document.getElementById('productList');
      products.forEach(p => {
        const card = document.createElement('div');
        card.className = 'product-card-placeholder';
        card.innerHTML = `<strong>${p.name}</strong><br>Stock: ${p.stock}`;
        container.appendChild(card);
      });
    }

    window.onload = () => {
      initAlertBar();
      renderProducts();
    }

    let scannedData = null;
    let qrScanner = null;

    function onScanSuccess(decodedText, decodedResult) {
      console.log("QR Scanned:", decodedText);
      qrScanner.clear();

      $.getJSON(decodedText, function(data) {
        if (data.success) {
          scannedData = data;
          $("#product-info").html(`
            <h3>Product Found:</h3>
            <p><strong>Name:</strong> ${data.product_name}</p>
            <p><strong>Size:</strong> ${data.size_label}</p>
            <p><strong>Current Stock:</strong> ${data.quantity}</p>
          `).fadeIn();
          $("#restock-form").fadeIn();
        } else {
          $("#product-info").html(`<p style="color:red;">${data.message}</p>`).fadeIn();
        }
      }).fail(function(err) {
        console.error("Verification failed:", err);
        $("#product-info").html(`<p style="color:red;">Verification failed.</p>`).fadeIn();
      });
    }

    $("#restock-btn").on("click", function() {
      const newQty = $("#newQty").val();
      $.ajax({
        url: 'https://wbproject.local/pages/admin/product/update-stock.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
          productID: scannedData.productID,
          sizeID: scannedData.sizeID,
          token: scannedData.token,
          new_quantity: newQty
        }),
        success: function(data) {
          $("#restock-status").text(data.message).css("color", data.success ? "green" : "red");
        }
      });
    });

    function openScanner() {
      $("#qr-modal").fadeIn();
      qrScanner = new Html5QrcodeScanner("qr-reader", {
        fps: 10,
        qrbox: 250
      });
      qrScanner.render(onScanSuccess);
    }

    function closeScanner() {
      $("#qr-modal").fadeOut();
      if (qrScanner) qrScanner.clear();
      $("#product-info, #restock-form, #restock-status").hide().empty();
    }

    $("#openScannerBtn").on("click", openScanner);
  </script>

</body>

</html>