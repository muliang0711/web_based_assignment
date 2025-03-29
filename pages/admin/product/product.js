$(document).ready(function () {
    $('.delete-form').on('submit', function (e) {
        const productID = $(this).find('button').data('productid');
        const sizeID = $(this).find('button').data('sizeid');

        const confirmDelete = confirm(`Are you sure you want to delete this product?\nProduct ID: ${productID}\nSize ID: ${sizeID}`);

        if (!confirmDelete) {
            e.preventDefault(); // Cancel submission
        }
    });

    const button = document.getElementById('statusToggleBtn');

    document.querySelectorAll('.status-toggle-btn').forEach(button => {
        button.addEventListener('click', async () => {
            const productID = button.dataset.productid;
            const sizeID = button.dataset.sizeid;

            const currentStatus = button.dataset.status;

            const newStatus = currentStatus === 'onsales' ? 'notonsales' : 'onsales';


            try {
                const response = await fetch('/controller/apiStatusSwtich.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        productID: productID,
                        sizeID: sizeID,
                        status: newStatus
                    })
                });

                const result = await response.json(); 

                if (!response.ok || !result.success) {
                    throw new Error(result.error || 'Unknown error');
                }

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

            } catch (error) {
                console.error('Failed to update status:', error);
                alert('Failed to update status. Please try again.');
            }
        });
    });


    const $minInput = $('#minPrice');
    const $maxInput = $('#maxPrice');
    const $form = $('.filter-form');

    // 1. Set default min price if empty or less than 100
    $minInput.on('blur', function () {
        let val = parseInt($(this).val());
        if (isNaN(val) || val < 100) {
            $(this).val(100);
        }
    });

    // 2. Set default max price if less than 100
    $maxInput.on('blur', function () {
        let val = parseInt($(this).val());
        if (isNaN(val) || val < 100) {
            $(this).val(100);
        }
    });

    // 3. Show formatted label below inputs
    function updateFormattedPrice($input, target) {
        let val = parseFloat($input.val());
        if (!isNaN(val)) {
            $(target).text('RM ' + val.toFixed(2));
        } else {
            $(target).text('');
        }
    }

    $minInput.on('input', function () {
        updateFormattedPrice($minInput, '#minPriceFormatted');
    });

    $maxInput.on('input', function () {
        updateFormattedPrice($maxInput, '#maxPriceFormatted');
    });

    // 4. Validate min ≤ max before submit
    $form.on('submit', function (e) {
        let min = parseFloat($minInput.val());
        let max = parseFloat($maxInput.val());

        if (min > max) {
            alert("Minimum price cannot be greater than maximum price.");
            e.preventDefault();
        }

    });
    
});