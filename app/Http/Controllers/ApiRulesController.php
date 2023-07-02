<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use Illuminate\Http\Request;

class ApiRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Rule::all();

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
        $validated = $request->validate([
            'name' => [
                'string',
                'required'
            ],
            'description' => [
                'string',
                'required'
            ],
            'points' => [
                'numeric',
                'required'
            ]
        ]);


        try {

            $rule = new Rule();

            $rule->name = $request->get('name');
            $rule->description = $request->get('description');
            $rule->points = $request->get('points');
            $rule->save();

            $status = 'OK';
            $responseCode = 200;
            $message = 'Success';
        } catch (\Exception $exception) {
            $status = 'Internal server error';
            $responseCode = 500;
            $message = $exception->getMessage();
        }

        return response()->json(['status' => $status, 'response code' => $responseCode, 'message' => $message, 'data' => $validated]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * PUT /{id}
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => [
                'string',
                'required'
            ],
            'description' => [
                'string',
                'required'
            ],
            'points' => [
                'numeric',
                'required'
            ]
        ]);


        try {

            $rule = Rule::find($id);

            if ($rule) {
                $rule->name = $request->get('name');
                $rule->description = $request->get('description');
                $rule->points = $request->get('points');
                $rule->save();

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

        return response()->json(['status' => $status, 'response code' => $responseCode, 'message' => $message, 'data' => $validated]);
    }

    /**
     * DELETE /{id}
     */
    public function destroy(string $id)
    {

        try {

            $rule = Rule::find($id);

            if ($rule) {
                $rule->delete();

                $status = 'OK';
                $responseCode = 200;
                $message = 'Success';
                $data = $rule;
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
}
