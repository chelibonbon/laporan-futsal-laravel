<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 14px;
            color: #666;
        }
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        .summary-item {
            display: inline-block;
            margin-right: 30px;
        }
        .summary-label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KEUANGAN</h1>
        <p>Periode: 
            @if($start && $end)
                {{ $start }} s/d {{ $end }}
            @else
                Semua Data
            @endif
        </p>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total Pendapatan:</span> 
            Rp {{ number_format($totalIncome, 0, ',', '.') }}
        </div>
        <div class="summary-item">
            <span class="summary-label">Jumlah Transaksi:</span> 
            {{ $payments->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Tanggal</th>
                <th>Kode Booking</th>
                <th>Customer</th>
                <th>Lapangan</th>
                <th class="text-center">Jam</th>
                <th class="text-right">Total</th>
                <th class="text-center">Status</th>
                <th class="text-center">Payment</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $index => $payment)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td>BK{{ str_pad($payment->booking_id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $payment->booking->user->name ?? 'Unknown' }}</td>
                    <td>{{ $payment->booking->lapangan->nama ?? 'Unknown' }}</td>
                    <td class="text-center">
                        @if($payment->booking->jam_mulai && $payment->booking->jam_selesai)
                            {{ \Carbon\Carbon::parse($payment->booking->jam_mulai)->format('H:i') }}-{{ \Carbon\Carbon::parse($payment->booking->jam_selesai)->format('H:i') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                    <td class="text-center">{{ ucfirst($payment->booking->status ?? '') }}</td>
                    <td class="text-center">{{ ucfirst($payment->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
        @if($payments->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right"><strong>TOTAL:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalIncome, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis dari sistem booking futsal</p>
    </div>
</body>
</html>
