<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Restock Scanner</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        #qr-reader {
            width: 300px;
            margin: auto;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
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

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        #restock-status {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>📦 Product Restock - QR Scanner</h2>
    <div id="qr-reader"></div>

    <div id="product-info" class="card" style="display: none;"></div>

    <div id="restock-form" class="card" style="display: none;">
        <p>
            <label for="newQty">New Quantity:</label>
            <input type="number" id="newQty" min="1" required />
            <button id="restock-btn">Confirm Restock</button>
        </p>
        <p id="restock-status"></p>
    </div>

    <script>
        let scannedData = null;

        function onScanSuccess(decodedText, decodedResult) {

            console.log(`QR Code scanned: ${decodedText}`);
            
            html5QrcodeScanner.clear();

            // Send QR URL to backend for verification
            // decode text sample : verify-stock.php?productID=...&sizeID=...&token=...

            $.getJSON(decodedText, function(data) {
                // backend return sucess : IF FOUND URL 
                if (data.success) { 
                    // 1. save the upload data 
                    scannedData = data;
                    // 2. ouput product information 
                    $("#product-info").html(`
                        <h3>Product Found:</h3>
                        <p><strong>Name:</strong> ${data.product_name}</p>
                        <p><strong>Size:</strong> ${data.size_label}</p>
                        <p><strong>Current Stock:</strong> ${data.quantity}</p>
                    `).fadeIn();

                    $("#restock-form").fadeIn();
                } else {
                    // backend return fail : URL NOT FOUND 
                    $("#product-info").html(`<p style="color:red;">${data.message}</p>`).fadeIn();
                }
            // ERROR HANDLE 
            }).fail(function(err) {
                console.log(decodedText);
                console.error("Error verifying QR:", err);
                $("#product-info").html(`<p style="color:red;">Verification failed.</p>`).fadeIn();
            });
        }
        
        $("#restock-btn").on("click", function () {
            const newQty = $("#newQty").val();

            $.ajax({
                url: '/web_based_assignment/pages/admin/product/update-stock.php', // PROCESS FILE 
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    productID: scannedData.productID,
                    sizeID: scannedData.sizeID,
                    token: scannedData.token,
                    new_quantity: newQty
                }),
                success: function (data) {
                    $("#restock-status").text(data.message).css("color", data.success ? "green" : "red");
                }
            });
        });

        const html5QrcodeScanner = new Html5QrcodeScanner(
            // detect way ; i seconds 10 times ;  box size 
            "qr-reader", { fps: 10, qrbox: 250 });
        // start detect : once detect qr than trigger fucntion 
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>
