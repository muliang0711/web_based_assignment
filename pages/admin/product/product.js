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


});