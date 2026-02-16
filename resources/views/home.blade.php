<div class="d-flex flex-column">
    @auth
    <p>Welcome, {{ Auth::user()->name }}!</p>
     <form method="POST" action="/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <br>
    {{-- <p>Table View</p> --}}
    <a href="/new">Add New</a>
    @php

        $headers = ['ID', 'Code', 'Displacement', 'Cylinder Count', 'Created At', 'Updated At'];
        $rows = \App\Models\Engine::all()->map(function($engine) {
            return [
                $engine->id,
                $engine->code,
                $engine->displacement,
                $engine->cylinder_count,
                $engine->created_at->format('Y-m-d H:i:s'),
                $engine->updated_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();

    @endphp

    <x-table :headers="$headers" :rows="$rows" />

    @endauth
    @guest
    <p>Welcome to home page</p>
    <a href="/login" class="btn btn-primary">Login</a>
    <a href="/register" class="btn btn-secondary">Register</a>

    <br>

    <p>Login to View Table</p>
    @endguest
</div>
