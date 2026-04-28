<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Level;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Inscription;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    public function run(): void
    {
        $classDefinitions = [
            ['name' => 'Génie Logiciel - Groupe A', 'level' => '1ère Année Bac', 'subject' => 'Informatique'],
            ['name' => 'Génie Logiciel - Groupe B', 'level' => '1ère Année Bac', 'subject' => 'Informatique'],
            ['name' => 'Analyse Mathématique', 'level' => '2ème Année Bac', 'subject' => 'Mathématiques'],
            ['name' => 'Physique Quantique', 'level' => '2ème Année Bac', 'subject' => 'Physique-Chimie'],
            ['name' => 'Algorithmique de base', 'level' => 'Tronc Commun', 'subject' => 'Informatique'],
        ];

        $teachers = Teacher::all();
        $subjects = Subject::all();
        $levels = Level::all();
        $students = Student::all();

        if ($teachers->isEmpty() || $students->isEmpty()) {
            $this->command->error("Veuillez lancer TeacherSeeder et StudentSeeder avant celui-ci !");
            return;
        }

        foreach ($classDefinitions as $index => $def) {
            $levelId = $levels->where('name', $def['level'])->first()?->id ?? $levels->first()->id;
            $subjectId = $subjects->where('name', $def['subject'])->first()?->id ?? $subjects->first()->id;

            $teacherId = $teachers->get($index % $teachers->count())->id;

            $class = SchoolClass::create([
                'name' => $def['name'],
                'level_id' => $levelId,
                'teacher_id' => $teacherId,
                'subject_id' => $subjectId,
                'nbr_students' => 0,
            ]);

            $studentBatch = $students->skip($index * 5)->take(10);

            foreach ($studentBatch as $student) {
                $inscription = Inscription::where('student_id', $student->id)->first();

                if ($inscription) {
                    $inscription->schoolClasses()->syncWithoutDetaching([$class->id]);

                    $inscription->update(['school_class_id' => $class->id]);
                }
            }

            $class->update(['nbr_students' => $class->inscriptions()->count()]);
        }

        $this->command->info("Classes créées et étudiants assignés avec succès.");
    }
}
