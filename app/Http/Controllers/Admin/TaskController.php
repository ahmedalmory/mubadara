<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Initiative;
use App\Models\Task;
use App\Models\TaskCompletion;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Initiative $initiative)
    {
        $tasks = $initiative->tasks()->orderBy('order')->paginate(15);
        return view('admin.tasks.index', compact('initiative', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Initiative $initiative)
    {
        return view('admin.tasks.create', compact('initiative'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Initiative $initiative)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'points_value' => 'required|integer|min:1',
            'order' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $initiative->tasks()->create([
            'title' => [
                'en' => $request->title_en,
                'ar' => $request->title_ar,
            ],
            'description' => [
                'en' => $request->description_en,
                'ar' => $request->description_ar,
            ],
            'points_value' => $request->points_value,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.initiatives.show', $initiative)
            ->with('success', __('messages.Task created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Initiative $initiative, Task $task)
    {
        $task->load(['completions.user', 'completions.completedBy']);
        return view('admin.tasks.show', compact('initiative', 'task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Initiative $initiative, Task $task)
    {
        return view('admin.tasks.edit', compact('initiative', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Initiative $initiative, Task $task)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'points_value' => 'required|integer|min:1',
            'order' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $task->update([
            'title' => [
                'en' => $request->title_en,
                'ar' => $request->title_ar,
            ],
            'description' => [
                'en' => $request->description_en,
                'ar' => $request->description_ar,
            ],
            'points_value' => $request->points_value,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.initiatives.show', $initiative)
            ->with('success', __('messages.Task updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Initiative $initiative, Task $task)
    {
        $task->delete();

        return redirect()->route('admin.initiatives.show', $initiative)
            ->with('success', __('messages.Task deleted successfully'));
    }

    /**
     * Mark task as completed for a student
     */
    public function markComplete(Request $request, Task $task, User $student)
    {
        $request->validate([
            'points_awarded' => 'required|integer|min:1|max:' . $task->points_value,
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if already completed
        if ($task->isCompletedBy($student->id)) {
            return back()->with('error', __('messages.Task already completed by this student'));
        }

        // Check if student is enrolled in the initiative
        if (!$task->initiative->isUserEnrolled($student->id)) {
            return back()->with('error', __('messages.Student not enrolled in this initiative'));
        }

        TaskCompletion::create([
            'user_id' => $student->id,
            'task_id' => $task->id,
            'completed_by' => auth()->id(),
            'points_awarded' => $request->points_awarded,
            'notes' => $request->notes,
        ]);

        return back()->with('success', __('messages.Task completed successfully'));
    }
}
