<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FarmerExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Farmer ID', 'First Name', 'Last Name', 'Date of Birth', 'Gender', 'Country',
            'State/Province', 'Territory', 'Groupement', 'Village', 'Operational Site', 'Family Members',
            'Main Occupation', 'Level of Education', 'Civil Status', 'Type Of Accompaniement',
            'Crop Priotity', 'Member of Association', 'Association Name', 'Contact Number',
            'Mobile Money Operator', 'Account Number', 'Type Of Support','Join Date','Priority Crop',
            'Status','Identity Proof',
        ];
    }
}

