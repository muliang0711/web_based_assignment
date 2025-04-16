

$(document).ready(function () {
    console.log("product.js loaded!");
    const $minInput = $('#minPrice');
    const $maxInput = $('#maxPrice');
    const $form = $('.filter-form');
    const $errorMsg = $('#priceError');

    // Set default values if empty or out of range
    $minInput.on('blur', function () {

        let val = parseInt($(this).val());
        if (isNaN(val) || val < 10) {
            $(this).val(10);
        }

    });

    $maxInput.on('blur', function () {
        let val = parseInt($(this).val());
        if (isNaN(val) || val < 100) {
            $(this).val(100);
        } else if (val > 1000) {
            $(this).val(1000);
        }
    });

    // Validate before submit
    $form.on('submit', function (e) {
        const min = parseInt($minInput.val());
        const max = parseInt($maxInput.val());

        let error = "";

        if (isNaN(min) || isNaN(max)) {
            error = "Both prices must be numbers.";
        } else if (min < 10 || min > 1000) {
            error = "Minimum price must be between 10 and 1000.";
        } else if (max < 100 || max > 1000) {
            error = "Maximum price must be between 100 and 1000.";
        } else if (min > max) {
            error = "Minimum price cannot be greater than maximum price.";
        }

        if (error) {
            $errorMsg.text(error).show();
            e.preventDefault(); // stop submission
        } else {
            $errorMsg.hide(); // hide error if all good
        }
    });
    $('.delete-form').on('submit', function (e) {
        const productID = $(this).find('button').data('productid');
        const sizeID = $(this).find('button').data('sizeid');

        const confirmDelete = confirm(`Are you sure you want to delete this product?\nProduct ID: ${productID}\nSize ID: ${sizeID}`);

        if (!confirmDelete) {
            e.preventDefault(); // Cancel submission
        }
    });

    document.querySelectorAll('.status-toggle-btn').forEach(button => {
        button.addEventListener('click', async () => {
            
            // 1. fetch  element form html tag : 
            const productID = button.dataset.productid;
            const sizeID = button.dataset.sizeid;
            const currentStatus = button.dataset.status;
            const newStatus = currentStatus === 'onsales' ? 'notonsales' : 'onsales';


            // 2. use try catch to improve the process structure ; 
            try {
                // 3. sending the data to target file ;
                const response = await fetch('/controller/api/statusSwtich.php', {
                    // 3.1 mention the request method ；
                    method: 'POST',
                    // 3.2 mention how will the data convert into what type string or json or somelse in here is json 
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    // 3.3 modify the request body , what we want to send ; 
                    body: JSON.stringify({
                        productID: productID,
                        sizeID: sizeID,
                        status: newStatus
                    })
                });

                // 4. get http res body
                const result = await response.json();

                // repsonse.ok to ensure the request is send successfully 
                // response.success to ensure the backend is correctly processing the data 
                if (!response.ok || !result.success) {
                    throw new Error(result.error || 'Unknown error');
                }

                // update status 
                button.dataset.status = newStatus;

                if (newStatus === 'onsales') {
                    button.classList.remove('notonsales');
                    button.classList.add('onsales');
                    button.innerHTML = `<i class="fas fa-toggle-on"></i> On Sale`;
                } else {
                    button.classList.remove('onsales');
                    button.classList.add('notonsales');
                    button.innerHTML = `<i class="fas fa-toggle-off"></i> Not On Sale`;
                }
                // error handle 
            } catch (error) {
                console.error('Failed to update status:', error);
                alert('Failed to update status. Please try again.');
            }
        });
    });




});