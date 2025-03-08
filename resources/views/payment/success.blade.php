<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
</head>
<body>
    <h2>🎉 Payment Successful! 🎉</h2>
    <p>Thank you for your payment.</p>
    <p><strong>Transaction ID:</strong> {{ $paymentId }}</p>
    <p><strong>Amount Paid:</strong> ₹{{ number_format($amount, 2) }}</p>
    <a href="{{ url('/') }}">Go to Home</a>
</body>
</html>
