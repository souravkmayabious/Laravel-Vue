<template>
    <div class="container mt-5">
      <h2 class="text-center mb-4">Login</h2>
      <form @submit.prevent="login" class="col-md-6 mx-auto">
        <div class="mb-3">
          <input v-model="email" type="email" class="form-control" placeholder="Email" required />
        </div>
        <div class="mb-3">
          <input v-model="password" type="password" class="form-control" placeholder="Password" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
      };
    },
    methods: {
      async login() {
        try {
        //   await axios.get('/sanctum/csrf-cookie');  // CSRF token request
          const response = await axios.post('/api/login', {
            email: this.email,
            password: this.password,
          });
  
          // On successful login, store the token and navigate to the dashboard
          localStorage.setItem('auth_token', response.data.token);
          this.$router.push({ name: 'dashboard' });
        } catch (error) {
          if (error.response) {
            alert(`Login failed: ${error.response.data.message || 'Invalid credentials'}`);
          } else if (error.request) {
            alert('Network error, please try again later.');
          } else {
            alert('An error occurred during login.');
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
  </style>
  