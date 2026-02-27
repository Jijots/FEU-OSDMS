<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notice to Explain - {{ $violation->student->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            @page {
                size: letter;
                margin: 0.5in;
            }
            html, body {
                background-color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                /* THE FIX: Absolute lockdown on page height. Eradicates the 2nd page. */
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
            }
            .no-print { display: none !important; }

            .print-no-border {
                border-color: transparent !important;
                background-color: transparent !important;
                box-shadow: none !important;
            }

            /* THE FIX: Fixed mathematically to 10 inches (11in paper - 1in margins) */
            .print-fixed-page {
                height: 10in !important;
                position: relative !important;
                display: block !important;
                overflow: hidden !important;
            }

            /* THE FIX: Physically pins the signatures 1.25 inches from the bottom */
            .print-absolute-sigs {
                position: absolute !important;
                bottom: 1.25in !important;
                left: 0 !important;
                width: 100% !important;
                margin-top: 0 !important;
            }

            /* THE FIX: Physically pins the footer to the absolute bottom of the page */
            .print-absolute-footer {
                position: absolute !important;
                bottom: 0 !important;
                left: 0 !important;
                width: 100% !important;
                margin-top: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-slate-200 text-black font-sans antialiased py-10 px-4 print:p-0 print:bg-white overflow-visible">

    <div class="fixed top-8 left-8 no-print bg-blue-50 border-l-4 border-blue-600 p-4 rounded-r-xl shadow-lg max-w-sm z-50 hidden xl:block">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            <div>
                <h3 class="text-sm font-bold text-blue-900">Editable Document Mode</h3>
                <p class="text-xs text-blue-700 mt-1">Click anywhere inside the dashed boxes to personalize the text before saving as a PDF.</p>
            </div>
        </div>
    </div>

    <div class="fixed top-8 right-8 no-print flex flex-col gap-3 z-50">
        <button onclick="window.print()" class="px-6 py-3 bg-[#004d32] text-white font-bold rounded-xl shadow-lg hover:bg-green-800 transition-all flex items-center gap-3 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            1. Save as PDF
        </button>

        <a href="mailto:{{ $violation->student->email }}?subject=Official Notice to Explain (NTE) - Case #{{ str_pad($violation->id, 4, '0', STR_PAD_LEFT) }}&body=Dear {{ $violation->student->name }},%0D%0A%0D%0APlease find attached your official Notice to Explain (NTE) regarding a recent incident report.%0D%0A%0D%0AOffice of Student Discipline"
           class="px-6 py-3 bg-[#0078D4] text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition-all flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            2. Email via Outlook
        </a>

        <a href="https://teams.microsoft.com/l/chat/0/0?users={{ $violation->student->email }}&message=Hello%20{{ urlencode($violation->student->name) }},%20please%20see%20the%20attached%20Notice%20to%20Explain%20(NTE)%20document."
           target="_blank"
           class="px-6 py-3 bg-[#5A5EB9] text-white font-bold rounded-xl shadow-lg hover:bg-[#464aa8] transition-all flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
            3. Send via MS Teams
        </a>

        <button onclick="window.close()" class="px-6 py-2.5 mt-2 bg-white text-slate-600 font-bold border-2 border-slate-300 rounded-xl hover:bg-slate-50 transition-all text-center">
            Close Tab
        </button>
    </div>

    <div class="max-w-[8.5in] w-full mx-auto bg-white p-10 lg:p-12 shadow-2xl border border-gray-200 min-h-[11in] flex flex-col print:shadow-none print:border-none print:m-0 print:p-0 print-fixed-page relative">

        <div class="flex items-center gap-5 border-b-4 border-[#004d32] pb-6 mb-8">
            <img src="{{ asset('images/FEU-Logo.png') }}" alt="FEU Logo" class="w-16 h-16 object-contain shrink-0">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-[#004d32] uppercase tracking-widest leading-none" style="font-family: 'DellaRobiaBT', 'Della Robbia BT', serif;">Far Eastern University</h1>
                <h2 class="text-sm font-bold text-[#FECB02] uppercase tracking-widest mt-1">Office of Student Discipline</h2>
                <p class="text-[10px] text-gray-500 font-sans mt-0.5 tracking-wide">Nicanor Reyes St, Sampaloc, Manila, 1008 Metro Manila</p>
            </div>
        </div>

        <div style="font-family: 'Times New Roman', Times, serif;">
            <div class="mb-5 text-[15px] leading-relaxed text-slate-800">
                <p><strong>Date Issued:</strong> {{ now()->format('F d, Y') }}</p>
                <p><strong>To:</strong> <span class="uppercase">{{ $violation->student->name }}</span> ({{ $violation->student->id_number ?? 'N/A' }})</p>
                <p><strong>Department/Program:</strong> {{ $violation->student->program_code ?? 'N/A' }}</p>

                <p class="mt-5 text-base"><strong>Subject:</strong> <span class="uppercase font-extrabold tracking-wide text-[#004d32] border-b-2 border-[#004d32]">NOTICE TO EXPLAIN (NTE)</span></p>
                <p class="text-xs text-gray-500 leading-tight mt-1" style="font-family: ui-sans-serif, system-ui, sans-serif;">System Reference: CASE-{{ str_pad($violation->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>

            <div contenteditable="true" class="space-y-4 text-[15px] leading-relaxed text-justify text-slate-900 border-2 border-dashed border-blue-200 hover:border-blue-400 p-4 -mx-4 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition-all print-no-border">
                @php
                    $nameParts = explode(' ', $violation->student->name);
                    $lastName = end($nameParts);
                @endphp
                <p>Dear Mr./Ms. <strong>{{ $lastName }}</strong>,</p>

                <p>
                    This office has received an official incident report regarding your alleged violation of university policies as stipulated under the Far Eastern University Student Handbook. The specifics of the recorded incident are detailed below:
                </p>

                <div class="pl-5 border-l-4 border-[#004d32] py-3 my-4 bg-slate-50 pr-5" contenteditable="false">
                    <p class="font-sans text-[13px] sm:text-[14px]"><strong>Date of Record:</strong> {{ $violation->created_at->format('F d, Y - h:i A') }}</p>
                    <p class="font-sans text-[13px] sm:text-[14px] mt-1"><strong>Nature of Offense:</strong> <span class="uppercase font-bold text-red-700">{{ $violation->offense_type }}</span></p>
                    <p class="mt-2 text-slate-700 whitespace-pre-wrap font-sans text-[13px] sm:text-[14px] italic">"{{ $violation->description }}"</p>
                </div>

                <p>
                    In strict adherence to the principles of due process, you are hereby directed to submit a written explanation outlining why no disciplinary sanctions should be imposed against you concerning this matter.
                </p>

                <p>
                    Please submit your written response (duly signed) to the Investigating Officer at the Office of Student Discipline within <strong>Seventy-Two (72) hours</strong> from the receipt of this formal notice. Failure to submit an explanation within the specified timeframe will be officially construed as a waiver of your right to be heard.
                </p>

                <p class="mt-4">
                    For your strict compliance.
                </p>
            </div>
        </div>

        <div class="mt-16 print-absolute-sigs text-[15px] flex justify-between break-inside-avoid" style="font-family: 'Times New Roman', Times, serif;">
            <div class="w-[45%]">
                <div class="border-b border-black w-full mb-2"></div>
                <p class="font-extrabold text-[#004d32] uppercase leading-tight">{{ $violation->reporter->name ?? 'Discipline Officer' }}</p>
                <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wide mt-1" style="font-family: ui-sans-serif, system-ui, sans-serif;">Investigating Officer</p>
            </div>
            <div class="w-[45%]">
                <div class="border-b border-black w-full mb-2"></div>
                <p class="font-extrabold text-[#004d32] uppercase leading-tight">Student Signature</p>
                <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wide mt-1" style="font-family: ui-sans-serif, system-ui, sans-serif;">Received By / Date</p>
            </div>
        </div>

        <div class="mt-auto print-absolute-footer pt-4 border-t border-gray-200 text-center text-[9px] sm:text-[10px] text-gray-400 font-sans uppercase tracking-[0.2em] break-inside-avoid">
            Generated by FEU-OSDMS Intelligence Protocol v2026 | Document Hash: {{ uniqid() }}
        </div>
    </div>

</body>
</html>
