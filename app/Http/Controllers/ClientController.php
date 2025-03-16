<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Inicialitzar la query
        $query = User::query();

        $query->where('role_id', 1);

        // Filtrar per nom
        if ($request->filled('name')) {
            $query->where('first_name', 'like', '%' . $request->name . '%')
                ->orWhere('last_name', 'like', '%' . $request->name . '%');
        }

        // Filtrar per email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }



        // Obtenir els resultats filtrats
        $clients = $query->get();

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar les dades
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:15'],
        ]);

        // Crear un nou usuari
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        // Opcionalment pots afegir una contrasenya per defecte
        $user->password = bcrypt('password123'); // Canvia-ho segons necessitat

        $user->save();

        return redirect()->route('clients.index')->with('success', 'Client creat correctament.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = User::findOrFail($id);

        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
            'phone' => ['nullable', 'string', 'max:15'],
        ]);

        $user = User::findOrFail($id);

        // Actualitzar les dades
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');


        $user->save();

        return redirect()->route('clients.index')->with('success', 'Client actualitzat correctament.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Evitar eliminar l'usuari loguejat
        if (Auth::id() === $user->id) {
            return back()->with('error', 'No pots eliminar el teu propi compte.');
        }

        $user->delete();

        return back()->with('success', 'Usuari eliminat correctament.');
    }
}
