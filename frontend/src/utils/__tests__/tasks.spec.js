import { describe, it, expect } from 'vitest'
import { summarizeTasks, statusLabel } from '../tasks.js'

describe('summarizeTasks', () => {
  it('returns zeroed summary for empty input', () => {
    expect(summarizeTasks([])).toEqual({ total: 0, done: 0, pending: 0 })
  })

  it('counts done and pending tasks correctly', () => {
    const tasks = [{ is_done: true }, { is_done: false }, { is_done: true }]
    expect(summarizeTasks(tasks)).toEqual({ total: 3, done: 2, pending: 1 })
  })

  it('returns zeroed summary when given non-array input', () => {
    expect(summarizeTasks(null)).toEqual({ total: 0, done: 0, pending: 0 })
  })
})

describe('statusLabel', () => {
  it('returns "Selesai" when task is done', () => {
    expect(statusLabel(true)).toBe('Selesai')
  })

  it('returns "Belum selesai" when task is not done', () => {
    expect(statusLabel(false)).toBe('Belum selesai')
  })
})