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
    iframe.width = "100%";
    iframe.height = "100%";
    iframe.style.border = "none";

    // 插入到容器中
    container.appendChild(iframe);
}
