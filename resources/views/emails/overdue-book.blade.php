<!DOCTYPE html>
<html>

<head>
    <title>Overdue Book Notification</title>
    <style>
        /* Define custom styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h1 {
            color: #333333;
        }

        h4 {
            color: #666666;
        }

        p {
            color: #666666;
            line-height: 1.6;
        }

        .notification-box {
            border: 2px solid #ccc;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .logo {
            max-width: 150px;
            /* Adjust the maximum width of the logo */
            margin-bottom: 20px;
            /* Add some space below the logo */
        }
    </style>
</head>

<body>
    <div class="notification-box">
        <img src="{{ asset('logo-1.png') }}" alt="Logo" class="logo">
        <h1>Overdue Book Notification</h1>
        <h4>Dear {{ $studentName }},</h4>
        <p>The book "{{ $bookTitle }}" is overdue.</p>
        <p>Please return it to the library as soon as possible. Failure to return the book within the specified period
            may result in a fine.</p>
        <p>Thank you for your attention.</p>
        {{-- <a href="{{ url('/') }}" class="button">View Book</a> --}}
    </div>
</body>

</html>
