<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 20px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      color: #333;
    }

    p {
      color: #666;
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007BFF;
      color: #fff;
      text-decoration: none;
      border-radius: 3px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>{{ __('Hi,') }} {{ $data['name'] ?? '' }}!</h1>
    <p>{{ __('We received a request to log in to your account on') }} {{ env('APP_NAME') }}.</p>

    <p><strong>{{ __('Your OTP Code:') }}</strong></p>
    <h2 style="color: #007BFF;">{{ $data['code'] ?? '' }}</h2>

    <p>{{ __('Please use this OTP to confirm your login. This code is valid for a limited time.') }}</p>
    <p>{{ __('If you did not request this login, please secure your account immediately.') }}</p>

    <p>{{ __('Best Regards,') }}<br>{{ env('APP_NAME') }}</p>
  </div>
</body>
</html>
