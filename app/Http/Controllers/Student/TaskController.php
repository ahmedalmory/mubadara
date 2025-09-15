<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskCompletion;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Mark task as completed by the student
     */
    public function markComplete(Request $request, Task $task)
    {
        $student = auth()->user();
        
        if ($task->isCompletedBy($student->id)) {
            return back()->with('error', __('messages.Task already completed'));
        }

        if (!$task->initiative->isUserEnrolled($student->id)) {
            return back()->with('error', __('messages.Not enrolled in this initiative'));
        }

        TaskCompletion::create([
            'user_id' => $student->id,
            'task_id' => $task->id,
            'completed_by' => $student->id,
            'points_awarded' => $task->points_value,
            'notes' => __('messages.Self-completed by student'),
        ]);

        return back()->with('success', __('messages.Task completed successfully with points', ['points' => $task->points_value]));
    }

    /**
     * Mark task as uncompleted by the student
     */
    public function markUncomplete(Request $request, Task $task)
    {
        $student = auth()->user();
        
        // Check if task is actually completed
        if (!$task->isCompletedBy($student->id)) {
            return back()->with('error', __('messages.Task is not completed'));
        }

        // Check if student is enrolled in the initiative
        if (!$task->initiative->isUserEnrolled($student->id)) {
            return back()->with('error', __('messages.Not enrolled in this initiative'));
        }

        // Find and delete the completion record
        $completion = $task->getCompletionFor($student->id);
        if ($completion) {
            $pointsLost = $completion->points_awarded;
            $completion->delete();
            
            return back()->with('success', __('messages.Task uncompleted successfully with points', ['points' => $pointsLost]));
        }

        return back()->with('error', __('messages.Unable to uncomplete task'));
    }
}
