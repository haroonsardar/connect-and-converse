<?php include_once(__DIR__ . '/../config/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect & Converse | University Hub</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <style>
        /* Sticky Footer Core Logic */
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        /* Ye class har main content container par honi chahiye taake footer niche rahe */
        .flex-grow-1 {
            flex: 1 0 auto;
        }

        /* UI Enhancements */
        .navbar { 
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); 
            box-shadow: 0 4px 6px rgba(0,0,0,.1); 
        }
        .nav-link, .navbar-brand { color: white !important; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .btn-primary { background-color: #4e73df; border: none; border-radius: 50px; }
        .btn-primary:hover { background-color: #224abe; }
        
        /* Custom scrollbar for better professional look */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #4e73df; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #224abe; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>