<?php

namespace App\Http\Controllers;

use App\Exports\ResidentsExport;
use App\Models\Household;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ResidentController extends Controller
{

    public function index(Request $request)
    {
        $secretary = $request->user();

        $residents = Resident::with('household')->whereHas('household',function($query) use($secretary) {
            return $query->where('user_id',$secretary->id);
        })->get();

        return $residents;
    }

    public function download()
    {
        return Excel::download(new ResidentsExport, 'residents.xlsx');
    }

    public function create(Household $household,Request $request)
    {
        $request->validate([
            "first_name" => "required",
            "middle_name" => "required",
            "last_name" => "required",
            "household_status"=> "required",
            "age" => "required",
            "contact_number" => "required",
            "gender" => "required",
            "purok" => "required",
        ]);

        $resident = $household->residents()->create([
            "first_name" => $request->first_name,
            "middle_name" => $request->middle_name,
            "last_name" => $request->last_name,
            "household_status" => $request->household_status,
            "suffix" => $request->suffix,
            "birthday" => Carbon::parse($request->birthday),
            "age" => $request->age,
            "civil_status" => $request->civil_status,
            "contact_number" => $request->contact_number,
            "gender" => $request->gender,
            "purok" => $request->purok,
            "vaccinated" => $request->vaccinated,
            "vaccine_name" => $request->vaccine_name,
            "dose" => $request->dose,
            "is_four_pis_member" => $request->is_four_pis_member,
            "is_senior_member" => $request->is_senior_member,
        ]);

        return $resident;
    }

    public function update(Resident $resident,Request $request)
    {
        $request->validate([
            "first_name" => "required",
            "middle_name" => "required",
            "household_status"=> "required",
            "last_name" => "required",
            "age" => "required",
            "contact_number" => "required",
            "gender" => "required",
            "purok" => "required",
        ]);

        $resident->update([
            "first_name" => $request->first_name,
            "middle_name" => $request->middle_name,
            "last_name" => $request->last_name,
            "suffix" => $request->suffix,
            "birthday" => Carbon::parse($request->birthday),
            "household_status" => $request->household_status,
            "age" => $request->age,
            "civil_status" => $request->civil_status,
            "contact_number" => $request->contact_number,
            "gender" => $request->gender,
            "purok" => $request->purok,
            "vaccinated" => $request->vaccinated,
            "vaccine_name" => $request->vaccine_name,
            "dose" => $request->dose,
            "is_four_pis_member" => $request->is_four_pis_member,
            "is_senior_member" => $request->is_senior_member,
        ]);

        return $resident;

    }

    public function show(Resident $resident)
    {
        return $resident;
    }

    public function delete(Resident $resident)
    {
        return $resident->delete();
    }
}
