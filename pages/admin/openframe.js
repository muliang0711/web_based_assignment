function loadIframe(url) {
    // 获取容器
    var container = document.getElementById("container");

    // 确保容器存在
    if (!container) {
        console.error("Error: #container 不存在！");
        return;
    }

    // 清空容器，避免多个 iframe 叠加
    container.innerHTML = "";

    // 创建 iframe
    var iframe = document.createElement("iframe");
    iframe.src = url;

    // 這個本來是用來解決連上CSS的問題，但現在問題解決了就不需要了。可以先留著，in case 以後不懂爲什麽又出現奇怪的問題會需要
    // if (stylesheetAbsolutePath) {
    //     iframe.onload = function() {
    //         const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
    //         // const link = iframeDoc.querySelector("link[rel='stylesheet']");
    //         // if (link) {
    //         //     link.href = stylesheetAbsolutePath;
    //         // } else {
    //         //     const newLink = iframeDoc.createElement("link");
    //         //     newLink.rel = "stylesheet";
    //         //     newLink.href = stylesheetAbsolutePath;
    //         //     iframeDoc.head.appendChild(newLink);
    //         // }
    //         let cssString = "";
    //         fetch(stylesheetAbsolutePath) // Fetch entire CSS text from the specified CSS file
    //             .then(response => {
    //                 // response.text();

    //                 console.log('Response status:', response.status);
    //                 console.log('Response headers:', response.headers);
    //                 return response.text();
    //             })
    //             .then(cssText => {
    //                 cssString = cssText; // Store fetched CSS in a string variable
    //                 console.log(cssString); // for debugging purposes

    //                 // Add fetched CSS text into <style>
    //                 const styleTag = iframeDoc.querySelector("style"); // Check if <style> exists 
    //                 // if <style> exists                
    //                 if (styleTag) { 
    //                     styleTag.textContent = cssString + styleTag.textContent; // Prepend fetched CSS text to <style>, so that existing internal CSS still has higher precedence.
    //                 } 
    //                 // if <style> does not exist
    //                 else { 
    //                     const newStyleTag = iframeDoc.createElement("style"); // create <style>
    //                     newStyleTag.textContent = cssString; // insert fetched CSS text into <style>
    //                     iframeDoc.head.appendChild(newStyleTag); // append <style> (now filled with CSS) to <head>
    //                 }
    //             })
    //             .catch(error => console.error("Error loading CSS:", error));
                
            
    //     };
    // }

    iframe.width = "100%";
    iframe.height = "100%";
    iframe.style.border = "none";

    // Hide scrollbar in iframe
    // iframe.setAttribute("scrolling", "no");

    // 插入到容器中
    container.appendChild(iframe);
}
