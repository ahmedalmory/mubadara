<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'en' => 'Men\'s Section',
                    'ar' => 'قسم الرجال'
                ],
                'description' => [
                    'en' => 'Initiatives and activities for male students',
                    'ar' => 'المبادرات والأنشطة للطلاب الذكور'
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Women\'s Section',
                    'ar' => 'قسم النساء'
                ],
                'description' => [
                    'en' => 'Initiatives and activities for female students',
                    'ar' => 'المبادرات والأنشطة للطالبات الإناث'
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Community Service',
                    'ar' => 'خدمة المجتمع'
                ],
                'description' => [
                    'en' => 'Community service and volunteer initiatives',
                    'ar' => 'مبادرات خدمة المجتمع والعمل التطوعي'
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Academic Excellence',
                    'ar' => 'التميز الأكاديمي'
                ],
                'description' => [
                    'en' => 'Academic achievement and research initiatives',
                    'ar' => 'مبادرات الإنجاز الأكاديمي والبحثي'
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Sports & Health',
                    'ar' => 'الرياضة والصحة'
                ],
                'description' => [
                    'en' => 'Sports activities and health promotion initiatives',
                    'ar' => 'الأنشطة الرياضية ومبادرات تعزيز الصحة'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
