<template>
    <div class="container mt-5">
      <h2 class="text-center mb-4">Dashboard</h2>
  
      <!-- Display user information -->
      <div class="card p-4 shadow-sm">
        <h3 class="mb-3">Welcome, {{ user.name }}</h3>
        <p>Email: {{ user.email }}</p>
  
        <!-- Logout Button -->
        <button @click="logout" class="btn btn-danger mt-3 w-100">
          Logout
        </button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        user: {},
      };
    },
    created() {
      this.fetchUser();
    },
    methods: {
      // Fetch the authenticated user's details
      async fetchUser() {
        try {
          const response = await axios.get("/api/user", {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            },
          });
          this.user = response.data;
        } catch (error) {
          // If the user is not authenticated, redirect to login page
          this.$router.push({ name: "login" });
        }
      },
  
      // Logout and remove the token from localStorage
      async logout() {
        try {
          await axios.post(
            "/api/logout",
            null,
            {
              headers: {
                Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
              },
            }
          );
          localStorage.removeItem("auth_token");
          this.$router.push({ name: "login" });
        } catch (error) {
          console.error("Error during logout", error);
          alert("Something went wrong during logout. Please try again.");
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .container {
    max-width: 500px;
  }
  
  .card {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  h3 {
    color: #333;
  }
  
  button {
    font-size: 16px;
  }
  </style>
  