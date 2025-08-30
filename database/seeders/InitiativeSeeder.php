<?php

namespace Database\Seeders;

use App\Models\Initiative;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitiativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $communityServiceCategory = Category::where('name->en', 'Community Service')->first();
        $academicCategory = Category::where('name->en', 'Academic Excellence')->first();
        $sportsCategory = Category::where('name->en', 'Sports & Health')->first();

        // Community Service Initiative
        $cleanupInitiative = Initiative::create([
            'category_id' => $communityServiceCategory->id,
            'name' => [
                'en' => 'Campus Cleanup Initiative',
                'ar' => 'مبادرة تنظيف الحرم الجامعي'
            ],
            'description' => [
                'en' => 'A comprehensive initiative to keep our campus clean and green',
                'ar' => 'مبادرة شاملة للحفاظ على نظافة الحرم الجامعي وخضرته'
            ],
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
        ]);

        // Add tasks for cleanup initiative
        Task::create([
            'initiative_id' => $cleanupInitiative->id,
            'title' => [
                'en' => 'Organize Cleanup Day',
                'ar' => 'تنظيم يوم التنظيف'
            ],
            'description' => [
                'en' => 'Organize and participate in a campus-wide cleanup day',
                'ar' => 'تنظيم والمشاركة في يوم تنظيف شامل للحرم الجامعي'
            ],
            'points_value' => 50,
            'order' => 1,
        ]);

        Task::create([
            'initiative_id' => $cleanupInitiative->id,
            'title' => [
                'en' => 'Plant Trees',
                'ar' => 'زراعة الأشجار'
            ],
            'description' => [
                'en' => 'Plant and maintain trees around campus',
                'ar' => 'زراعة ورعاية الأشجار حول الحرم الجامعي'
            ],
            'points_value' => 30,
            'order' => 2,
        ]);

        Task::create([
            'initiative_id' => $cleanupInitiative->id,
            'title' => [
                'en' => 'Awareness Campaign',
                'ar' => 'حملة توعية'
            ],
            'description' => [
                'en' => 'Create and distribute awareness materials about environmental protection',
                'ar' => 'إنشاء وتوزيع مواد توعوية حول حماية البيئة'
            ],
            'points_value' => 40,
            'order' => 3,
        ]);

        // Academic Excellence Initiative
        $tutorInitiative = Initiative::create([
            'category_id' => $academicCategory->id,
            'name' => [
                'en' => 'Peer Tutoring Program',
                'ar' => 'برنامج التدريس بين الأقران'
            ],
            'description' => [
                'en' => 'Help fellow students excel in their academic pursuits',
                'ar' => 'مساعدة الطلاب الزملاء على التفوق في مساعيهم الأكاديمية'
            ],
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addMonths(6),
        ]);

        // Add tasks for tutoring initiative
        Task::create([
            'initiative_id' => $tutorInitiative->id,
            'title' => [
                'en' => 'Conduct Tutorial Sessions',
                'ar' => 'إجراء جلسات تدريسية'
            ],
            'description' => [
                'en' => 'Conduct at least 5 tutorial sessions for struggling students',
                'ar' => 'إجراء ما لا يقل عن 5 جلسات تدريسية للطلاب المتعثرين'
            ],
            'points_value' => 60,
            'order' => 1,
        ]);

        Task::create([
            'initiative_id' => $tutorInitiative->id,
            'title' => [
                'en' => 'Create Study Materials',
                'ar' => 'إنشاء مواد دراسية'
            ],
            'description' => [
                'en' => 'Develop comprehensive study guides and materials',
                'ar' => 'تطوير أدلة ومواد دراسية شاملة'
            ],
            'points_value' => 40,
            'order' => 2,
        ]);

        // Sports Initiative
        $sportsInitiative = Initiative::create([
            'category_id' => $sportsCategory->id,
            'name' => [
                'en' => 'Fitness Challenge',
                'ar' => 'تحدي اللياقة البدنية'
            ],
            'description' => [
                'en' => 'Promote healthy lifestyle through fitness activities',
                'ar' => 'تعزيز نمط الحياة الصحي من خلال أنشطة اللياقة البدنية'
            ],
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addMonths(2),
        ]);

        // Add tasks for sports initiative
        Task::create([
            'initiative_id' => $sportsInitiative->id,
            'title' => [
                'en' => 'Daily Exercise Log',
                'ar' => 'سجل التمارين اليومية'
            ],
            'description' => [
                'en' => 'Maintain a daily exercise log for 30 days',
                'ar' => 'الاحتفاظ بسجل تمارين يومية لمدة 30 يوماً'
            ],
            'points_value' => 35,
            'order' => 1,
        ]);

        Task::create([
            'initiative_id' => $sportsInitiative->id,
            'title' => [
                'en' => 'Organize Sports Event',
                'ar' => 'تنظيم حدث رياضي'
            ],
            'description' => [
                'en' => 'Organize a sports tournament or fitness event',
                'ar' => 'تنظيم بطولة رياضية أو حدث لياقة بدنية'
            ],
            'points_value' => 55,
            'order' => 2,
        ]);
    }
}
