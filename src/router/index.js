import { createRouter, createWebHistory } from 'vue-router'
import Vote from '../views/Vote.vue'
import Results from '../views/Results.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'vote',
      component: Vote
    },
    {
      path: '/results',
      name: 'results',
      component: Results
    }
  ]
})

export default router