<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚫 Nope, Not Here! 🚫</title>
    <style>
    body {
        font-family: sans-serif;
        background-color: #f4f4f4;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
        text-align: center;
    }

    .meme-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    h1 {
        color: #e74c3c;
        /* Red color for emphasis */
        margin-bottom: 10px;
    }

    p {
        color: #333;
        margin-bottom: 15px;
    }

    .login-button {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .login-button:hover {
        background-color: #2980b9;
    }

    .meme-image {
        max-width: 400px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    </style>
</head>

<body>

    <div class="meme-container">
        <h1>🚫 You Shall Not Pass! 🚫</h1>

        <p>Looks like you're trying to access something you shouldn't, buddy.</p>
        <p>Are you sure you have the <span style="font-weight: bold; color: #27ae60;">secret handshake</span> and the
            <span style="font-weight: bold; color: #f39c12;">magic password</span>?
        </p>
    </div>

    <div class="meme-container">
        <h2>🤔 Wait... Are you supposed to be here? 🤔</h2>

        <p>Maybe you took a wrong turn on the internet highway?</p>
        <p>If you think you *do* belong here, you might need to prove it...</p>
    </div>

    <div>
        <a href="../login.php" class="login-button">🔑 Login Your Credentials 🔑</a>
    </div>

    <p style="margin-top: 30px; color: #777; font-size: small;">This is a highly secure and definitely not hastily put
        together meme page.</p>

</body>

</html>