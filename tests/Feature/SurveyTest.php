<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SurveyTest extends TestCase
{
     protected $user;
    
    protected function setUp() :void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->user->profile()->create([
            'gender_id' => DB::table('genders')->where('code', 1)->value('id'),
            'age' => 1
        ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    public function test_survey_create_page_is_displayed(): void
    {
        $response = $this->actingAs($this->user)
            ->get('/surveys/create');
        
        $response->assertStatus(200);
    }
    
    public function test_user_can_crate_survey(): void
    {
        $response = $this->actingAs($this->user)
            ->post('/surveys', [
                'survey' => [
                    'title' => 'Test Survey',
                    'description' => 'Test Description',
                    'answer_limit' => 10,
                    'gender_id' => DB::table('genders')->where('code', 1)->value('id'),
                    'min_age' => 3,
                    'max_age' => 5,
                ],
                'question' => [
                    ['body' => 'Question 1'],
                    ['body' => 'Question 2'],
                ],
            ]);
        
        $survey = Survey::where('user_id', $this->user->id)
            ->orderBy('created_at')
            ->first();
        $response->assertRedirect('/surveys/' . $survey->id);
    }
}
