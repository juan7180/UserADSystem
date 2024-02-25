<?php
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authentication required.';
    exit;
} else {
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];

    $validUser = 'user'; // change username and password to yours
    $validPassword = 'password';

    if ($username !== $validUser || $password !== $validPassword) {
        header('HTTP/1.0 401 Unauthorized');
        echo 'Invalid credentials.';
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (in_array(strtolower($fileExtension), $allowedExtensions)) {
        $uploadDirectory = __DIR__;
        
        $filename = uniqid() . '.' . $fileExtension;
        
        $uploadPath = $uploadDirectory . DIRECTORY_SEPARATOR . $filename;
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            echo "File uploaded successfully: $filename";
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type. Only images (jpg, jpeg, png, gif) and videos (mp4, avi, mov) are allowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            border-bottom: 2px solid #4caf50;
        }

        center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        h2 {
            color: #333;
        }

        p {
            color: #666;
            margin-bottom: 10px;
        }

        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="file"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        button {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        button:hover {
            background-color: #45a049;
        }

        hr {
            border: 1px solid #ddd;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap">
</head>
<body>
    <header>
        <h3>Upload An Ad</h3>
    </header>
    <center>
        <h2>Upload a File</h2>
        <p>Ad has to be 728 x 90.</p>
        <p>It has to be an image or video (jpg, jpeg, png, gif, mp4, avi, mov).</p>
        <p>No porn, no cheese pizza, no gore.</p>   <!-- these rules can be changed -->
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="file" accept="image/*,video/*">
            <button type="submit">Upload</button>
        </form>
        <hr>
        <p>All Ads Preview (*refresh to change*)</p>
        <img src="https://www.yourdomainhere.com/userads/" alt="Ad" /> <!-- change yourdomainhere.com to your domain and change the folder where its in -->
    </center>
</body>
</html>
