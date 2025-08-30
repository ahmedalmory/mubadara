<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index()
    {
        $topStudents = User::where('role', 'student')
            ->where('total_points', '>', 0)
            ->withCount(['enrollments', 'completedTasks'])
            ->orderByDesc('total_points')
            ->take(50)
            ->get();

        $currentUser = auth()->user();
        $userRank = User::where('role', 'student')
            ->where('total_points', '>', $currentUser->total_points)
            ->count() + 1;

        return view('student.rankings', compact('topStudents', 'currentUser', 'userRank'));
    }
}
