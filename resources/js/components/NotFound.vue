<!-- resources/js/components/NotFound.vue -->
<template>
    <div class="not-found">
      <h1>404 - Page Not Found</h1>
      <p>The page you're looking for doesn't exist.</p>
    </div>
  </template>
  
  <script>
  export default {
    name: 'NotFound',
  };
  </script>
  
  <style scoped>
  .not-found {
    text-align: center;
    margin-top: 50px;
  }
  
  .not-found h1 {
    color: #e74c3c;
  }
  
  .not-found p {
    font-size: 18px;
    color: #2c3e50;
  }
  </style>
  