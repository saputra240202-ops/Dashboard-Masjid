<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Dashboard Keuangan Masjid</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-gray-800 dark:text-gray-200">
        @if (session('success'))
            <div class="mb-6 flex items-start justify-between rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 shadow">
                <div class="pr-4">{{ session('success') }}</div>
                <button type="button" class="rounded-md px-2 py-1 text-emerald-700 hover:bg-emerald-100" onclick="this.parentElement.remove()">Tutup</button>
            </div>
        @endif
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                {{ $isPublic ? 'Laporan Keuangan Publik' : 'Dashboard Keuangan' }}
            </h1>
            <div class="flex items-center gap-3">
                <button id="themeToggle" type="button" class="rounded-full px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 transition">☀</button>
                @if (!$isPublic)
                    @auth
                        @if (in_array(auth()->user()->role, ['admin','bendahara']))
                            <a href="{{ route('transactions.create') }}" class="inline-flex items-center rounded-xl bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">Tambah Transaksi</a>
                            <a href="{{ route('transactions.export.pdf') }}" target="_blank" class="inline-flex items-center rounded-xl bg-red-600 px-4 py-2 text-white hover:bg-red-700">Export PDF</a>
                        @endif
                    @endauth
                @endif
                @if (!$isPublic)
                    @auth
                    <div x-data="{ open: false }" class="relative">
                        <button
                            @click="open = !open"
                            :aria-expanded="open.toString()"
                            aria-haspopup="true"
                            title="{{ Auth::user()->name }}"
                            class="flex items-center justify-center h-9 w-9 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 16.5a3.75 3.75 0 017.5 0v.75" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg py-2 z-50">
                            <div class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300">
                                Role: {{ Auth::user()->role }}
                            </div>
                            @if (Route::has('profile.edit'))
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Profile
                            </a>
                            @endif
                            @if (Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400">
                                    Logout
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endauth
                @endif
            </div>
        </div>
        @if (!$isPublic)
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <form method="GET" action="{{ route('dashboard') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bulan</label>
                            <select id="month" name="month" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 focus:border-blue-600 focus:ring-blue-600">
                                <option value="">Pilih bulan</option>
                                <option value="1"  {{ request('month') == '1'  ? 'selected' : '' }}>Januari</option>
                                <option value="2"  {{ request('month') == '2'  ? 'selected' : '' }}>Februari</option>
                                <option value="3"  {{ request('month') == '3'  ? 'selected' : '' }}>Maret</option>
                                <option value="4"  {{ request('month') == '4'  ? 'selected' : '' }}>April</option>
                                <option value="5"  {{ request('month') == '5'  ? 'selected' : '' }}>Mei</option>
                                <option value="6"  {{ request('month') == '6'  ? 'selected' : '' }}>Juni</option>
                                <option value="7"  {{ request('month') == '7'  ? 'selected' : '' }}>Juli</option>
                                <option value="8"  {{ request('month') == '8'  ? 'selected' : '' }}>Agustus</option>
                                <option value="9"  {{ request('month') == '9'  ? 'selected' : '' }}>September</option>
                                <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                                <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>Desember</option>
                            </select>
                        </div>
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun</label>
                            <select id="year" name="year" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 focus:border-blue-600 focus:ring-blue-600">
                                <option value="">Pilih tahun</option>
                                @php $currentYear = date('Y'); @endphp
                                @for ($y = $currentYear; $y >= $currentYear - 5; $y--)
                                    <option value="{{ $y }}" {{ request('year') == (string) $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex items-end gap-3 md:col-span-2">
                            <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Filter</button>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md bg-gray-200 dark:bg-gray-700 px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 border-l-4 border-blue-500">
                <i class="fas fa-wallet fa-2x text-blue-600 mb-4"></i>
                <div class="text-sm text-gray-500 dark:text-gray-300">Saldo</div>
                <div class="mt-2 text-2xl font-semibold text-blue-700">{{ 'Rp ' . number_format($balance, 0, ',', '.') }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 border-l-4 border-green-500">
                <i class="fas fa-arrow-trend-up fa-2x text-green-600 mb-4"></i>
                <div class="text-sm text-gray-500 dark:text-gray-300">Total Pemasukan</div>
                <div class="mt-2 text-2xl font-semibold text-green-700">{{ 'Rp ' . number_format($income, 0, ',', '.') }}</div>
                <div class="mt-2 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ 'Bulan ini: Rp ' . number_format($currentIncome, 0, ',', '.') }}</div>
                @if ($incomePercentage > 0)
                    <div class="mt-1 text-sm font-semibold text-green-700">↑ {{ number_format(abs($incomePercentage), 2, ',', '.') }}% dari bulan lalu</div>
                @elseif ($incomePercentage < 0)
                    <div class="mt-1 text-sm font-semibold text-red-700">↓ {{ number_format(abs($incomePercentage), 2, ',', '.') }}% dari bulan lalu</div>
                @else
                    <div class="mt-1 text-sm font-semibold text-gray-500 dark:text-gray-300">0,00% dari bulan lalu</div>
                @endif
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 border-l-4 border-red-500">
                <i class="fas fa-cart-shopping fa-2x text-red-600 mb-4"></i>
                <div class="text-sm text-gray-500 dark:text-gray-300">Total Pengeluaran</div>
                <div class="mt-2 text-2xl font-semibold text-red-700">{{ 'Rp ' . number_format($expense, 0, ',', '.') }}</div>
                <div class="mt-2 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ 'Bulan ini: Rp ' . number_format($currentExpense, 0, ',', '.') }}</div>
                @if ($expensePercentage > 0)
                    <div class="mt-1 text-sm font-semibold text-green-700">↑ {{ number_format(abs($expensePercentage), 2, ',', '.') }}% dari bulan lalu</div>
                @elseif ($expensePercentage < 0)
                    <div class="mt-1 text-sm font-semibold text-red-700">↓ {{ number_format(abs($expensePercentage), 2, ',', '.') }}% dari bulan lalu</div>
                @else
                    <div class="mt-1 text-sm font-semibold text-gray-500 dark:text-gray-300">0,00% dari bulan lalu</div>
                @endif
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 border-l-4 border-gray-500 dark:border-gray-700">
                <i class="fas fa-receipt fa-2x text-gray-600 mb-4"></i>
                <div class="text-sm text-gray-500 dark:text-gray-300">Jumlah Transaksi</div>
                <div class="mt-2 text-2xl font-semibold text-gray-700 dark:text-gray-300">{{ number_format($count, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 flex flex-col hover:shadow-lg transition duration-300">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Grafik Keuangan</h2>
                <div class="relative h-80">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 flex flex-col hover:shadow-lg transition duration-300">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tren Keuangan 6 Bulan Terakhir</h2>
                <div class="relative h-80">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>

        <div class="mt-10 bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Transaksi Terbaru</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jenis</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nominal</th>
                            @if (!$isPublic)
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($latest as $t)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ \Illuminate\Support\Carbon::parse($t->date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $t->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $t->type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $t->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $t->type === 'income' ? 'text-green-700' : 'text-red-700' }}">
                                    {{ 'Rp ' . number_format($t->amount, 0, ',', '.') }}
                                </td>
                                @if (!$isPublic)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        @auth
                                            @if (in_array(auth()->user()->role, ['admin','bendahara']))
                                                <a href="{{ route('transactions.edit', $t->id) }}" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1 text-white hover:bg-blue-700 mr-2">Edit</a>
                                            @endif
                                            @if (auth()->user()->role === 'admin')
                                                <form action="{{ route('transactions.destroy', $t->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus transaksi ini?')" class="inline-flex items-center rounded-md bg-red-500 px-3 py-1 text-white hover:bg-red-600">Hapus</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-300">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const toggleBtn = document.getElementById('themeToggle');
        const htmlEl = document.documentElement;
        if (localStorage.getItem('theme') === 'dark') {
            htmlEl.classList.add('dark');
            toggleBtn.textContent = '🌙';
        } else {
            toggleBtn.textContent = '☀';
        }
        function getAxisColors() {
            const isDark = htmlEl.classList.contains('dark');
            return {
                grid: isDark ? 'rgba(75, 85, 99, 0.3)' : 'rgba(156, 163, 175, 0.2)',
                ticks: isDark ? '#e5e7eb' : '#374151'
            };
        }
        const income = {{ $income }};
        const expense = {{ $expense }};
        const ctx = document.getElementById('financeChart');
        const axisColorsInitial = getAxisColors();
        const financeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    label: 'Total',
                    data: [income, expense],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(239, 68, 68, 0.7)'
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { ticks: { color: axisColorsInitial.ticks }, grid: { color: axisColorsInitial.grid } },
                    y: { beginAtZero: true, ticks: { color: axisColorsInitial.ticks }, grid: { color: axisColorsInitial.grid } }
                }
            }
        });

        const trendCtx = document.getElementById('trendChart');
        const trendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($chartIncome) !!},
                        borderColor: 'rgba(16, 185, 129, 1)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($chartExpense) !!},
                        borderColor: 'rgba(239, 68, 68, 1)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    x: { ticks: { color: axisColorsInitial.ticks }, grid: { color: axisColorsInitial.grid } },
                    y: { beginAtZero: true, ticks: { color: axisColorsInitial.ticks }, grid: { color: axisColorsInitial.grid } }
                }
            }
        });
        toggleBtn.addEventListener('click', () => {
            htmlEl.classList.toggle('dark');
            if (htmlEl.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                toggleBtn.textContent = '🌙';
            } else {
                localStorage.setItem('theme', 'light');
                toggleBtn.textContent = '☀';
            }
            const c = getAxisColors();
            financeChart.options.scales.x.ticks.color = c.ticks;
            financeChart.options.scales.x.grid.color = c.grid;
            financeChart.options.scales.y.ticks.color = c.ticks;
            financeChart.options.scales.y.grid.color = c.grid;
            financeChart.update();
            trendChart.options.scales.x.ticks.color = c.ticks;
            trendChart.options.scales.x.grid.color = c.grid;
            trendChart.options.scales.y.ticks.color = c.ticks;
            trendChart.options.scales.y.grid.color = c.grid;
            trendChart.update();
        });
    </script>
</body>
</html>
