@extends('layouts.teacher')
@section('title', 'Mes Classes - School-Way')
@section('content')
@vite(['resources/js/teacher/classes.js'])
<div class="w-full h-full p-6 md:p-12 text-white">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-black uppercase tracking-tighter">Mes Classes</h2>
            <div class="w-12 h-1 bg-amber-500 mt-2 rounded-full"></div>
        </div>
        <div id="classes-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="animate-pulse bg-gray-900 border border-gray-800 p-6 rounded-2xl h-32"></div>
            <div class="animate-pulse bg-gray-900 border border-gray-800 p-6 rounded-2xl h-32"></div>
            <div class="animate-pulse bg-gray-900 border border-gray-800 p-6 rounded-2xl h-32"></div>
        </div>
    </div>
</div>
@endsection
