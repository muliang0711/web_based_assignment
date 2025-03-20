<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="<?= $_COOKIE['darkMode'] ?? 'light-mode' ?>">
    <header class="bg-primary text-white p-3 d-flex justify-content-between">
        <h3>Admin Panel</h3>
        <button id="darkModeToggle" class="btn btn-light">
            <i class="fas fa-moon"></i>
        </button>
    </header>

    <script>
    // Dark Mode Toggle
    document.getElementById('darkModeToggle').addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        document.cookie = "darkMode=" + (document.body.classList.contains('dark-mode') ? 
            'dark-mode' : 'light-mode') + "; path=/";
    });
    </script>