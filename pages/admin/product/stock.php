<?php 
    require_once __DIR__ . "/../../../_base.php";
    include_once __DIR__ . "/../../../admin_login_guard.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Stock Management with QR Restock</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .body {
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
            width: 1400px;
            background-color: #f8d7da;
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
            position: fixed;
            top: -50%;
            left: 32%;

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

        .container {
            width: 100%;
            max-width: 410px;
            max-height: 900px;
            background-color: transparent;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            /* allow top alignment if it grows */
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
        <div class="top" id="messageBar"></div>

        <div class="middle" id="productContainer">

            <?php
            // 1. get low_stock product from session and dispaly it :
            $lowStockProducts = $_SESSION['low_stock_product'] ?? [];

            if (!is_array($lowStockProducts)) {
                $lowStockProducts = []; // fallback
            }
            // 2. display it ; 
            ?>
            <?php
            foreach ($lowStockProducts as $productObject): ?>
                <!-- start -->
                <div class="container">
                    <!-- top side  -->
                    <div class="product-card">
                        <div class="top-side">
                            <div class="true-card">
                                <div class="picture-card">
                                    <div class="picture">
                                        <img width="150px" height="250px" id="productImage" src="../../../File/<?php echo  $productObject->image_path; ?>" alt="Product Image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- middle side  -->
                        <div class="middle-side">
                            <div class="true-card">
                                <div class="information">
                                    <div class="product-name dsc">
                                        <h2><?php echo $productObject->productName ?></h2>
                                    </div>
                                    <div class="product-series-name dsc"><span>
                                            <p>RM <?php echo $productObject->price ?>.00</p>
                                        </span></div>
                                    <div class="size-id dsc"><span>3UG5 / 4UG5</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- bottom side  -->
                        <div class="bottom-side">
                            <div class="true-card">
                                <div class="function">
                                    <!-- <div class="btn"><button class="btn">Add to Cart</button></div>
                <div class="btn"><button class="btn">Buy</button></div> -->
                                    <div class="btn"><button class="btn" onclick="window.location.href='../product/productDetail.php?racket=<?php echo $productObject->productID ?>'">View Details</button></div>
                                    <!--<?php //if (!$userID) {
                                        //prompt_user_login("Please log in to add to cart.");
                                        //}
                                        ?> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- the end  -->
                </div>

            <?php endforeach ?>


        </div>

        <div class="bottom">
            <button onclick="location.href = 'admin_product.php' " >Back to Menu       </button>
            <button onclick="startQRScanner()"                  >update stock       </button>
            <button onclick="changeThreshold()"                 >Change Threshold   </button>
        </div>

        <!-- QR Reader + Info -->

        <div id="qr-reader" style="display:none;">
        <button id="close-scanner" style="float:right; margin-bottom:5px;">✖ Close</button>
        </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>


    <script>
    const backendURL = "/../../../controller/api/stockManager.php";
    let scannedData = null;

    function startQRScanner() {
        document.querySelector("#qr-reader").style.display = "block";

        const qrScanner = new Html5QrcodeScanner("qr-reader", {
            fps: 10,
            qrbox: 250
        });

        qrScanner.render(async (decodedText) => {
            console.log(" QR scanned:", decodedText);
            qrScanner.clear();
            document.querySelector("#qr-reader").style.display = "none";

            try {
                const response = await fetch(decodedText);
                const data = await response.json();

                const productInfo = document.querySelector("#product-info");
                const restockForm = document.querySelector("#restock-form");

                if (data.success) {
                    scannedData = data;
                    productInfo.innerHTML = `
                        <h3>Product Found:</h3>
                        <p><strong>Name:</strong> ${data.product_name}</p>
                        <p><strong>Size:</strong> ${data.size_label}</p>
                        <p><strong>Current Stock:</strong> ${data.quantity}</p>
                    `;
                    productInfo.style.display = "block";
                    restockForm.style.display = "block";
                } else {
                    productInfo.innerHTML = `<p style="color:red;">${data.message}</p>`;
                    productInfo.style.display = "block";
                }
            } catch (err) {
                console.error(" QR verify error:", err);
                document.querySelector("#product-info").innerHTML =
                    `<p style="color:red;">Verification failed.</p>`;
            }
        

        });
        document.addEventListener("DOMContentLoaded", () => {
            const closeBtn = document.getElementById("close-scanner");
            if (closeBtn) {
                closeBtn.addEventListener("click", async () => {
                    if (qrScannerInstance) {
                        await qrScannerInstance.clear();
                    }
                    document.querySelector("#qr-reader").style.display = "none";
                });
            }

            const restockBtn = document.querySelector("#restock-btn");
            if (restockBtn) {
                restockBtn.addEventListener("click", handleRestockSubmit);
            }

            window.startQRScanner = startQRScanner;
        });
    }

    //  Handle restock submission
    async function handleRestockSubmit() {
        const newQty = document.querySelector("#newQty").value;
        if (!newQty || !scannedData) return;

        try {
            const response = await fetch("https://wbproject.local/pages/admin/product/update-stock.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    productID: scannedData.productID,
                    sizeID: scannedData.sizeID,
                    token: scannedData.token,
                    new_quantity: newQty
                })
            });

            const data = await response.json();

            const statusBar = document.querySelector("#restock-status");
            const msgBar = document.querySelector("#messageBar");

            statusBar.textContent = data.message;
            statusBar.style.color = data.success ? "green" : "red";

            if (data.success && msgBar) {
                msgBar.className = "top success";
                msgBar.textContent = "Stock updated successfully!";
            }
        } catch (err) {
            console.error("Restock fetch failed:", err);
            document.querySelector("#restock-status").textContent = "Update failed.";
            document.querySelector("#restock-status").style.color = "red";
        }
    }

    window.addEventListener("DOMContentLoaded", () => {

        // console.log("DOM is ready. Starting everything...");

        // fetchLowStock(); // run immediately
        // setInterval(fetchLowStock, 5000); // auto refresh every 5s

        const restockBtn = document.querySelector("#restock-btn");
        if (restockBtn) {
            restockBtn.addEventListener("click", handleRestockSubmit);
        }

        // Optional: assign startQRScanner to a button if needed
        window.startQRScanner = startQRScanner;
    });
</script>

</body>

</html>