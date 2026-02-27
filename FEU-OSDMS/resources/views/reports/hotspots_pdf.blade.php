<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; margin: 30px; }
        .header { border-bottom: 4px solid #004d32; padding-bottom: 20px; margin-bottom: 30px; }
        .university-name { font-size: 24px; font-weight: bold; color: #004d32; text-transform: uppercase; }
        .report-title { font-size: 18px; color: #666; margin-top: 5px; }
        .meta { margin-bottom: 40px; font-size: 12px; color: #888; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background-color: #f8fafc; color: #64748b; text-align: left; padding: 12px; border-bottom: 2px solid #e2e8f0; font-size: 11px; text-transform: uppercase; }
        td { padding: 15px 12px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }

        .rank { font-weight: bold; color: #004d32; width: 40px; }
        .location { font-weight: bold; color: #1e293b; }
        .total-badge { background-color: #f1f5f9; padding: 4px 10px; border-radius: 4px; font-weight: bold; font-size: 12px; }

        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #999; padding-top: 20px; border-top: 1px solid #eee; }
    </style>
</head>
<body>

    <div class="header">
        <div class="university-name">Far Eastern University</div>
        <div class="report-title">{{ $title }}</div>
    </div>

    <div class="meta">
        Generated on: <strong>{{ $date }}</strong><br>
        Department: Office of Student Discipline (OSDMS)
    </div>

    <table>
        <thead>
            <tr>
                <th class="rank">Rank</th>
                <th>Location / Site</th>
                <th style="text-align: right;">Total Frequency</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            <tr>
                <td class="rank">#{{ $index + 1 }}</td>
                <td class="location">{{ $item->location }}</td>
                <td style="text-align: right;">
                    <span class="total-badge">{{ $item->total }} Records</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Confidential Document • FEU-OSD Management System • Page 1 of 1
    </div>

</body>
</html>
