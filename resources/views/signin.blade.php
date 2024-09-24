
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accomplishment Report - Sign In</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ffcc00, #ff6f20); /* Gradient background */
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff; /* White background for the form */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            width: 400px; /* Fixed width for larger screens */
            text-align: center;
            transition: transform 0.3s; /* Animation on hover */
        }
        .container:hover {
            transform: scale(1.05); /* Slightly enlarge on hover */
        }
        h1 {
            color: #ff6f20; /* Vibrant orange */
            margin-bottom: 15px;
            font-size: 28px; /* Increased font size */
            font-weight: bold; /* Bold text */
            letter-spacing: 1px; /* Spacing between letters */
            text-transform: uppercase; /* Uppercase letters */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
            text-align: left;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            border-radius: 25px; /* Rounded edges */
            background-color: #f7f9fc; /* Light blue-gray background */
            font-size: 14px;
            height: 45px; /* Consistent height */
            box-sizing: border-box;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        input:focus {
            background-color: #fff; /* White background on focus */
            border: 2px solid #ff6f20; /* Vibrant border on focus */
            outline: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Stronger shadow on focus */
        }
        button {
            background-color: #ff6f20; /* Vibrant orange */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 25px; /* Rounded button */
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            height: 45px;
            transition: background-color 0.3s, transform 0.3s; /* Smooth transition */
        }
        button:hover {
            background-color: #e65c00; /* Darker orange on hover */
            transform: translateY(-2px); /* Lift effect */
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .footer a {
            color: #ff6f20;
            text-decoration: none; /* No underline */
        }
        .footer a:hover {
            text-decoration: underline; /* Underline on hover */
        }
        @media (max-width: 480px) {
            .container {
                width: 90%; /* Responsive design */
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sign In</h1>
        <form action="/signin" method="POST">
            @csrf
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Sign In</button>
        </form>
        <div class="footer">
            Don't have an account? <a href="/signup">Sign Up</a>
        </div>
    </div>
</body>
</html>
