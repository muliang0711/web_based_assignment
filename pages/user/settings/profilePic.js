$(() => {
    
    // Crop profile pic before uploading
    $('#profilePicForm input[type=file]').on('change', e => {
        // Change the src attribute of the <imgPreview> in the confirmation box
        const f = e.target.files[0];
        const $errorMsg = $('.form-group.profile-pic .errorMsg');
        console.log($errorMsg);

        // Clear old error message
        $errorMsg.html('');
        
        // Validate uploaded photo
        let isValid = false;
        // 1. Validate file type
        if (!f.type.startsWith('image/')) {
            $errorMsg.html("Only image files are allowed!");
            return;
        }

        // 2. Validate file size 
        const maxSize = 2 * 1024 * 1024; // 2MB
        if (f.size > maxSize) {
            $errorMsg.html("File size must be under 2MB!");
            return;
        }
        
        const img = new Image();
        img.src = URL.createObjectURL(f);
        img.onload = function () {
            // NOTE: no need validate dimension la. PHP will auto-resize image also. Big big dimension also nvm one.
            // 3. Validate image dimension
            // const maxWidth = 1920, maxHeight = 1080;
            // if (img.width > maxWidth || img.height > maxHeight) {
            //     $errorMsg.html(`Image dimensions must be at most ${maxWidth}x${maxHeight}px!`);
            //     return;
            // }

            // At this point, image is valid and loaded

            // Show image in preview
            const imgPreview = $(".crop-profile-main img")[0]; // need the `[0]` because $('...') returns a jQuery object, which is essentially an array of HTMLElements. We want the first element of this jQuery object, which is gonna be the <imgPreview> HTMLElement object.
            imgPreview.src = img.src;
    
            // Note: this is a global function defined in app.js
            openPopup(e.target);
        }


            
            
            // // Activate confirmation box
            // const $cropProfileContainer = $(".crop-profile-container");
            // $cropProfileContainer.addClass("show");
    
            // // if click cancel
            // $cropProfileContainer.find("#cancelBtn").on('click', e => {
            //     $cropProfileContainer.removeClass("show");
            // });
    });

});