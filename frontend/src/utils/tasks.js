// Logika murni (tanpa dependensi Vue/Laravel) supaya mudah diuji dengan Vitest.

export function summarizeTasks(tasks) {
  if (!Array.isArray(tasks)) {
    return { total: 0, done: 0, pending: 0 }
  }
  const done = tasks.filter((t) => Boolean(t.is_done)).length
  const total = tasks.length
  return { total, done, pending: total - done }
}

export function statusLabel(isDone) {
  return isDone ? 'Selesai' : 'Belum selesai'
}