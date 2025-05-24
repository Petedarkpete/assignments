<?php
namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithChunkReading, WithBatchInserts
{
    use Importable, SkipsFailures;

    protected $teacherId;
    protected $classId;

    public array $rowErrors = [];

    public function __construct($teacherId, $classId)
    {
        $this->teacherId = $teacherId;
        $this->classId = $classId;
    }

    public function rules(): array
    {
        return [
            '*.first_name'        => 'required|string|max:255',
            '*.last_name'         => 'required|string|max:255',
            '*.gender'            => 'required|in:Male,Female',
            '*.index_number'      => 'required|digits:6|unique:students,index_number',
            '*.admission_number'  => 'required|string|max:255|unique:students,admission_number',
        ];
    }

    public function model(array $row)
    {
        Log::info("Processing row: ", $row);

        $user = User::create([
            'name'       => $row['first_name'] . ' ' . $row['last_name'],
            'first_name' => $row['first_name'],
            'last_name'  => $row['last_name'],
            'gender'     => $row['gender'],
            'password'   => Hash::make(Str::random(10)),
        ]);

        Student::create([
            'user_id'          => $user->id,
            'class_id'         => $this->classId,
            'teacher_id'       => $this->teacherId,
            'index_number'     => $row['index_number'],
            'admission_number' => $row['admission_number'],
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
