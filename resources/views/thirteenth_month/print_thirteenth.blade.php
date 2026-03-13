<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>13th Month Payslip Print</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        /* Reset and Base */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #1f2937;
        }

        body {
            padding: 24px;
            background-color: #f9fafb;
        }

        .page {
            page-break-after: always;
        }

        /* Container & Layout */
        .payslip-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            width: 100%;
        }

        .payslip-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            /* Prevent breaking inside */
            page-break-inside: avoid;
            position: relative;
        }

        /* Header */
        .ps-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .ps-brand {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.02em;
        }
        .ps-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #6b7280;
            font-weight: 600;
            margin-top: 4px;
        }
        .ps-period {
            font-size: 12px;
            font-weight: 500;
            color: #10b981;
            background: #d1fae5;
            padding: 4px 10px;
            border-radius: 999px;
        }

        /* Employee Info */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
        }
        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #6b7280;
            font-weight: 600;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }
        .info-val {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
        }

        /* Tables */
        .breakdown-section {
            display: flex;
            flex-direction: column;
            margin-bottom: 24px;
        }
        .b-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 1px solid #dcfce3;
            padding-bottom: 6px;
            color: #166534;
        }

        .line-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            font-size: 12px;
            border-bottom: 1px dashed #f3f4f6;
        }
        .line-item:last-child {
            border-bottom: none;
        }
        .l-label { color: #4b5563; }
        .l-amount { font-weight: 500; color: #111827; }

        /* Grand Total */
        .grand-total-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .gt-label {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
        }
        .gt-val {
            font-size: 20px;
            font-weight: 800;
            color: #059669; /* Emerald 600 */
        }

        /* Print Specific */
        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .payslip-grid {
                gap: 20px;
            }
            .payslip-card {
                border-color: #e5e7eb;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body onload="window.print()">

    @foreach($thirteenth->chunk(4) as $chunk)
        <div class="page">
            <div class="payslip-grid">

                @foreach($chunk as $p)
                    <div class="payslip-card">

                        <div class="ps-header">
                            <div>
                                <div class="ps-brand">{{ $companyName ?? "DCJ's Construction Services" }}</div>
                                <div class="ps-title">13th Month Report</div>
                            </div>
                            <div class="ps-period">
                                Year {{ $p['year'] }}
                            </div>
                        </div>

                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Employee details</span>
                                <span class="info-val">{{ $p['employee']->full_name }}</span>
                                <span class="info-val" style="color: #6b7280; font-size: 11px; margin-top:2px;">ID: #{{ str_pad($p['employee']->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Basic Rate / Day</span>
                                <span class="info-val">₱ {{ number_format($p['employee']->basic_rate, 2) }}</span>
                            </div>
                        </div>

                        <div class="breakdown-section">
                            <div class="b-title earnings">Earnings</div>
                            
                            <div class="line-item">
                                <span class="l-label">13th Month Pay Amount</span>
                                <span class="l-amount">₱ {{ number_format($p['thirteenth_month'], 2) }}</span>
                            </div>
                        </div>

                        <div class="grand-total-box">
                            <span class="gt-label">Net Allowance</span>
                            <span class="gt-val">₱ {{ number_format($p['thirteenth_month'], 2) }}</span>
                        </div>

                        <div style="margin-top: 24px; text-align: center; font-size: 10px; color: #9ca3af;">
                            Confidential document. Generated on {{ now()->format('M d, Y h:i A') }}
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    @endforeach

</body>
</html>