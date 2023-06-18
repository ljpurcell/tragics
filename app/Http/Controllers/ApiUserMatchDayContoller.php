<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\User;
use App\Models\UserMatchDay;
use Illuminate\Http\Request;

class ApiUserMatchDayContoller extends Controller
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
        $data = User::with('matchDays')->get();


        return $data;
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
        $userMatchDay = UserMatchDay::find($id);

        dd($userMatchDay);
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
        $validatedData = $request->validate([
            'points_array' => ['json', 'required']
        ]);

        if ($validatedData->fails()) {
            // return error
        }

        $pointsArray = json_decode($validatedData['points_array']);

        $userMatchDay = UserMatchDay::find($id);
        $user = User::find($userMatchDay->user_id);

        if ($userMatchDay && $user) {

            $rulesNotFound = [];

            foreach ($pointsArray as $point) {
                $rule = Rule::find($point);

                if ($rule) {
                    $userMatchDay->total_score += $rule->points;
                } else {
                    $rulesNotFound[] = $rule;
                }
            }

            if ($rulesNotFound) {
                // output error about invalid ruleThe controller class `App\Http\Controllers\ApiPointsController` is not invokable. Did you forget to add the `__invoke` method or is the controller's method missing in your routes file?
            }
        } else {

            // return an error message
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
