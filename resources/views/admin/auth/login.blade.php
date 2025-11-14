<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-semibold mb-5 text-center">Admin Login</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-600 px-3 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-gray-700">Email</label>
                <input type="email" name="email"
                       required
                       class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-blue-300"/>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700">Password</label>
                <input type="password" name="password"
                       required
                       class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-blue-300"/>
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Login
            </button>
        </form>

    </div>

</body>
</html>
