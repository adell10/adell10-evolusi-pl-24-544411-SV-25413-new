<script setup>
import { ref, onMounted, computed } from 'vue'
import { summarizeTasks, statusLabel } from '../utils/tasks.js'

const apiUrl = import.meta.env.VITE_API_URL

const tasks = ref([])
const loading = ref(true)
const error = ref(null)

const summary = computed(() => summarizeTasks(tasks.value))
const percent = computed(() =>
  summary.value.total === 0
    ? 0
    : Math.round((summary.value.done / summary.value.total) * 100),
)
// Alamat halaman tambah tugas di Laravel, diturunkan dari VITE_API_URL (tanpa hardcode)
const createUrl = computed(() =>
  apiUrl ? `${apiUrl.replace(/\/api\/?$/, '')}/tasks/create` : '#',
)

onMounted(async () => {
  try {
    const response = await fetch(`${apiUrl}/tugas`)
    if (!response.ok) {
      throw new Error(`Request gagal dengan status ${response.status}`)
    }
    tasks.value = await response.json()
  } catch (e) {
    error.value = e.message
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <main>
    <h1>Daftar tugas</h1>

    <p v-if="loading" class="muted">Memuat tugas dari API...</p>

    <div v-else-if="error" class="alert" role="alert">
      <p><strong>Tugas tidak bisa dimuat.</strong> {{ error }}.</p>
    </div>

    <template v-else>
      <section class="progress" aria-label="Progres tugas">
        <p class="progress-text">
          <strong>{{ summary.done }}</strong> dari {{ summary.total }} tugas
          selesai
        </p>
        <div
          class="progress-track"
          role="progressbar"
          :aria-valuenow="percent"
          aria-valuemin="0"
          aria-valuemax="100"
        >
          <div
            class="progress-fill"
            :class="{ empty: percent === 0 }"
            :style="{ width: percent + '%' }"
          ></div>
        </div>
        <p class="muted">{{ summary.pending }} tugas masih menunggu dikerjakan</p>
      </section>

      <p v-if="tasks.length === 0" class="empty">
        Belum ada tugas yang tercatat.
        <a :href="createUrl">Tambah tugas pertama</a> di aplikasi Laravel, lalu
        muat ulang halaman ini.
      </p>

      <ul v-else class="task-list">
        <li
          v-for="task in tasks"
          :key="task.id"
          :class="{ done: task.is_done }"
        >
          <span class="check" aria-hidden="true"></span>
          <span class="title"><span class="title-text">{{ task.title }}</span></span>
          <span class="state">{{ statusLabel(task.is_done) }}</span>
        </li>
      </ul>

    </template>
  </main>
</template>

<style scoped>
.progress {
  margin-bottom: var(--line);
}

.progress-text {
  font-family: 'Kalam', cursive;
  font-size: 24px;
  color: var(--ink);
  margin-bottom: 0;
}

.progress-text strong {
  font-size: 32px;
}

.progress-track {
  height: 14px;
  margin: 9px 0;
  max-width: 420px;
  background: #e3e9f4;
  border: 2px solid var(--ink);
  border-radius: 999px;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  background: var(--highlight);
  border-right: 2px solid var(--ink);
  transform-origin: left;
  animation: fill 0.9s ease-out;
}

.progress-fill.empty {
  border-right: none;
}

@keyframes fill {
  from {
    transform: scaleX(0);
  }
}

.task-list {
  list-style: none;
  margin: 0 0 var(--line);
  padding: 0;
}

.task-list li {
  display: flex;
  align-items: center;
  gap: 14px;
  min-height: var(--line);
}

.check {
  flex: none;
  position: relative;
  width: 20px;
  height: 20px;
  border: 2px solid var(--ink);
  border-radius: 50%;
}

.done .check {
  background: var(--ink);
}

.done .check::after {
  content: '';
  position: absolute;
  left: 5px;
  top: 1px;
  width: 5px;
  height: 10px;
  border: solid #fff;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

.title {
  font-size: 18px;
}

.done .title-text {
  color: var(--muted);
  -webkit-box-decoration-break: clone;
  box-decoration-break: clone;
  text-decoration: line-through;
  text-decoration-color: var(--ink);
  background: linear-gradient(transparent 55%, var(--highlight) 55%);
}

.state {
  margin-left: auto;
  padding-left: 12px;
  white-space: nowrap;
  font-size: 14px;
  color: var(--muted);
}

.done .state {
  color: var(--ink);
  font-weight: 700;
}

.alert {
  padding-left: 16px;
  border-left: 4px solid var(--margin);
}

.alert strong {
  color: var(--margin);
}

.empty {
  font-family: 'Kalam', cursive;
  font-size: 20px;
  color: var(--muted);
}

.source {
  font-size: 14px;
}

@media (max-width: 600px) {
  /* Di layar kecil status cukup ditunjukkan ikon lingkaran; teks tetap terbaca screen reader */
  .state {
    position: absolute;
    width: 1px;
    height: 1px;
    overflow: hidden;
    clip-path: inset(50%);
    white-space: nowrap;
  }
}

@media (prefers-reduced-motion: reduce) {
  .progress-fill {
    animation: none;
  }
}
</style>