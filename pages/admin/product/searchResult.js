$(document).ready(function() {
    // Get search term from URL
    const params = new URLSearchParams(window.location.search);
    const searchQuery = params.get("search");

    // Highlight search term
    function highlightSearchTerm(term) {
        if (!term) return;

        $(".searchtext").each(function() {
            const regex = new RegExp(`(${term})`, "gi");
            const originalHtml = $(this).html();
            const newHtml = originalHtml.replace(regex, "<mark>$1</mark>");
            $(this).html(newHtml);
        });
    }

    highlightSearchTerm(searchQuery);

    // Toggle status (on sale / not on sale)
    $(".status-toggle-btn").on("click", function() {
        const $button = $(this);
        const productID = $button.data("productid");
        const sizeID = $button.data("sizeid");
        const currentStatus = $button.data("status");

        const newStatus = currentStatus === "onsales" ? "notonsales" : "onsales";

        $.ajax({
            url: "/controller/apiStatusSwtich.php",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                productID: productID,
                sizeID: sizeID,
                status: newStatus
            }),
            success: function(response) {
                if (!response.success) {
                    alert(response.error || "Unknown error occurred.");
                    return;
                }

                // Update button state and content
                $button.data("status", newStatus);
                $button
                    .removeClass("onsales notonsales")
                    .addClass(newStatus);

                if (newStatus === "onsales") {
                    $button.html(`<i class="fas fa-toggle-on"></i> On Sale`);
                } else {
                    $button.html(`<i class="fas fa-toggle-off"></i> Not On Sale`);
                }
            },
            error: function(err) {
                console.error("Failed to update status:", err);
                alert("Failed to update status. Please try again.");
            }
        });
    });
});
