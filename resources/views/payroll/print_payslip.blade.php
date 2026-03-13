<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payslip Print</title>
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
            color: #4f46e5;
            background: #e0e7ff;
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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        .breakdown-col {
            display: flex;
            flex-direction: column;
        }
        .b-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 6px;
        }
        .b-title.earnings { color: #166534; border-color: #dcfce3; }
        .b-title.deductions { color: #991b1b; border-color: #fee2e2; }

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

        .total-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
            margin-top: auto;
            border-top: 1px solid #e5e7eb;
            font-size: 13px;
            font-weight: 600;
        }

        /* Grand Total */
        .grand-total-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            /* Start a new page every 4 payslips (2 rows of 2) */
            .payslip-card:nth-child(4n) {
                page-break-after: always;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="payslip-grid">

        @foreach($payrolls as $p)
            <div class="payslip-card">

                <div class="ps-header">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ asset('images/Picture1.png') }}" alt="Logo" style="height: 48px; width: auto; object-contain;">
                        <div>
                            <div class="ps-brand">DCJ's Construction Services</div>
                            <div class="ps-title">Employee Payslip</div>
                        </div>
                    </div>
                    <div class="ps-period">
                        {{ \Carbon\Carbon::parse($start)->format('M d') }} - {{ \Carbon\Carbon::parse($end)->format('M d, Y') }}
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
                    
                    <!-- Earnings -->
                    <div class="breakdown-col">
                        <div class="b-title earnings">Earnings</div>
                        
                        <div class="line-item">
                            <span class="l-label">Overtime</span>
                            <span class="l-amount">{{ number_format($p['ot_pay'], 2) }}</span>
                        </div>
                        <div class="line-item">
                            <span class="l-label">Night Differential</span>
                            <span class="l-amount">{{ number_format($p['night_diff_pay'] ?? 0, 2) }}</span>
                        </div>
                        
                        <div class="total-item" style="color:#166534">
                            <span>Gross Pay</span>
                            <span>₱ {{ number_format($p['gross_pay'], 2) }}</span>
                        </div>
                    </div>

                    <!-- Deductions -->
                    <div class="breakdown-col">
                        <div class="b-title deductions">Deductions</div>
                        
                        <div class="line-item">
                            <span class="l-label">SSS</span>
                            <span class="l-amount">{{ number_format($p['employee']->sss_amount ?? 0, 2) }}</span>
                        </div>
                        <div class="line-item">
                            <span class="l-label">PhilHealth</span>
                            <span class="l-amount">{{ number_format($p['employee']->philhealth_amount ?? 0, 2) }}</span>
                        </div>
                        <div class="line-item">
                            <span class="l-label">HDMF</span>
                            <span class="l-amount">{{ number_format($p['employee']->hdmf_amount ?? 0, 2) }}</span>
                        </div>
                        <div class="line-item">
                            <span class="l-label">Others</span>
                            <span class="l-amount">{{ number_format($p['employee']->other_deductions ?? 0, 2) }}</span>
                        </div>

                        <div class="total-item" style="color:#991b1b">
                            <span>Total Ded.</span>
                            <span>₱ {{ number_format($p['total_deductions'], 2) }}</span>
                        </div>
                    </div>

                </div>

                <div class="grand-total-box">
                    <span class="gt-label">Net Pay</span>
                    <span class="gt-val">₱ {{ number_format($p['net_pay'], 2) }}</span>
                </div>

                <div style="margin-top: 24px; text-align: center; font-size: 10px; color: #9ca3af;">
                    This is a highly confidential document. Generated on {{ now()->format('M d, Y h:i A') }}
                </div>

            </div>
        @endforeach

    </div>

</body>
</html>