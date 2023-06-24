<?php

namespace App\Http\Controllers;

use App\Models\MatchDay;
use App\Models\Rule;
use App\Models\TestMatch;
use App\Models\User;
use App\Models\UserMatchDay;
use Illuminate\Http\Request;

class ApiUserMatchDayController extends Controller
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
        try {
            // get match_day IDs for this match_number
            $testMatchIds = MatchDay::where('match_number', $id)->get()->pluck('id')->toArray();

            // get user_match_day with match_day_id in the above
            $userMatchDays = UserMatchDay::whereIn('match_day_id', $testMatchIds)->with('user')->get();

            $data = $userMatchDays->groupBy('user.name');

            if ($data) {
                $status = 'OK';
                $responseCode = 200;
                $message = 'Success';
            } else {
                $status = 'Not found';
                $responseCode = 404;
                $message = 'Could not locate the resource';
            }
        } catch (\Exception $exception) {
            $status = 'Internal server error';
            $responseCode = 500;
            $message = $exception->getMessage();
        }

        return response()->json(['status' => $status, 'response code' => $responseCode, 'message' => $message, 'data' => $data]);
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

        try {

            $pointsArrayObject = json_decode($validatedData['points_array']);

            $userMatchDay = UserMatchDay::find($id);
            $user = User::find($userMatchDay->user_id);

            if ($userMatchDay && $user) {

                foreach ($pointsArrayObject as $pointScore) {
                    $rule = Rule::where('name', $pointScore->rule)->firstOrFail();

                    if ($rule) {
                        $userMatchDay->total_score += $rule->points;
                    }
                }

                $userMatchDay->rule_points_array = json_encode($request->points_array);
                $userMatchDay->save();

                $status = 'OK';
                $responseCode = 200;
                $message = 'Success';
            } else {
                $status = 'Not found';
                $responseCode = 404;
                $message = 'Could not locate the resource';
            }
        } catch (\Exception $exception) {
            $status = 'Internal server error';
            $responseCode = 500;
            $message = $exception->getMessage();
        }

        return response()->json(['status' => $status, 'response code' => $responseCode, 'message' => $message, 'data' => $validatedData]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
