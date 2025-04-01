<?php
require_once "../../../_base.php";
include "../main.php";
require_once "../../../db_connection.php";

$stylesheetArray = ['../../../css/adminProductAnlysis.css'];
link_stylesheet($stylesheetArray);
?>

<div class="main-content xx">
  <div class="contanier">

    <div class="upPart">

      <!-- Top Bar -->
      <div class="top-bar">
        <h2>📊 Generate Admin Report</h2>
      </div>

      <!-- Filter Bar -->
      <div class="filter-bar">
        <form action="" class="filter-form">
          <label for="reportType">Report Type:</label>
          <select id="reportType" required>
            <option value="">Select Report Type</option>
            <option value="Sales">Sales</option>
          </select>

          <label for="fromDate">From:</label>
          <input type="date" id="fromDate" required>

          <label for="toDate">To:</label>
          <input type="date" id="toDate" required>

          <button class="sub-button" id="generateBtn" type="submit">Generate report</button>
        </form>
      </div>

      <!-- Action Buttons -->
      <div class="decision-bar">
        <button type="button" onclick="clearFilters()">Clear Filters</button>
        <button type="button">Save Template</button>
      </div>

    </div>

    <div class="downpart">

      <!-- Preview Area -->
      <div class="preview-container">
        <div class="preview">
          <h3>📄 Chart Report Preview</h3>
          <p>Your report will appear here after generation...</p>
        </div>
      </div>

      <!-- Export / Download Buttons -->
      <div class="decision-bar" style="margin-top: 20px;">
        <button type="button" onclick="exportChartToPDF()">Export as PDF</button>
        <button type="button" onclick="exportDataToExcel(window.lastReportData, window.lastReportType)">Export as Excel</button>
        <button type="button" onclick="exportDataToCSV(window.lastReportData, window.lastReportType)">Export as CSV</button>
      </div>

    </div>

  </div>
</div>

