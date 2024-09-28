<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Kelas; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // List all profiles (Read)
    public function index()
    {
        $profiles = UserModel::with('kelas')->get(); 
        return view('profile.index', ['profiles' => $profiles]);
    }

    // Show the form to create a new profile (Create)
    public function create()
    {
        $kelas = Kelas::all(); // Fetch all Kelas records
        return view('profile.create', ['kelas' => $kelas]);
    }

    // Store a new profile (Store)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'npm' => 'required|string|max:255|unique:user,npm', // Ensure unique npm in the user table
            'kelas_id' => 'required|exists:kelas,id',
            'foto' => 'nullable|image|max:2048'
        ]);

        $path = $request->file('foto') ? $request->file('foto')->store('public/photos') : null;
        $filename = $path ? basename($path) : null;

        // Create the new profile
        UserModel::create([
            'nama' => $request->input('nama'),
            'npm' => $request->input('npm'),
            'kelas_id' => $request->input('kelas_id'),
            'foto' => $filename
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile created successfully.');
    }

    // Show a specific profile (Read)
    public function show($npm)
    {
        $data = UserModel::where('npm', $npm)->first();
        return view('profile.show', ['data' => $data]);
    }

    // Show the form to edit a profile (Edit)
    public function edit($npm)
    {
        $data = UserModel::where('npm', $npm)->first();
        $kelas = Kelas::all(); // Assuming you also need to fetch classes
        return view('profile.edit', ['data' => $data, 'kelas' => $kelas]);
    }

    // Update an existing profile (Update)
    public function update(Request $request, $npm)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'npm' => [
                'required',
                'string',
                'max:255',
                // Ensure unique npm in the user table excluding the current profile
                'unique:user,npm,' . $npm . ',npm' // Adjust this based on how your npm is identified in the database
            ],
            'kelas_id' => 'required|exists:kelas,id',
            'foto' => 'nullable|image|max:2048'
        ]);

        $profile = UserModel::where('npm', $npm)->first();

        if (!$profile) {
            return redirect()->route('profile.index')->withErrors('Profile not found.');
        }

        $profile->nama = $request->input('nama');
        $profile->kelas_id = $request->input('kelas_id');

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
    public function destroy($npm)
    {
        $profile = UserModel::where('npm', $npm)->first();

        if (!$profile) {
            return redirect()->route('profile.index')->withErrors('Profile not found.');
        }

        if ($profile->foto) {
            Storage::delete('public/photos/' . $profile->foto);
        }

        $profile->delete();

        return redirect()->route('profile.index')->with('success', 'Profile deleted successfully.');
    }
}
