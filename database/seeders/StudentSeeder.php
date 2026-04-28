public function run(): void
{
    // 1. Créer l'année avec le bon nom de table et colonne
    $year = Year::firstOrCreate(
        ['title' => '2025-2026'],
        [
            'beginning_date' => '2025-09-01',
            'end_date' => '2026-06-30',
            'current' => true // Colonne 'current' selon ta migration
        ]
    );

    // 2. Création d'un prof et d'un niveau pour la classe
    $teacher = \App\Models\Teacher::first() ?? \App\Models\Teacher::create(['user_id' => 1]); // Ajuste selon tes besoins
    $level = \App\Models\Level::firstOrCreate(['name' => '1ère Année Bac']);
    $subject = \App\Models\Subject::firstOrCreate(['name' => 'Informatique', 'coefficient' => 2]);

    $class = \App\Models\SchoolClass::firstOrCreate(
        ['name' => 'Génie Logiciel A'],
        [
            'level_id' => $level->id,
            'teacher_id' => $teacher->id,
            'subject_id' => $subject->id,
            'nbr_students' => 10
        ]
    );

    // 3. Création de l'étudiant
    $user = User::create([
        'nom' => 'Kaiser',
        'prenom' => 'Student',
        'email' => 'student@test.com',
        'password' => bcrypt('password'),
        'role' => 'student',
        'gender' => 'M',
        'adress' => 'Ma Rue 123', // Un seul 'd' comme dans ta migration !
    ]);

    $student = Student::create(['user_id' => $user->id]);

    $inscription = Inscription::create([
        'student_id' => $student->id,
        'year_id' => $year->id,
        'school_class_id' => $class->id, // Utilisation de la colonne directe
        'statut' => 'current',
    ]);

    // 4. Paiements (Table 'paiment')
    $start = Carbon::parse($year->beginning_date);
    $end = Carbon::parse($year->end_date);

    while ($start->lte($end)) {
        \DB::table('paiment')->insert([
            'inscription_id' => $inscription->id,
            'mois' => $start->format('Y-m-01'),
            'etatPaiement' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $start->addMonth();
    }
}
