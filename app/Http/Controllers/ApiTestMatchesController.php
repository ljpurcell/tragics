<?php

namespace App\Http\Controllers;

use App\Models\MatchDay;
use App\Models\User;
use Illuminate\Http\Request;

class ApiTestMatchesController extends Controller
{
    public $availableRelations = [
        'user',
        'matchDays'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $matchDayIds = MatchDay::where('match_number', $id)->get()->pluck('id')->toArray();

        $userMatchDaysForTest = User::with('matchDays')->whereIn('user_match_days.match_day_id', $matchDayIds)->get();

        return $userMatchDaysForTest;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
