<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <h1 class="text-3xl mb-6">Kelas List</h1>
    <a href="{{ route('kelas.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Create New Kelas</a>
    <table class="min-w-full bg-white mt-6">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nama Kelas</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelas as $k)
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ $k->nama_kelas }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('kelas.edit', $k->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
                        <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" class="inline">
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
