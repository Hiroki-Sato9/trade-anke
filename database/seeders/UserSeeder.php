<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Profile;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            
        $users = User::factory()
            ->count(30)
            ->has(Profile::factory())
            ->create();

        $surveys = Survey::factory()
            ->count(10)
            ->has(Question::factory()->count(5))
            ->recycle($users)
            ->create();
                    
    }
}
