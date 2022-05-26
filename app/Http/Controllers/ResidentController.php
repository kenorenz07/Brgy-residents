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

        $residents = Resident::query()->with('household');

        if($request->query('senior') == 1) {
            $residents->where('is_senior_member',1);

            if($request->query('search_key'))
                $residents->where('purok', $request->query('search_key'));

            $residents->whereHas('household',function($query) use($secretary) {
                return $query->where('user_id',$secretary->id);
            });
        }
        if($request->query('vaccinated') == 1) {
            if($request->query('senior') != 1)
                $residents->where('vaccinated',1);
            else 
                $residents->orWhere('vaccinated',1);

            if($request->query('search_key'))
                $residents->where('purok', $request->query('search_key'));

            $residents->whereHas('household',function($query) use($secretary) {
                return $query->where('user_id',$secretary->id);
            });
        }
        if($request->query('four_p') == 1) {
            if($request->query('vaccinated') != 1 && $request->query('senior') != 1)
                $residents->where('is_four_pis_member',1);
            else
                $residents->orWhere('is_four_pis_member',1);

            if($request->query('search_key'))
                $residents->where('purok', $request->query('search_key'));

            $residents->whereHas('household',function($query) use($secretary) {
                return $query->where('user_id',$secretary->id);
            });
        }

        if($request->query('search_key'))
            $residents->where('purok', $request->query('search_key'));

        return $residents->whereHas('household',function($query) use($secretary) {
            return $query->where('user_id',$secretary->id);
        })->get();
    }

    public function download(Request $request)
    {
        return Excel::download(new ResidentsExport($request->query('senior'),$request->query('four_p'),$request->query('vaccinated'),$request->query('search_key')), 'residents.xlsx');
    }

    public function create(Household $household,Request $request)
    {
        $request->validate([
            "first_name" => "required",
            "middle_name" => "required",
            "last_name" => "required",
            "age" => "required",
            "contact_number" => "required",
            "sex" => "required",
            "purok" => "required",
            "birth_country" => "required",
            "birth_province" => "required",
            "birth_city" => "required",
        ]);

        $resident = $household->residents()->create([
            "first_name" => $request->first_name,
            "middle_name" => $request->middle_name,
            "last_name" => $request->last_name,
            "suffix" => $request->suffix,
            "birthday" => Carbon::parse($request->birthday),
            "age" => $request->age,
            "civil_status" => $request->civil_status,
            "contact_number" => $request->contact_number,
            "sex" => $request->sex,
            "purok" => $request->purok,
            "blood_type" => $request->blood_type ? $request->blood_type : 'UNKNOWN',
            "birth_country" => $request->birth_country,
            "birth_province" => $request->birth_province,
            "birth_city" => $request->birth_city,
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
            "last_name" => "required",
            "age" => "required",
            "contact_number" => "required",
            "sex" => "required",
            "purok" => "required",
            "birth_country" => "required",
            "birth_province" => "required",
            "birth_city" => "required",
        ]);

        $resident->update([
            "first_name" => $request->first_name,
            "middle_name" => $request->middle_name,
            "last_name" => $request->last_name,
            "suffix" => $request->suffix,
            "birthday" => Carbon::parse($request->birthday),
            "age" => $request->age,
            "civil_status" => $request->civil_status,
            "contact_number" => $request->contact_number,
            "sex" => $request->sex,
            "purok" => $request->purok,
            "blood_type" => $request->blood_type ? $request->blood_type : 'UNKNOWN',
            "birth_country" => $request->birth_country,
            "birth_province" => $request->birth_province,
            "birth_city" => $request->birth_city,
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