<?php include "../../../admin_foot.php"; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", () => {

    // 1. get frontend data ; 
    const form = document.querySelector('.filter-form');
    const reportTypeInput = document.getElementById('reportType');
    const fromInput = document.getElementById('fromDate');
    const toInput = document.getElementById('toDate');

    // 2. handle form submittion 
    form.addEventListener('submit', async (e) => {

      // 2.1 stop the form submittion 
      e.preventDefault();

      // 3. fect data (value)
      const reportType = reportTypeInput.value;
      const from = fromInput.value;
      const to = toInput.value;

      // 4. validation 
      if (!reportType) {
        alert("Please select a report type.");
        return;
      }
      if (!from || !to) {
        alert("Please select both From and To dates.");
        return;
      }

      // 5. execute function : 
      try {
        const data = await fetchReportData(reportType, from, to);
        renderChartPreview(reportType, data);
      } catch (error) {
        showChartMessage(`❌ ${error.message}`);
      }
    });
  });

  async function fetchReportData(reportType, from, to) {

    // 1. target proccess file path : 
    const url = `/controller/apiReport.php?reportType=${encodeURIComponent(reportType)}&from=${from}&end=${to}`;

    // 2. modify the resopnse 
    const res = await fetch(url);

    // 2.1 turn it into json 
    const json = await res.json();

    // 3. validation
    if (!res.ok || !json.success) {
      throw new Error(json.error || 'Server Error');
    }

    return json.data;
  }

  function renderChartPreview(reportType, data) {

    // 1. select html tag as a area 
    const chartBox = document.querySelector(".preview");
    let html = `<h3>📊 ${reportType} Report Preview</h3>`;

    // 2. validation 
    if ((reportType === 'Sales') && data.sales && data.sales.length > 0) {
      // 3. make a canvas tag to make draw diagram 
      // #all this phase are running in a fake html 
      html += `<canvas id="salesChart" style="max-height: 300px;"></canvas>`;
    } else if (reportType === 'Sales') {
      // 3.1 error handle 
      html += `<p>No Sales data available for the selected date range.</p>`;
    }

    // 4. put the content int our html 
    chartBox.innerHTML = html;

    // 5. validation ensure we got data to draw 
    if ((reportType === 'Sales') && data.sales && data.sales.length > 0) {

      // 6. 
      const ctxSales = document.getElementById('salesChart').getContext('2d');

      // labels as X 
      const labels = data.sales.map(item => item.productName);

      // values as Y 
      const values = data.sales.map(item => item.total_sold);

      // if diagram existing destory and redraw 
      if (window.salesChartInstance) window.salesChartInstance.destroy();

      // 7. use chart to draw diagram 
      window.salesChartInstance = new Chart(ctxSales, {

        // mention the diagram type
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Units Sold',
            data: values,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderRadius: 6
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                precision: 0
              }
            }
          }
        }
      });
    }

    // save global data for csv and excel used
    window.lastReportData = data;
    window.lastReportType = reportType;

  }

  function showChartMessage(message) {
    const chartBox = document.querySelector(".preview");
    chartBox.innerHTML = `<h3>📊 Report Preview</h3><p>${message}</p>`;
  }

  function clearFilters() {

    // 1. directly get and overwrite html value 
    document.getElementById('reportType').value = '';
    document.getElementById('fromDate').value = '';
    document.getElementById('toDate').value = '';
    const chartBox = document.querySelector(".preview");
    chartBox.innerHTML = `<h3>📄 Chart Report Preview</h3><p>Your report will appear here after generation...</p>`;
  }

  async function exportChartToPDF() {

    // 1. select previewq area 
    const chartContainer = document.querySelector('.preview');

    // 2. screen shot as a picture ; 
    // html2canvas allowed us can pick a html area and take screenshot and save ;
    const canvas = await html2canvas(chartContainer);

    // 3. turn the image into base64 format png
    const imgData = canvas.toDataURL('image/png');

    // 4. jsPDF is  a thiry part library aloowed us make a pdf in browswer 
    // 4.1 use window.jspdf to get tools inside the jsPDF 
    const {
      jsPDF
    } = window.jspdf;

    // 5. make a empty pdfpage modify as A4 size 
    const pdf = new jsPDF();

    // 6. caclulate the wiodth and height 
    const imgWidth = 180;
    const imgHeight = (canvas.height * imgWidth) / canvas.width;

    // 7. insert the image into pdf 
    pdf.addImage(imgData, 'PNG', 15, 20, imgWidth, imgHeight);
    // 8. save 
    pdf.save("report.pdf");
  }

  function exportDataToCSV(data, reportType) {
    let rows = [];
    let headers = [];

    if (reportType === "Sales") {
      headers = ["Product ID", "Product Name", "Total Sold", "Total Revenue"];
      data.sales.forEach(item => {
        rows.push([item.productID, item.productName, item.total_sold, item.total_revenue]);
      });
    }

    let csv = [headers, ...rows].map(row => row.join(",")).join("\n");

    const blob = new Blob([csv], {
      type: "text/csv"
    });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "report.csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

  function exportDataToExcel(data, reportType) {
    let rows = [];
    let headers = [];

    if (reportType === "Sales" || reportType === "All") {
      headers = ["Product ID", "Product Name", "Total Sold", "Total Revenue"];
      data.sales.forEach(item => {
        rows.push([item.productID, item.productName, item.total_sold, item.total_revenue]);
      });
    }

    if (reportType === "Inventory" || reportType === "All") {
      headers = ["Product ID", "Product Name", "Inventory"];
      data.inventory.forEach(item => {
        rows.push([item.productID, item.productName, item.inventory]);
      });
    }

    let table = [headers, ...rows];
    let content = table.map(row => row.join("\t")).join("\n");
    let blob = new Blob([content], {
      type: "application/vnd.ms-excel"
    });

    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "report.xls";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

  function sendToemail(){
    
  }
</script>