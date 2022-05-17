<?php

namespace App\Http\Controllers;

use App\Models\Household;
use Illuminate\Http\Request;

class HouseholdController extends Controller
{

    public $secretary;

    public function __construct(Request $request)
    {
        $this->secretary = $request->user();
    }

    public function index(Request $request)
    {
        return $this->secretary->households;
    }

    public function show(Household $household)
    {
        return $household->load('residents');
    }

    public function create(Request $request)
    {
        $request->validate([
            "number" => "required",
        ]);

        $new_household = $this->secretary->households()->create([
            "number" => $request->number
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

