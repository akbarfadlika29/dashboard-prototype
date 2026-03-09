<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 30px;
    }

    .dashboard-title {
        text-align: center;
        margin-bottom: 30px;
    }

    .dashboard-title h1 {
        margin: 0;
        font-size: 26px;
        color: #2c3e50;
        font-weight: 600;
    }

    .dashboard-title p {
        margin-top: 5px;
        color: #7f8c8d;
        font-size: 14px;
    }

    /* === GRID 3 KOLOM === */
    .row {
        display: flex;
        gap: 20px;
    }

    .chart-box {
        flex: 1;
        background: #ffffff;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        transition: 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .chart-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 22px rgba(0,0,0,0.08);
    }

    .chart-title {
        font-size: 15px;
        font-weight: 600;
        color: #34495e;
        margin-bottom: 15px;
        text-align: center;
    }

    /* Supaya chart tidak mengecil */
    .chart-box canvas {
        height: 320px !important;
        width: 100% !important;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .row {
            flex-direction: column;
        }
    }
</style>

<div class="dashboard-title">
    <h1>Dashboard Statistik Kemenag Tuban</h1>
    <p>Visualisasi Data dan Informasi Strategis Kementerian Agama Kabupaten Tuban</p>
</div>

<div class="row">

    <div class="chart-box">
        <div class="chart-title">Top Kecamatan Peristiwa Nikah 2025</div>
        <canvas id="chartKecamatan"></canvas>
    </div>

    <div class="chart-box">
        <div class="chart-title">Tren Peristiwa Nikah 5 Tahun Terakhir</div>
        <canvas id="chartTren"></canvas>
    </div>

    <div class="chart-box">
        <div class="chart-title">Komposisi Penduduk Berdasarkan Agama</div>
        <canvas id="chartAgama"></canvas>
    </div>

</div>

<script>
let chartKecamatan, chartTren, chartAgama;

async function loadData() {
    const response = await fetch('/dashboard/data');
    const data = await response.json();

    const charts = data.charts;

    // 1️⃣ Horizontal Bar - Top Kecamatan
    chartKecamatan = new Chart(
        document.getElementById('chartKecamatan'),
        {
            type: 'bar',
            data: {
                labels: charts.top_kecamatan.labels,
                datasets: [{
                    label: 'Jumlah Nikah 2025',
                    data: charts.top_kecamatan.values,
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        }
    );

    // 2️⃣ Line Chart - Tren 5 Tahun
    chartTren = new Chart(
        document.getElementById('chartTren'),
        {
            type: 'line',
            data: {
                labels: charts.tren_nikah.labels,
                datasets: [{
                    label: 'Peristiwa Nikah',
                    data: charts.tren_nikah.values,
                    tension: 0.3,
                    fill: false,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        }
    );

    // 3️⃣ Doughnut Chart - Agama
    chartAgama = new Chart(
        document.getElementById('chartAgama'),
        {
            type: 'doughnut',
            data: {
                labels: charts.agama.labels,
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: charts.agama.values,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '60%'
            }
        }
    );
}

loadData();
</script>