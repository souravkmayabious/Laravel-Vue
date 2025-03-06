<template>
    <nav class="sticky-top">
      <ul>
        <li><router-link to="/">Home</router-link></li>
        <li><router-link to="/register">Register</router-link></li>
        <li><router-link to="/dashboard">Dashboard</router-link></li>
      </ul>
    </nav>
  </template>
  
  <script>
  export default {
    name: 'Navbar',
  };
  </script>
  
  <style scoped>
  nav {
    background-color: #333;
    padding: 5px;
  }
  
  ul {
    list-style-type: none;
    display: flex;
    gap: 30px;
  }
  
  li {
    display: inline;
  }
  
  a {
    color: white;
    text-decoration: none;
  }
  </style>
  