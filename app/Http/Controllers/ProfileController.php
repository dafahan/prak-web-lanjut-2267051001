<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // List all profiles (Read)
    public function index()
    {
        // Path to CSV file
        $csvFilePath = storage_path('app/public/users.csv');

        // Read the CSV file
        $profiles = [];
        if (file_exists($csvFilePath)) {
            $file = fopen($csvFilePath, 'r');
            while (($data = fgetcsv($file)) !== FALSE) {
                $profiles[] = $data;
            }
            fclose($file);
        }

        // Return the view with all profiles
        return view('profile.index', ['profiles' => $profiles]);
    }

    // Show the form to create a new profile (Create)
    public function create()
    {
        return view('profile.create');
    }

    // Store a new profile (Store)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'npm' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'foto' => 'required|image|max:2048'
        ]);

        $csvFilePath = storage_path('app/public/users.csv');

        // Check if the NPM already exists
        if (file_exists($csvFilePath)) {
            $file = fopen($csvFilePath, 'r');
            while (($row = fgetcsv($file)) !== FALSE) {
                if ($row[1] == $request->input('npm')) {
                    fclose($file);
                    return redirect()->back()->withErrors('NPM already exists.');
                }
            }
            fclose($file);
        }

        // Store the uploaded photo
        $path = $request->file('foto')->store('public/photos');
        $filename = basename($path);

        // Append the new data to CSV
        $data = [
            'nama' => $request->input('nama'),
            'npm' => $request->input('npm'),
            'kelas' => $request->input('kelas'),
            'foto' => $filename
        ];

        // Open the CSV file and add the new profile
        $file = fopen($csvFilePath, 'a');
        fputcsv($file, $data);
        fclose($file);

        return redirect()->route('profile.index');
    }

    // Show the profile (Read)
    public function show($npm)
    {
        // Find the profile by NPM in CSV
        $csvFilePath = storage_path('app/public/users.csv');
        $profile = null;
        if (file_exists($csvFilePath)) {
            $file = fopen($csvFilePath, 'r');
            while (($row = fgetcsv($file)) !== FALSE) {
                if ($row[1] == $npm) {
                    $profile = $row;
                    break;
                }
            }
            fclose($file);
        }

        if (!$profile) {
            return redirect()->route('profile.index')->withErrors('Profile not found.');
        }

        return view('profile.show', ['data' => $profile]);
    }

    // Show the form to edit a profile (Edit)
    public function edit($npm)
    {
        $csvFilePath = storage_path('app/public/users.csv');
        $profile = null;

        if (file_exists($csvFilePath)) {
            $file = fopen($csvFilePath, 'r');
            while (($row = fgetcsv($file)) !== FALSE) {
                if ($row[1] == $npm) {
                    $profile = $row;
                    break;
                }
            }
            fclose($file);
        }

        if (!$profile) {
            return redirect()->route('profile.index')->withErrors('Profile not found.');
        }

        return view('profile.edit', ['data' => $profile]);
    }

    // Update an existing profile (Update)
    public function update(Request $request, $npm)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048'
        ]);

        $csvFilePath = storage_path('app/public/users.csv');
        $updatedProfiles = [];
        $profileUpdated = false;

        if (file_exists($csvFilePath)) {
            $file = fopen($csvFilePath, 'r');
            while (($row = fgetcsv($file)) !== FALSE) {
                if ($row[1] == $npm) {
                    // Update the profile
                    $row[0] = $request->input('nama');
                    $row[2] = $request->input('kelas');

                    if ($request->hasFile('foto')) {
                        // Delete old photo if exists
                        if (!empty($row[3])) {
                            \Storage::delete('public/photos/' . $row[3]);
                        }
                        $path = $request->file('foto')->store('public/photos');
                        $row[3] = basename($path);
                    }

                    $profileUpdated = true;
                }
                $updatedProfiles[] = $row;
            }
            fclose($file);
        }

        if (!$profileUpdated) {
            return redirect()->route('profile.index')->withErrors('Profile not found.');
        }

        // Save updated profiles back to the CSV
        $file = fopen($csvFilePath, 'w');
        foreach ($updatedProfiles as $profile) {
            fputcsv($file, $profile);
        }
        fclose($file);

        return redirect()->route('profile.index');
    }

    // Delete a profile (Delete)
    public function destroy($npm)
    {
        $csvFilePath = storage_path('app/public/users.csv');
        $updatedProfiles = [];
        $profileDeleted = false;

        if (file_exists($csvFilePath)) {
            $file = fopen($csvFilePath, 'r');
            while (($row = fgetcsv($file)) !== FALSE) {
                if ($row[1] == $npm) {
                    // Delete profile photo
                    if (!empty($row[3])) {
                        \Storage::delete('public/photos/' . $row[3]);
                    }
                    $profileDeleted = true;
                    continue; // Skip this profile (delete)
                }
                $updatedProfiles[] = $row;
            }
            fclose($file);
        }

        if (!$profileDeleted) {
            return redirect()->route('profile.index')->withErrors('Profile not found.');
        }

        // Save remaining profiles back to the CSV
        $file = fopen($csvFilePath, 'w');
        foreach ($updatedProfiles as $profile) {
            fputcsv($file, $profile);
        }
        fclose($file);

        return redirect()->route('profile.index');
    }
}
