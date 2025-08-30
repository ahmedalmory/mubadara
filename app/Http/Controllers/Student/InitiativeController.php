<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Initiative;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class InitiativeController extends Controller
{
    public function index()
    {
        $initiatives = Initiative::with('category')
            ->withCount('tasks')
            ->active()
            ->paginate(12);
            
        $enrolledInitiatives = auth()->user()->initiatives->pluck('id')->toArray();
        
        return view('student.initiatives.index', compact('initiatives', 'enrolledInitiatives'));
    }

    public function show(Initiative $initiative)
    {
        $initiative->load(['category', 'tasks' => function($query) {
            $query->active()->orderBy('order');
        }]);
        
        $isEnrolled = $initiative->isUserEnrolled(auth()->id());
        $completedTasks = [];
        
        if ($isEnrolled) {
            $completedTasks = auth()->user()->completedTasks()
                ->whereIn('task_id', $initiative->tasks->pluck('id'))
                ->pluck('task_id')
                ->toArray();
        }
        
        return view('student.initiatives.show', compact('initiative', 'isEnrolled', 'completedTasks'));
    }

    public function enroll(Initiative $initiative)
    {
        if ($initiative->isUserEnrolled(auth()->id())) {
            return back()->with('warning', __('messages.Already enrolled'));
        }

        Enrollment::create([
            'user_id' => auth()->id(),
            'initiative_id' => $initiative->id,
        ]);

        return back()->with('success', __('messages.Enrollment successful'));
    }
}
