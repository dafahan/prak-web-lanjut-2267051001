<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <!-- Profile Photo -->
            <div class="flex justify-center mb-6">
                @if (!empty($data->foto))
                    <img src="{{ asset('storage/photos/' . $data->foto) }}" alt="Profile Photo" class="rounded-full w-32 h-32 object-cover">
                @else
                    <img src="https://via.placeholder.com/150" alt="Placeholder" class="rounded-full w-32 h-32 object-cover">
                @endif
            </div>

            <!-- Profile Information -->
            <h2 class="text-2xl font-bold mb-2">{{ $data->nama }}</h2>
            <p class="text-gray-600">NPM: {{ $data->npm }}</p>
            <p class="text-gray-600">Kelas: {{ $data->kelas->nama_kelas }}</p>

            <!-- Action Buttons -->
            <div class="mt-4">
                <a href="{{ route('profile.edit', $data->npm) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit Profile</a>
                <form action="{{ route('profile.destroy', $data->npm) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
