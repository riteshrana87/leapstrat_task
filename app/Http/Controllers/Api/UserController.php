<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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


    public function getUsers(Request $request) {
        $query = User::query()->with(['userDetail', 'location']);

        // Filtering
        if ($request->has('gender')) {
            $query->whereHas('userDetail', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        if ($request->has('city')) {
            $query->whereHas('location', function ($q) use ($request) {
                $q->where('city', $request->city);
            });
        }

        if ($request->has('country')) {
            $query->whereHas('location', function ($q) use ($request) {
                $q->where('country', $request->country);
            });
        }

        // Limit records
        $users = $query->limit($request->input('limit', 10))->get();
        // Allow selecting specific fields
        if ($request->has('fields')) {
            $fields = explode(',', $request->fields);
            $users = $users->map(function ($user) use ($fields) {
                return collect($user)->only($fields);
            });
        }

        return response()->json($users);
    }
}
