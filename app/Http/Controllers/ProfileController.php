<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Kelas; 
use App\Models\Fakultas; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // List all profiles (Read)
    public function index()
    {
        $profiles = UserModel::with('kelas','fakultas')->get(); 
        return view('profile.index', ['profiles' => $profiles]);
    }

    // Show the form to create a new profile (Create)
    public function create()
    {
        $kelas = Kelas::all(); // Fetch all Kelas records
        $fakultas = Fakultas::all(); // Fetch all Fakultas records
        return view('profile.create', ['kelas' => $kelas, 'fakultas' => $fakultas]);
    }

    // Store a new profile (Store)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'fakultas_id' => 'required|exists:fakultas,id', // Validate fakultas_id
            'foto' => 'nullable|image|max:2048'
        ]);

        $path = $request->file('foto') ? $request->file('foto')->store('public/photos') : null;
        $filename = $path ? basename($path) : null;

        // Create the new profile
        UserModel::create([
            'nama' => $request->input('nama'),
            'jurusan' => $request->input('jurusan'),
            'semester'=> $request->input('semester'),
            'kelas_id' => $request->input('kelas_id'),
            'fakultas_id' => $request->input('fakultas_id'), // Store fakultas_id
            'foto' => $filename
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile created successfully.');
    }

    // Show a specific profile (Read)
    public function show($id)
    {
        $data = UserModel::findOrFail($id);
        return view('profile.show', ['data' => $data]);
    }

    // Show the form to edit a profile (Edit)
    public function edit($id)
    {
        $data = UserModel::findOrFail($id);
        $kelas = Kelas::all(); // Assuming you also need to fetch classes
        $fakultas = Fakultas::all(); // Fetch all Fakultas records

        return view('profile.edit', ['data' => $data, 'kelas' => $kelas,"fakultas"=>$fakultas]);
    }

    // Update an existing profile (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'foto' => 'nullable|image|max:2048'
        ]);

        $profile = UserModel::findOrFail($id);

        $profile->nama = $request->input('nama');
        $profile->kelas_id = $request->input('kelas_id');
        
        $profile->semester = $request->input('semester');
        $profile->fakultas_id = $request->input('fakultas_id');


        if ($request->hasFile('foto')) {
            if ($profile->foto) {
                Storage::delete('public/photos/' . $profile->foto);
            }

            $path = $request->file('foto')->store('public/photos');
            $profile->foto = basename($path);
        }

        $profile->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    // Delete a profile (Delete)
    public function destroy($id)
    {
        $profile = UserModel::findOrFail($id);

        if ($profile->foto) {
            Storage::delete('public/photos/' . $profile->foto);
        }

        $profile->delete();

        return redirect()->route('profile.index')->with('success', 'Profile deleted successfully.');
    }
}
