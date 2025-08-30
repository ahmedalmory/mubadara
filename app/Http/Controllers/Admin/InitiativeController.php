<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Initiative;
use App\Models\Category;
use Illuminate\Http\Request;

class InitiativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $initiatives = Initiative::with(['category', 'tasks', 'enrollments'])
            ->withCount(['tasks', 'enrollments'])
            ->paginate(15);
        
        return view('admin.initiatives.index', compact('initiatives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = Category::active()->get();
        $selectedCategory = $request->get('category');
        return view('admin.initiatives.create', compact('categories', 'selectedCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        Initiative::create([
            'category_id' => $request->category_id,
            'name' => [
                'en' => $request->name_en,
                'ar' => $request->name_ar,
            ],
            'description' => [
                'en' => $request->description_en,
                'ar' => $request->description_ar,
            ],
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.initiatives.index')
            ->with('success', __('messages.Initiative created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Initiative $initiative)
    {
        $initiative->load(['category', 'tasks' => function($query) {
            $query->orderBy('order');
        }, 'enrollments.user']);
        
        return view('admin.initiatives.show', compact('initiative'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Initiative $initiative)
    {
        $categories = Category::active()->get();
        return view('admin.initiatives.edit', compact('initiative', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Initiative $initiative)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        $initiative->update([
            'category_id' => $request->category_id,
            'name' => [
                'en' => $request->name_en,
                'ar' => $request->name_ar,
            ],
            'description' => [
                'en' => $request->description_en,
                'ar' => $request->description_ar,
            ],
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.initiatives.index')
            ->with('success', __('messages.Initiative updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Initiative $initiative)
    {
        $initiative->delete();

        return redirect()->route('admin.initiatives.index')
            ->with('success', __('messages.Initiative deleted successfully'));
    }
}
