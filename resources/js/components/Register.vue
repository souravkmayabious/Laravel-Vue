<template>
    <div class="container mt-5">
      <h2 class="text-center mb-4">Register</h2>
      <form @submit.prevent="register" class="col-md-6 mx-auto">
        <!-- Name Field -->
        <div class="mb-3">
          <input
            v-model="name"
            type="text"
            class="form-control"
            placeholder="Full Name"
            required
          />
        </div>
  
        <!-- Email Field -->
        <div class="mb-3">
          <input
            v-model="email"
            type="email"
            class="form-control"
            placeholder="Email Address"
            required
          />
        </div>
  
        <!-- Password Field -->
        <div class="mb-3">
          <input
            v-model="password"
            type="password"
            class="form-control"
            placeholder="Password"
            required
          />
        </div>
  
        <!-- Confirm Password Field -->
        <div class="mb-3">
          <input
            v-model="password_confirmation"
            type="password"
            class="form-control"
            placeholder="Confirm Password"
            required
          />
        </div>
  
        <!-- Error Message Display -->
        <div v-if="errorMessage" class="alert alert-danger">
          {{ errorMessage }}
        </div>
  
        <!-- Register Button -->
        <button type="submit" class="btn btn-primary w-100">
          Register
        </button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        errorMessage: "", // Holds error messages for failed registration
      };
    },
    methods: {
      async register() {
        // Clear previous error message
        this.errorMessage = "";
  
        // Basic frontend validation for password confirmation
        if (this.password !== this.password_confirmation) {
          this.errorMessage = "Passwords do not match!";
          return;
        }
  
        try {
          // Send the CSRF token request
          // await axios.get("/sanctum/csrf-cookie");
  
          // Make the API request to register the user
          const response = await axios.post("/api/register", {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
          });
  
          // On success, store the token and redirect to the dashboard
          localStorage.setItem("auth_token", response.data.token);
          this.$router.push({ name: "dashboard" });
        } catch (error) {
          // Check if the error has a response (like validation error or server issue)
          if (error.response) {
            // Show backend validation error messages
            this.errorMessage = error.response.data.message || "Registration failed";
          } else {
            // General error handling
            this.errorMessage = "An error occurred. Please try again.";
          }
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .container {
    max-width: 500px;
    padding: 20px;
  }
  
  form {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  button {
    font-size: 16px;
  }
  
  .alert {
    font-size: 14px;
    margin-top: 10px;
  }
  </style>
  