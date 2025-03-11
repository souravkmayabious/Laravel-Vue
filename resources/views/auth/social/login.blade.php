<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <!-- Container for the page content -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row justify-content-center">

            <!-- Logo Section -->
            <div class="col-12 text-center mb-4">
                <!-- Add your logo image here -->
                <img src="path-to-your-logo.png" alt="Sourav k" class="img-fluid" style="max-width: 150px;">
            </div>

            <!-- Social Login Buttons -->
            <div class="col-12">
                <h3 class="text-center mb-4">Login with your social account</h3>
                <div class="d-grid gap-2">
                    <!-- GitHub Login Button -->
                    <a href="{{ url('login/github') }}" class="btn btn-dark btn-lg">
                        <i class="fab fa-github"></i> Login with GitHub
                    </a>

                    <!-- Google Login Button -->
                    <a href="{{ url('login/google') }}" class="btn btn-danger btn-lg">
                        <i class="fab fa-google"></i> Login with Google
                    </a>

                    <!-- Facebook Login Button -->
                    <a href="{{ url('login/facebook') }}" class="btn btn-primary btn-lg">
                        <i class="fab fa-facebook"></i> Login with Facebook
                    </a>

                    <!-- Twitter Login Button -->
                    <a href="{{ url('login/twitter') }}" class="btn btn-info btn-lg">
                        <i class="fab fa-twitter"></i> Login with Twitter
                    </a>

                    <!-- LinkedIn Login Button -->
                    <a href="{{ url('login/linkedin') }}" class="btn btn-primary btn-lg">
                        <i class="fab fa-linkedin"></i> Login with LinkedIn
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!-- Optional: FontAwesome JS for the social icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
