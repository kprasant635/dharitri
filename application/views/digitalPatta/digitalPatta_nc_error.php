<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error - Something Went Wrong</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-container {
            background: #fff;
            border: 1px solid #ddd;
            padding: 40px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            max-width: 500px;
        }

        .error-code {
            font-size: 80px;
            font-weight: bold;
            color: #D50000;
            margin: 0;
        }

        .error-message {
            font-size: 20px;
            margin: 10px 0;
            color: #333;
        }

        .error-details {
            font-size: 14px;
            color: #777;
            margin-bottom: 20px;
        }

        .btn-home {
            display: inline-block;
            padding: 10px 20px;
            background: #263238;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .btn-home:hover {
            background: #37474f;
        }
    </style>
</head>
<body>
<div class="error-container">
    <p class="error-code"><?= $errorCode?></p>
    <p class="error-message"><?= $errorMsg?></p>
    <p class="error-details">

    </p>
    <a href="<?php echo base_url(); ?>index.php/DigitalPattaNC/digitalPattaView" class="btn-home">Go Back Home</a>
</div>
</body>
</html>