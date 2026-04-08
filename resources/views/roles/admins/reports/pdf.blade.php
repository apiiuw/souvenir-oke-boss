<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin-bottom: 5px; color: #ec4899; }
        .header p { color: #666; font-size: 14px; margin-top: 0; }
        
        .summary-box { 
            background: #fdf2f8; 
            padding: 20px; 
            border-radius: 10px; 
            margin-bottom: 30px;
            border: 1px solid #fbcfe8;
        }
        .summary-box table { width: 100%; }
        .summary-box td { padding: 5px; }
        .summary-label { color: #666; text-transform: uppercase; font-size: 10px; font-weight: bold; }
        .summary-value { font-size: 18px; font-weight: bold; color: #333; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #f9fafb; padding: 10px; text-align: left; border-bottom: 2px solid #eee; font-size: 10px; text-transform: uppercase; color: #999; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        
        .status-badge { 
            font-size: 9px; 
            padding: 2px 8px; 
            border-radius: 10px; 
            text-transform: uppercase; 
            font-weight: bold;
        }
        .text-right { text-align: right; }
        .text-pink { color: #ec4899; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #aaa; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penjualan</h1>
        <p>Souvenir Oke Boss</p>
        <div style="font-size: 11px; color: #999; margin-top: 5px;">
            Periode: {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}
        </div>
    </div>

    <div class="summary-box">
        <table>
            <tr>
                <td>
                    <div class="summary-label">Total Pendapatan</div>
                    <div class="summary-value" style="color: #ec4899;">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
                </td>
                <td>
                    <div class="summary-label">Total Pesanan</div>
                    <div class="summary-value">{{ $orders->count() }}</div>
                </td>
                <td>
                    <div class="summary-label">Item Terjual</div>
                    <div class="summary-value">{{ $orders->sum('total_qty') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>Pelanggan</th>
                <th>Jumlah</th>
                <th class="text-right">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td style="font-weight: bold;">#{{ $order->order_code }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->total_qty }} pcs</td>
                <td class="text-right text-pink">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }} | Laporan Sistem Souvenir Oke Boss
    </div>
</body>
</html>
