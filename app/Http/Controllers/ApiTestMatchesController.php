<?php

namespace App\Http\Controllers;

use App\Models\TestMatch;
use Illuminate\Http\Request;

class ApiTestMatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = TestMatch::all();

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
