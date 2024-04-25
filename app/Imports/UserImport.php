<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel, WithUpserts, WithUpsertsColumns, WithHeadingRow
{
    
    public function model(array $row)
    {
        //
        return new User([
            'name' => $row['Name'],
            'email' => $row['Email'],
            'phone' => $row['Phone'],
            'role' => 2,
            'year' => $row['Year'],
            'admission' => $row['Admission'],
        ]);
    }
    public function uniqueBy()
    {
        return ['email', 'phone'];
    }
    public function uniqueByColumns()
    {
        return ['name'];
    }
}
