<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Edit Transaksi</h1>
            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="type" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Transaksi</label>
                    <select id="type" name="type" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition duration-200 shadow-sm {{ $errors->has('type') ? 'border-red-500 focus:border-red-600 focus:ring-red-600' : '' }}">
                        <option value="">Pilih jenis</option>
                        <option value="income" {{ old('type', $transaction->type) === 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ old('type', $transaction->type) === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="amount" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Nominal</label>
                    <input id="amount" name="amount" type="number" step="0.01" min="0" value="{{ old('amount', $transaction->amount) }}" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition duration-200 shadow-sm {{ $errors->has('amount') ? 'border-red-500 focus:border-red-600 focus:ring-red-600' : '' }}" placeholder="Contoh: 100000">
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                    <input id="description" name="description" type="text" value="{{ old('description', $transaction->description) }}" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition duration-200 shadow-sm {{ $errors->has('description') ? 'border-red-500 focus:border-red-600 focus:ring-red-600' : '' }}" placeholder="Contoh: Donasi Jumat">
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="date" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                    <input id="date" name="date" type="date" value="{{ old('date', \Illuminate\Support\Carbon::parse($transaction->date)->format('Y-m-d')) }}" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition duration-200 shadow-sm {{ $errors->has('date') ? 'border-red-500 focus:border-red-600 focus:ring-red-600' : '' }}">
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md bg-gray-200 dark:bg-gray-700 px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition">Kembali</a>
                    <button type="submit" class="inline-flex items-center rounded-md bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">Update</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>
