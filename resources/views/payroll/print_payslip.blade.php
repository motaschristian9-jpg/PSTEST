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
            padding: 10px;
            background-color: #f9fafb;
        }

        /* Container & Layout */
        .payslip-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            width: 100%;
        }

        .payslip-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            /* Prevent breaking inside */
            page-break-inside: avoid;
            position: relative;
            height: fit-content;
        }

        /* Header */
        .ps-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }
        .ps-brand {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.01em;
        }
        .ps-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            font-weight: 600;
        }
        .ps-period {
            font-size: 11px;
            font-weight: 600;
            color: #4f46e5;
            background: #e0e7ff;
            padding: 3px 10px;
            border-radius: 999px;
        }

        /* Employee Info */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 10px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
        }
        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #6b7280;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 3px;
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
            gap: 15px;
            margin-bottom: 12px;
        }
        .breakdown-col {
            display: flex;
            flex-direction: column;
        }
        .b-title {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin-bottom: 6px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 4px;
        }
        .b-title.earnings { color: #166534; border-color: #dcfce3; }
        .b-title.deductions { color: #991b1b; border-color: #fee2e2; }

        .line-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
            font-size: 11px;
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
            padding-top: 6px;
            margin-top: auto;
            border-top: 1px solid #e5e7eb;
            font-size: 11px;
            font-weight: 700;
        }

        /* Grand Total */
        .grand-total-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 12px;
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
            font-size: 18px;
            font-weight: 800;
            color: #059669; /* Emerald 600 */
        }

        /* Print Specific */
        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
                margin: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .payslip-grid {
                gap: 5mm;
                padding: 10mm 5mm;
                height: auto;
                grid-template-rows: auto auto;
            }
            .payslip-card {
                border: 1px solid #d1d5db;
                height: auto;
                padding: 12px;
                display: flex;
                flex-direction: column;
                margin-bottom: 0;
            }
            /* Start a new page every 4 payslips (2x2 grid) */
            .payslip-grid:not(:first-child) {
                page-break-before: always;
            }
        }
    </style>
</head>
<body onload="window.print()">

    @foreach(collect($payrolls)->chunk(4) as $chunk)
        <div class="payslip-grid">
            @foreach($chunk as $p)
                <div class="payslip-card">

                    <div class="ps-header">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <img src="{{ asset('images/Picture1.png') }}" alt="Logo" style="height: 32px; width: auto; object-contain;">
                            <div>
                                <div class="ps-brand">DCJ's Construction</div>
                                <div class="ps-title">Payslip</div>
                            </div>
                        </div>
                        <div class="ps-period">
                            {{ \Carbon\Carbon::parse($start)->format('M d') }} - {{ \Carbon\Carbon::parse($end)->format('M d, Y') }}
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Employee</span>
                            <span class="info-val">{{ $p['employee']->full_name }}</span>
                            <span class="info-val" style="color: #6b7280; font-size: 9px; margin-top:1px;">ID: #{{ str_pad($p['employee']->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Daily Rate</span>
                            <span class="info-val">₱ {{ number_format($p['employee']->basic_rate, 2) }}</span>
                        </div>
                    </div>

                    <div class="breakdown-section">
                        
                        <!-- Earnings -->
                        <div class="breakdown-col">
                            <div class="b-title earnings">Earnings</div>
                            
                            <div class="line-item">
                                <span class="l-label">Basic Pay</span>
                                <span class="l-amount">{{ number_format($p['basic_pay'], 2) }}</span>
                            </div>
                            <div class="line-item">
                                <span class="l-label">Overtime</span>
                                <span class="l-amount">{{ number_format($p['ot_pay'], 2) }}</span>
                            </div>
                            <div class="line-item">
                                <span class="l-label">ND Pay</span>
                                <span class="l-amount">{{ number_format($p['night_diff_pay'] ?? 0, 2) }}</span>
                            </div>

                            <div class="line-item">
                                <span class="l-label">Allowance</span>
                                <span class="l-amount">{{ number_format($p['allowance'] ?? 0, 2) }}</span>
                            </div>
                            <div class="line-item">
                                <span class="l-label">Accommodation</span>
                                <span class="l-amount">{{ number_format($p['accommodation'] ?? 0, 2) }}</span>
                            </div>
                            <div class="line-item">
                                <span class="l-label">Load Allowance</span>
                                <span class="l-amount">{{ number_format($p['load_allowance'] ?? 0, 2) }}</span>
                            </div>
                            <div class="line-item">
                                <span class="l-label">Travel Allowance</span>
                                <span class="l-amount">{{ number_format($p['travel_allowance'] ?? 0, 2) }}</span>
                            </div>
                            
                            <div class="total-item" style="color:#166534">
                                <span>Gross</span>
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
                                <span class="l-label">HDMF (Pag-ibig)</span>
                                <span class="l-amount">{{ number_format($p['employee']->hdmf_amount ?? 0, 2) }}</span>
                            </div>
                            <div class="line-item">
                                <span class="l-label">Others</span>
                                <span class="l-amount">{{ number_format($p['employee']->other_deductions ?? 0, 2) }}</span>
                            </div>

                            <div class="total-item" style="color:#991b1b">
                                <span>Ded.</span>
                                <span>₱ {{ number_format($p['total_deductions'], 2) }}</span>
                            </div>
                        </div>

                    </div>

                    <div class="grand-total-box">
                        <span class="gt-label">NET PAY</span>
                        <span class="gt-val">₱ {{ number_format($p['net_pay'], 2) }}</span>
                    </div>

                    <div style="margin-top: 10px; text-align: center; font-size: 8px; color: #9ca3af;">
                        Confidential. Generated: {{ now()->format('M d, Y h:i A') }}
                    </div>

                </div>
            @endforeach
        </div>
    @endforeach

</body>
</html>