import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/Home.vue';
import Login from './components/Login.vue';  
import Register from './components/Register.vue';  
import Dashboard from './components/Dashboard.vue';  
import NotFound from './components/NotFound.vue';


// Check if the user is authenticated
function isAuthenticated() {
  return localStorage.getItem('auth_token') !== null;
}

const routes = [
  { path: '/', component: Home, name: 'Home' },
  { path: '/login', component: Login, name: 'login', meta: { requiresGuest: true } },
  { path: '/register', component: Register, name: 'register', meta: { requiresGuest: true } },
  { path: '/dashboard', component: Dashboard, name: 'dashboard', meta: { requiresAuth: true }  },
  { path: '/:pathMatch(.*)*', component: NotFound },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});



// Global middleware (navigation guard) to check for authentication
router.beforeEach((to, from, next) => {
  // Check for routes that require authentication
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated()) {
      next({ name: 'login' });
    } else {
      next(); 
    }
  } else if (to.matched.some(record => record.meta.requiresGuest)) {
    // Redirect to dashboard if already authenticated and trying to access login/register
    if (isAuthenticated()) {
      next({ name: 'dashboard' });
    } else {
      next(); 
    }
  } else {
    next(); 
  }
});

export default router;