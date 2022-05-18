<?php

namespace App\Http\Controllers;

use App\Models\Household;
use Illuminate\Http\Request;

class HouseholdController extends Controller
{

    public function index(Request $request)
    {
        $secretary = $request->user();

        return $secretary->households;
    }

    public function show(Household $household)
    {
        return $household->load('residents');
    }

    public function create(Request $request)
    {
        $secretary = $request->user();

        $request->validate([
            "number" => "required",
            "location" => "required"
        ]);

        $new_household = $secretary->households()->create([
            "number" => $request->number,
            "address" => $request->location['address'],
            "long" => $request->location['position']['lng'],
            "lat" => $request->location['position']['lat'],
        ]);

        return $new_household;

    }

    public function update(Household $household,Request $request)
    {
        $request->validate([
            "number" => "required",
        ]);

        $household->update([
            "number" => $request->number
        ]);

        return $household;
    }

    public function delete(Household $household)
    {
        $household->residents()->delete();

        return $household->delete();
    }
}

