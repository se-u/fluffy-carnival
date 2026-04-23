<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();
        return view('todo.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $todo = Todo::create([
            'content' => $request->content,
            'is_done' => false,
        ]);

        // Broadcast via config broadcast
        broadcast(new \App\Events\TodoCreated($todo));

        return back();
    }

    public function toggle(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->is_done = !$todo->is_done;
        $todo->save();

        broadcast(new \App\Events\TodoUpdated($todo));

        return back();
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        broadcast(new \App\Events\TodoDeleted($id));

        return back();
    }

    public function stream()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();

        return response()->stream(function () use ($todos) {
            echo "data: " . json_encode(['type' => 'init', 'todos' => $todos]) . "\n\n";
            ob_flush();
            flush();

            while (true) {
                sleep(2);
                $currentTodos = Todo::orderBy('created_at', 'desc')->get();
                echo "data: " . json_encode(['type' => 'ping', 'todos' => $currentTodos]) . "\n\n";
                ob_flush();
                flush();
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }
}
