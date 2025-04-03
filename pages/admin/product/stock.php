<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock Management with QR Restock</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .body {
            width: 900px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .top {
            padding: 12px;
            border-radius: 6px;
            display: none;
            text-align: center;
            font-weight: bold;
        }

        .top.success {
            background-color: #d4edda;
            color: #155724;
            display: block;
        }

        .top.error {
            background-color: #f8d7da;
            color: #721c24;
            display: block;
        }

        .middle {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
            min-height: 100px;
        }

        .bottom {
            display: flex;
            justify-content: space-between;
        }

        .bottom button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
        }

        .bottom button:hover {
            background-color: #0056b3;
        }

        /* QR section */
        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto 0;
        }

        label {
            font-weight: bold;
        }

        input[type="number"] {
            width: 100px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-left: 10px;
        }

        #qr-reader {
            width: 300px;
            margin: auto;
        }

        #restock-form button {
            background-color: #28a745;
            margin-left: 10px;
        }

        #restock-form button:hover {
            background-color: #218838;
        }

        #restock-status {
            margin-top: 10px;
            font-weight: bold;
        }
        
    </style>
</head>
<body>

    <div class="body">
        <div class="top" id="messageBar"></div>

        <div class="middle" id="productContainer"></div>

        <div class="bottom">
            <button onclick="fetchLowStock()">Fetch Low Stock</button>
            <button onclick="startQRScanner()">Restock</button>
            <button onclick="changeThreshold()">Change Threshold</button>
        </div>

        <!-- QR Reader + Info -->
        <div id="qr-reader" style="display:none;"></div>
        <div id="product-info" class="card" style="display: none;"></div>

        <!-- Restock Form -->
        <div id="restock-form" class="card" style="display: none;">
            <p>
                <label for="newQty">New Quantity:</label>
                <input type="number" id="newQty" min="1" required />
                <button id="restock-btn">Confirm Restock</button>
            </p>
            <p id="restock-status"></p>
        </div>
    </div>

    <script>
        let scannedData = null;
        const backendURL = "/../../../controller/api/stock.php";

        $(document).ready(function () {
            window.fetchLowStock = async function () {
                try {
                    const response = await fetch(backendURL, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ action: "get_low_stock_product" })
                    });

                    if (!response.ok) throw new Error("Failed to fetch");

                    const data = await response.json();
                    if (!data.success) throw new Error(data.message);

                    console.log("Low stock data:", data);
                    // Render cards if needed

                } catch (err) {
                    $("#messageBar").removeClass().addClass("top error").text("Error: " + err.message);
                }
            };

            window.changeThreshold = async function () {
                // Optional implementation
            };

            window.updateStock = async function () {
                // Optional implementation
            };

            window.startQRScanner = function () {
                $("#qr-reader").show();
                const qrScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });

                qrScanner.render(async function (decodedText) {
                    console.log("QR scanned:", decodedText);
                    qrScanner.clear();
                    $("#qr-reader").hide();

                    try {
                        const data = await $.getJSON(decodedText);
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
                    } catch (err) {
                        console.error("QR verify error:", err);
                        $("#product-info").html(`<p style="color:red;">Verification failed.</p>`).fadeIn();
                    }
                });
            };

            $("#restock-btn").on("click", function () {
                const newQty = $("#newQty").val();
                if (!newQty || !scannedData) return;

                $.ajax({
                    url: "https://wbproject.local/pages/admin/product/update-stock.php",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        productID: scannedData.productID,
                        sizeID: scannedData.sizeID,
                        token: scannedData.token,
                        new_quantity: newQty , 
                    }),
                    success: function (data) {
                        $("#restock-status").text(data.message).css("color", data.success ? "green" : "red");
                        if (data.success) {
                            $("#messageBar").removeClass().addClass("top success").text("Stock updated successfully!");
                        }
                    },
                    error: function () {
                        $("#restock-status").text("Update failed.").css("color", "red");
                    }
                });
            });
        });
    </script>
</body>
</html>
