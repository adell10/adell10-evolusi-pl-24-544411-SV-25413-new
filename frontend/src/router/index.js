import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import TugasList from '../views/TugasList.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', name: 'home', component: Home },
    { path: '/tugas', name: 'tugas', component: TugasList },
  ],
})

export default router