<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\Survey;
use App\Models\User;
use App\Models\Delivered;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    
    public function detail(Request $request): View
    {
        $user = $request->user();
        $answered_surveys = Survey::answered_by_user($user->id);
        
        return view('profile.detail', [
            'created_surveys' => $user->surveys,
            'answered_surveys' => $answered_surveys,
        ]);
    }
    
    public function deliver(Request $request)
    {
        // 何人に配布するか
        $num = $request->input('num');
        $survey = Survey::find($request->input('survey'));
        
        $i = 0;
        foreach (User::all() as $user)
        {
            if ($i >= $num){
                break;
            }
            if ($survey->is_allowed_to_deliver($user)){
                // deliveredテーブルに登録
                // dd($user);
                $survey->delivered_users()->attach($user->id);
                $i += 1;
            }
        }
        $survey->refresh();
        dd($survey->delivered_users);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // dd($request);
        $request->user()->fill($request->validated()['user']);
        
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        $request->user()->profile->fill($request->validated()['profile'])->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
