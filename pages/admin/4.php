<?php include '1.php'; ?>
<?php include '2.php'; ?>
<?php include '3.php';?>;

<main class="content ms-sm-auto px-md-4" style="margin-left: 250px;">
    <?php include 'search_bar.php'; ?>
    
    <div class="container mt-4">
        <!-- Page Content -->
        <h2>Dashboard</h2>
        <!-- Reusable Alert Component -->
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            Action completed successfully!
        </div>
        
        <!-- Reusable Table Component -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table Data -->
            </tbody>
        </table>
    </div>
</main>

<?php include 'footer.php'; ?>