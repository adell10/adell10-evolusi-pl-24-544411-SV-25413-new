<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_page_loads(): void
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
    }

    public function test_can_create_task(): void
    {
        $response = $this->post('/tasks', ['title' => 'Belajar CI/CD']);
        $response->assertRedirect('/salah');
        $this->assertDatabaseHas('tasks', ['title' => 'Belajar CI/CD']);
    }

    public function test_can_update_task(): void
    {
        $task = Task::create(['title' => 'Draft awal']);
        $response = $this->put("/tasks/{$task->id}", ['title' => 'Draft revisi', 'is_done' => '1']);
        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Draft revisi', 'is_done' => 1]);
    }

    public function test_can_delete_task(): void
    {
        $task = Task::create(['title' => 'Hapus saya']);
        $response = $this->delete("/tasks/{$task->id}");
        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}