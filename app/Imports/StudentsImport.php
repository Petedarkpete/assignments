<?php
namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user = User::create([
            'name'       => $row['first_name'] . ' ' . $row['last_name'],
            'first_name' => $row['first_name'],
            'last_name'  => $row['last_name'],
            'gender'     => $row['gender'],
            'password'   => Hash::make(Str::random(10)),
        ]);

        return Student::create([
            'user_id'          => $user->id,
            'class_id'         => $row['class_id'],
            'teacher_id'       => $row['teacher_id'],
            'index_number'     => $row['index_number'],
            'admission_number' => $row['admission_number'],
        ]);
    }
}
