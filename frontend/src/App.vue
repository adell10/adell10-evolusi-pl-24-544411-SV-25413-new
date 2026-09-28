<script setup>
</script>

<template>
  <nav class="tabs" aria-label="Navigasi utama">
    <router-link to="/">Beranda</router-link>
    <router-link to="/tugas">Daftar Tugas</router-link>
  </nav>
  <div class="sheet">
    <router-view />
  </div>
</template>