<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notice to Explain - {{ $violation->student->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            @page { margin: 1in; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background-color: white !important; }
            /* Hides buttons and helper banners when printing */
            .no-print { display: none !important; }
            /* Removes the visual edit borders on the physical paper */
            .print-no-border { border: none !important; padding: 0 !important; background: transparent !important; }
        }
    </style>
</head>
<body class="bg-slate-200 text-black font-serif antialiased p-10 print:p-0 print:bg-white flex justify-center">

    <div class="fixed top-8 left-8 no-print bg-blue-50 border-l-4 border-blue-600 p-4 rounded-r-xl shadow-lg max-w-sm">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            <div>
                <h3 class="text-sm font-bold text-blue-900">Editable Document Mode</h3>
                <p class="text-xs text-blue-700 mt-1">Click anywhere inside the dashed boxes to personalize the text before saving as a PDF.</p>
            </div>
        </div>
    </div>

    <div class="fixed top-8 right-8 no-print flex flex-col gap-3">
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

    <div class="max-w-[8.5in] w-full bg-white p-12 lg:p-16 shadow-2xl print:shadow-none mx-auto border border-gray-200 print:border-none min-h-[11in] relative">

        <div class="flex items-center justify-between border-b-4 border-[#004d32] pb-6 mb-10">
            <div class="flex items-center gap-6">
                <img src="{{ asset('images/FEU-Logo.png') }}" alt="FEU Logo" class="w-24 h-24 object-contain">
                <div>
                    <h1 class="text-3xl font-bold text-[#004d32] uppercase tracking-widest" style="font-family: 'DellaRobiaBT', 'Della Robbia BT', serif;">Far Eastern University</h1>
                    <h2 class="text-lg font-bold text-[#FECB02] uppercase tracking-widest mt-1">Office of Student Discipline</h2>
                    <p class="text-xs text-gray-500 font-sans mt-1 tracking-wide">Nicanor Reyes St, Sampaloc, Manila, 1008 Metro Manila</p>
                </div>
            </div>
        </div>

        <div class="mb-12 text-sm font-sans leading-relaxed text-slate-800">
            <p><strong>Date Issued:</strong> {{ now()->format('F d, Y') }}</p>
            <p class="mt-4"><strong>To:</strong> <span class="uppercase">{{ $violation->student->name }}</span> ({{ $violation->student->id_number ?? 'N/A' }})</p>
            <p><strong>Department/Program:</strong> {{ $violation->student->program_code ?? 'N/A' }}</p>

            <p class="mt-6 text-base"><strong>Subject:</strong> <span class="uppercase font-extrabold tracking-wide text-[#004d32] border-b-2 border-[#004d32]">NOTICE TO EXPLAIN (NTE)</span></p>
            <p class="text-xs text-gray-500 mt-1">System Reference: CASE-{{ str_pad($violation->id, 4, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div contenteditable="true" class="space-y-6 text-[15px] font-serif leading-loose text-justify text-slate-900 border-2 border-dashed border-blue-200 hover:border-blue-400 p-4 -mx-4 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all print-no-border">
            @php
                $nameParts = explode(' ', $violation->student->name);
                $lastName = end($nameParts);
            @endphp
            <p>Dear Mr./Ms. <strong>{{ $lastName }}</strong>,</p>

            <p>
                This office has received an official incident report regarding your alleged violation of university policies as stipulated under the Far Eastern University Student Handbook. The specifics of the recorded incident are detailed below:
            </p>

            <div class="pl-6 border-l-4 border-[#004d32] py-4 my-6 bg-slate-50 pr-6" contenteditable="false">
                <p class="font-sans text-sm"><strong>Date of Record:</strong> {{ $violation->created_at->format('F d, Y - h:i A') }}</p>
                <p class="font-sans text-sm mt-1"><strong>Nature of Offense:</strong> <span class="uppercase font-bold text-red-700">{{ $violation->offense_type }}</span></p>
                <p class="mt-3 text-slate-700 whitespace-pre-wrap font-sans text-sm italic">"{{ $violation->description }}"</p>
            </div>

            <p>
                In strict adherence to the principles of due process, you are hereby directed to submit a written explanation outlining why no disciplinary sanctions should be imposed against you concerning this matter.
            </p>

            <p>
                Please submit your written response (duly signed) to the Investigating Officer at the Office of Student Discipline within <strong>Seventy-Two (72) hours</strong> from the receipt of this formal notice. Failure to submit an explanation within the specified timeframe will be officially construed as a waiver of your right to be heard.
            </p>

            <p class="mt-8">
                For your strict compliance.
            </p>
        </div>

        <div class="mt-24 text-sm font-sans grid grid-cols-2 gap-16">
            <div>
                <div class="border-b border-black w-full mb-2"></div>
                <p class="font-extrabold text-[#004d32] uppercase">{{ $violation->reporter->name ?? 'Discipline Officer' }}</p>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wide mt-1">Investigating Officer</p>
            </div>
            <div>
                <div class="border-b border-black w-full mb-2"></div>
                <p class="font-extrabold text-[#004d32] uppercase">Student Signature</p>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wide mt-1">Received By / Date</p>
            </div>
        </div>

        <div class="absolute bottom-10 left-0 right-0 text-center border-t border-gray-200 pt-4 text-[10px] text-gray-400 font-sans uppercase tracking-[0.2em]">
            Generated by FEU-OSDMS Intelligence Protocol v2026 | Document Hash: {{ uniqid() }}
        </div>
    </div>

</body>
</html>
