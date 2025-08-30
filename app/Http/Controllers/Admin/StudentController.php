<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Initiative;
use App\Models\Task;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')
            ->withCount(['enrollments', 'completedTasks'])
            ->orderByDesc('total_points');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $students = $query->paginate(15);

        return view('admin.students.index', compact('students'));
    }

    public function show(User $student)
    {
        $student->load(['enrollments.initiative.category', 'completedTasks.task.initiative']);
        
        $enrolledInitiatives = $student->enrollments()
            ->with(['initiative.tasks', 'initiative.category'])
            ->get();

        return view('admin.students.show', compact('student', 'enrolledInitiatives'));
    }

    public function markTaskComplete(Request $request, User $student, Task $task)
    {
        return app(TaskController::class)->markComplete($request, $task, $student);
    }
}
