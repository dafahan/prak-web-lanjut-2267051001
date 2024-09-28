<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <h1 class="text-3xl mb-6">Profile List</h1>
    <a href="{{ route('profile.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Create New Profile</a>
    <table class="min-w-full bg-white mt-6">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">NPM</th>
                <th class="py-2 px-4 border-b">Kelas</th>
                <th class="py-2 px-4 border-b">Photo</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($profiles as $profile)
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ $profile->nama }}</td> <!-- Profile Name -->
                    <td class="py-2 px-4 border-b text-center">{{ $profile->npm }}</td> <!-- NPM -->
                    <td class="py-2 px-4 border-b text-center">{{ $profile->kelas->nama_kelas }}</td> <!-- Class Name -->
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ asset('storage/photos/'.$profile->foto) }}" class="text-sky-500 hover:italic">View Photo</a>
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('profile.show', $profile->npm) }}" class="bg-blue-500 text-white px-4 py-2 rounded">View</a>
                        <a href="{{ route('profile.edit', $profile->npm) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
                        <form action="{{ route('profile.destroy', $profile->npm) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</body>
</html>
