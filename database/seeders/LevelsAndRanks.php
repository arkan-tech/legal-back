<?php

namespace Database\Seeders;

use App\Models\Rank;
use App\Models\Level;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelsAndRanks extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::create([
            'name' => "تسجيل دخول",
            'experience_points' => 50,
        ]);
        Activity::create([
            'name' => "تحديث ملف حساب قديم",
            'experience_points' => 30,
        ]);
        Activity::create([
            'name' => "إرسال اقتراح",
            'experience_points' => 50,
        ]);
        Activity::create([
            'name' => "إرسال شكوى",
            'experience_points' => 50,
        ]);
        Activity::create([
            'name' => "تسجيل جديد من المشاركة",
            'experience_points' => 50,
        ]);
        Activity::create([
            'name' => "شراء منتج",
            'experience_points' => 50,
        ]);
        Activity::create([
            'name' => "تقييم منتج",
            'experience_points' => 50,
        ]);
        Activity::create([
            'name' => "تقييم مقدم خدمة",
            'experience_points' => 50,
        ]);
        Activity::create([
            'name' => "انشاء حساب جديد",
            'experience_points' => 50,
        ]);

        Level::create([
            'level_number' => 1,
            'required_experience' => 0,
        ]);
        Rank::create([
            'name' => "جديد",
            'min_level' => 1,
            'border_color' => "#CD7F32"
        ]);
    }
}
