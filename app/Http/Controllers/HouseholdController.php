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

    public function getMarkers(Request $request)
    {
        $secretary = $request->user();
        $households = $secretary->households();

        if($request->query('household_id'))
            $households->where('id','!=',$request->query('household_id'));

        $markers = [];

        foreach($households->get() as $household) {

            $seniors = $household->residents()->where('is_senior_member',1)->count();
            $four_members = $household->residents()->where('is_four_pis_member',1)->count();
            $vaccinated = $household->residents()->where('vaccinated',1)->count();
            
            $markers[] = [
                "id" => $household->id,
                "location" => [
                    "lng" => $household->long,
                    "lat" => $household->lat,
                ],
                "description" => "<strong>".$household->address."</strong> <hr/><strong> Household :".$household->number .", Residents:".count($household->residents)." (".$seniors ." senior/s, ".$four_members." 4ps member, " .$vaccinated." vaccinated) </strong>"
            ];
        }
        
        return $markers;
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

