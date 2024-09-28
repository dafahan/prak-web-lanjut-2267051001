<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <h1 class="text-3xl mb-6">Edit Kelas</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kelas.update', $kelas->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="nama_kelas" class="block text-sm font-bold mb-2">Nama Kelas</label>
            <input type="text" name="nama_kelas" id="nama_kelas" class="w-full p-2 border border-gray-300 rounded" value="{{ old('nama_kelas', $kelas->nama_kelas) }}">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Kelas</button>
    </form>
</body>
</html>
