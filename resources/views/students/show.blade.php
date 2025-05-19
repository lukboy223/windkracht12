<x-app-layout>


<div class="container">
    <h1>Student Details</h1>
    <div class="mb-3">
        <strong>Name:</strong> {{ $student->name }}
    </div>
    <div class="mb-3">
        <strong>Email:</strong> {{ $student->email }}
    </div>
    <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
</div>
</x-app-layout>
