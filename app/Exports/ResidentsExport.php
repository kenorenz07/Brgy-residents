<?php

namespace App\Exports;

use App\Models\Resident;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;

class ResidentsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Resident::all();
    // }

    public function __construct($senior,$four_p,$vaccinated,$search_key)
    {
        $this->senior = $senior;
        $this->vaccinated = $vaccinated;
        $this->four_p = $four_p;
        $this->search_key = $search_key;
    }

    public function query()
    {
        $residents =  Resident::query()->with('household')->whereHas('household',function($query) {
            return $query->where('user_id',Auth::user()->id);
        });
           
       

        if($this->senior == 1) {
            $residents->where('is_senior_member',1);

            if($this->search_key)
                $residents->where("purok",$this->search_key);
        }
        if($this->vaccinated == 1) {
            if($this->senior != 1)
                $residents->where('vaccinated',1);
            else
                $residents->orWhere('vaccinated',1);

            if($this->search_key)
                $residents->where("purok",$this->search_key);
        }
        if($this->four_p == 1){
            if($this->senior != 1 && $this->vaccinated != 1)
                $residents->where('is_four_pis_member',1);
            else
                $residents->orWhere('is_four_pis_member',1);

            if($this->search_key)
                $residents->where("purok",$this->search_key);
        } 

        if($this->search_key)
            $residents->where("purok",$this->search_key);

        return $residents;
    }

    public function map($resident): array
    {
        return [
            $resident->household->number,
            $resident->household->address,
            $resident->first_name,
            $resident->middle_name,
            $resident->last_name,
            $resident->suffix,
            $resident->birthday,
            $resident->age,
            $resident->civil_status,
            $resident->contact_number,
            $resident->sex,
            $resident->purok,
            $resident->blood_type,
            $resident->birth_country,
            $resident->birth_province,
            $resident->birth_city,
            $resident->vaccinated ? "Yes":"No",
            $resident->vaccine_name,
            $resident->dose,
            $resident->is_four_pis_member ? "Yes":"No",
            $resident->is_senior_member ? "Yes":"No",
        ];
    }

    public function headings(): array
    {
        return  $columns = [   
            "Household number",              
            "Household address",              
            "First name",
            "Middle name",
            "Last name",
            "Suffix",
            "Birthday",
            "Age",
            "Civil status",
            "Contact number",
            "Sex",
            "Purok",
            "Blood type",
            "Birth country",
            "Birth province",
            "Birth city",
            "Vaccinated",
            "Vaccine name",
            "Dose",
            "4ps member",
            "Senior",
        ];
    }
}
