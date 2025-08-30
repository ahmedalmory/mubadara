<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Initiative;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $topStudents = User::where('role', 'student')
            ->where('total_points', '>', 0)
            ->withCount(['enrollments', 'completedTasks'])
            ->orderByDesc('total_points')
            ->take(20)
            ->get();

        $totalStudents = User::where('role', 'student')->count();
        $totalInitiatives = Initiative::count();
        $totalCategories = Category::count();
        $totalPointsAwarded = $topStudents->sum('total_points');

        return view('admin.rankings', compact(
            'topStudents', 
            'totalStudents', 
            'totalInitiatives', 
            'totalCategories', 
            'totalPointsAwarded'
        ));
    }
}
