    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #4CAF50;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #dddddd;
        }
        .email-header h1 {
            margin: 0;
        }
        .email-body {
            padding: 20px;
        }
        .email-body p {
            line-height: 1.6;
        }
        .verification-code {
            display: block;
            width: fit-content;
            margin: 20px auto;
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
            background-color: #f4f4f4;
            padding: 10px 20px;
            border: 2px dashed #4CAF50;
            border-radius: 5px;
            text-align: center;
        }
        .email-footer {
            text-align: center;
            padding: 10px;
            background-color: #f4f4f4;
            color: #777777;
            border-top: 1px solid #dddddd;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>Email Verification</h1>
    </div>
    <div class="email-body">
        <p>Hello,</p>
        <p>Thank you for registering with us. Please use the following verification code to verify your email address:</p>
        <span class="verification-code">{{ $code }}</span>
        <p>This code is valid for the next 10 minutes. If you did not request this code, please ignore this email.</p>
        <p>Best regards,<br> ARTER Company </p>
    </div>
    <div class="email-footer">
        <p>&copy; {{ date('Y') }} ARTER company. All rights reserved.</p>
    </div>
</div>
</body>
</html>
