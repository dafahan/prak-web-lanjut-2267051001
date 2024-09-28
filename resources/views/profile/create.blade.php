<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <h1 class="text-3xl mb-6">Create Profile</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
        @csrf
        <div class="mb-4">
            <label for="nama" class="block text-sm font-bold mb-2">Nama</label>
            <input type="text" name="nama" id="nama" class="w-full p-2 border border-gray-300 rounded" value="{{ old('nama') }}">
        </div>

        <div class="mb-4">
            <label for="npm" class="block text-sm font-bold mb-2">NPM</label>
            <input type="text" name="npm" id="npm" class="w-full p-2 border border-gray-300 rounded" value="{{ old('npm') }}">
        </div>

        <div class="mb-4">
            <label for="kelas_id" class="block text-sm font-bold mb-2">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="w-full p-2 border border-gray-300 rounded">
                <option value="">Select a class</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }} <!-- assuming 'name' is the class name column -->
                    </option>
                @endforeach
            </select>
        </div>


        <div class="mb-4">
            <label for="foto" class="block text-sm font-bold mb-2">Photo</label>
            <input type="file" name="foto" id="foto" class="w-full p-2 border border-gray-300 rounded">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Create Profile</button>
    </form>
</body>
</html>
