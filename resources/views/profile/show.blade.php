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
                @if (!empty($data[3]))
                    <img src="{{ asset('storage/photos/' . $data[3]) }}" alt="Profile Photo" class="rounded-full w-32 h-32 object-cover">
                @else
                    <img src="https://via.placeholder.com/150" alt="Placeholder" class="rounded-full w-32 h-32 object-cover">
                @endif
            </div>

            <!-- Profile Info -->
            <div class="space-y-4">
                <div class="bg-gray-300 py-2 rounded text-lg font-semibold">
                    <p>Nama: {{ $data[0] }}</p>
                </div>

                <div class="bg-gray-300 py-2 rounded text-lg font-semibold">
                    <p>Kelas: {{ $data[2] }}</p>
                </div>

                <div class="bg-gray-300 py-2 rounded text-lg font-semibold">
                    <p>NPM: {{ $data[1] }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-center space-x-4">
                <a href="{{ route('profile.edit', $data[1]) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit Profile</a>
                <form action="{{ route('profile.destroy', $data[1]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
