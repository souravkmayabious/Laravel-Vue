<template>
    <div id="app">
      <Header /> 
      <Navbar /> 
      <router-view></router-view> 
      <Footer />
    </div>
</template>
  
<script>  
import Navbar from './components/common/Navbar.vue';
import Header from './components/common/Header.vue';
import Footer from './components/common/Footer.vue';

  export default {
    name: 'App',
      components: {
      Navbar,
      Header,
      Footer,
    },
  };
</script>
  
<style scoped>
#app {
  text-align: center;
  font-family: 'Arial', sans-serif;
}
</style>