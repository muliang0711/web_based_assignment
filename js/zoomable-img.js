// ==== HOW TO USE ====
// 1. Link your page to this JS file (obviously!): /js/zoomable-img.js 
//
// 2. Link your page to the CSS file: /css/zoomable-img.css
//
// 3. Add this HTML in your page.
// <!-- Modal Zoom Viewer -->
// <div id="imageModal" class="modal">
//   <span class="close">&times;</span>
//   <img class="modal-content" id="zoomedImage">
// </div>
//
// 4. Apply the class `zoomable-img` on the image you want to make zoomable.
//
// Done! :)

$(document).ready(function () {
  // Zoom modal logic
  $(".zoomable-img").on("click", function () {
    $("#zoomedImage").attr("src", $(this).attr("src"));
    $("#imageModal").fadeIn();
  });

  $(".close").on("click", function () {
    $("#imageModal").fadeOut();
  });

  $("#imageModal").on("click", function (e) {
    if (e.target === this) {
      $(this).fadeOut();
    }
  });
});