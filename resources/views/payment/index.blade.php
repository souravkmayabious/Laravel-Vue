<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <h2>Pay ₹100 with Razorpay</h2>
    <button id="pay-btn">Pay Now</button>

    <script>
        document.getElementById('pay-btn').addEventListener('click', function () {
            fetch("{{ route('payment.create') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                var options = {
                    "key": "{{ config('services.razorpay.key') }}",
                    "amount": data.amount,
                    "currency": "INR",
                    "name": "Laravel Razorpay",
                    "description": "Test Transaction",
                    "prefill":{
                        "email":"sk@gmail.com",
                        "contact":"9874563210",
                    },                    
                    "order_id": data.order_id,
                    "handler": function (response) {
                        fetch("{{ route('payment.success') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_signature: response.razorpay_signature
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                                if (data.status === "success") {
                                    window.location.href = "{{ route('payment.success.page') }}?payment_id=" + data.payment_id + "&amount=" + data.amount;
                                } else {
                                    alert("Payment verification failed!");
                                }
                            })
                        .catch(error => alert("Payment verification failed!"));
                    }
                };
                var rzp = new Razorpay(options);
                rzp.open();
            })
            .catch(error => alert("Order creation failed!"));
        });
    </script>
</body>
</html>
