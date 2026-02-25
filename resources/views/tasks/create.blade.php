<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Task') }}
        </h2>
    </x-slot>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        #calModal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .55);
            backdrop-filter: blur(4px);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }

        #calModal.open {
            display: flex;
        }

        #calCard {
            position: relative;
            background: #fff;
            border-radius: 24px;
            padding: 24px 24px 20px;
            width: 360px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, .22);
            animation: popIn .22s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes popIn {
            from {
                transform: scale(.88);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        #closeModal {
            position: absolute;
            top: 16px;
            right: 18px;
            background: none;
            border: none;
            font-size: 22px;
            line-height: 1;
            color: #94a3b8;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 6px;
            transition: color .15s;
        }

        #closeModal:hover {
            color: #475569;
        }

        .cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .cal-nav {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s, border-color .15s;
            color: #475569;
        }

        .cal-nav:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #2563eb;
        }

        .cal-month-year {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
        }

        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }

        .cal-dow {
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            padding: 4px 0 10px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .cal-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            color: #334155;
            transition: background .12s, color .12s;
        }

        .cal-day:not(.empty):hover {
            background: #eff6ff;
            color: #2563eb;
        }

        .cal-day.selected {
            background: #2563eb;
            color: #fff;
            font-weight: 700;
        }

        .cal-day.today {
            border: 1.5px solid #2563eb;
            color: #2563eb;
        }

        .cal-day.today.selected {
            color: #fff;
        }

        .cal-day.empty {
            cursor: default;
        }

        /* ── HOUR SECTION ── */
        .hour-section {
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1.5px solid #f1f5f9;
        }

        .hour-label {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 10px;
        }

        .hour-input-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #hourInput {
            flex: 1;
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            color: #1e293b;
            background: #f8fafc;
            outline: none;
            transition: border-color .15s, background .15s;
        }

        #hourInput:focus {
            border-color: #2563eb;
            background: #fff;
        }

        #hourInput.error {
            border-color: #f87171;
            background: #fff5f5;
        }

        /* ── AM/PM BADGE ── */
        #ampmBadge {
            min-width: 52px;
            padding: 9px 14px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            text-align: center;
            letter-spacing: .04em;
            border: 1.5px solid #e2e8f0;
            background: #f1f5f9;
            color: #94a3b8;
            transition: background .2s, color .2s, border-color .2s;
            user-select: none;
        }

        #ampmBadge.am {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        #ampmBadge.pm {
            background: #fef3c7;
            color: #d97706;
            border-color: #fde68a;
        }

        .hour-hint {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 6px;
        }

        #hourError {
            font-size: 12px;
            color: #ef4444;
            margin-top: 5px;
            display: none;
        }

        #confirmBtn {
            width: 100%;
            margin-top: 16px;
            padding: 12px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, transform .1s;
        }

        #confirmBtn:hover {
            background: #1d4ed8;
        }

        #confirmBtn:active {
            transform: scale(.97);
        }

        #confirmBtn:disabled {
            background: #93c5fd;
            cursor: not-allowed;
        }

        #openCal {
            padding: 8px 10px;
            background: #eff6ff;
            border: 1.5px solid #bfdbfe;
            border-radius: 10px;
            cursor: pointer;
            transition: background .15s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        #openCal:hover {
            background: #dbeafe;
        }

        #dateDisplay {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            color: #94a3b8;
            background: #f8fafc;
        }

        #dateDisplay.has-value {
            color: #1e293b;
            font-weight: 600;
            border-color: #bfdbfe;
            background: #eff6ff;
        }
    </style>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg border p-6">

                {{-- STEP 1 --}}
                <div id="step1">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pick Date &amp; Time</h1>
                    <label class="block text-gray-700 mb-3 font-medium">Select Date and Time *</label>

                    <div class="flex items-center gap-3 mb-2">
                        <div id="dateDisplay">No date selected</div>
                        <button type="button" id="openCal" title="Open calendar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </button>
                    </div>

                    <p id="alert" class="text-red-500 text-sm mt-2 mb-2 hidden">Please select a date &amp; time to continue.</p>

                    <button id="proceedBtn"
                        class="mt-5 px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                        Continue to Create Task
                    </button>
                </div>

                {{-- STEP 2 --}}
                <div id="taskForm" class="hidden">
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">Create New Task</h1>
                    <p id="chosenDateLabel" class="text-sm text-blue-600 font-medium mb-6"></p>

                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="scheduled_at" id="scheduled_at">

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium" for="title">Title *</label>
                            <input type="text" name="title" id="title"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 mb-2 font-medium" for="description">Description (Optional)</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('tasks.index') }}"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-5 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                                Create Task
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div id="calModal" role="dialog" aria-modal="true" aria-label="Pick date and time">
        <div id="calCard">
            <button type="button" id="closeModal" aria-label="Close">&times;</button>

            <div class="cal-header">
                <button type="button" class="cal-nav" id="prevMonth">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                </button>
                <span class="cal-month-year" id="calTitle"></span>
                <button type="button" class="cal-nav" id="nextMonth">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </button>
            </div>

            <div class="cal-grid" id="calGrid">
                <div class="cal-dow">Su</div>
                <div class="cal-dow">Mo</div>
                <div class="cal-dow">Tu</div>
                <div class="cal-dow">We</div>
                <div class="cal-dow">Th</div>
                <div class="cal-dow">Fr</div>
                <div class="cal-dow">Sa</div>
            </div>

            {{-- HOUR INPUT --}}
            <div class="hour-section">
                <div class="hour-label">Hour</div>
                <div class="hour-input-wrap">
                    <input type="text" id="hourInput" placeholder="e.g. 08:30 or 14:00" maxlength="5" autocomplete="off">
                    <div id="ampmBadge">--</div>
                </div>
                <div class="hour-hint">Format: HH:MM &nbsp;·&nbsp; 24-hour (00:00 – 23:59)</div>
                <div id="hourError">Invalid time. Please use HH:MM format (e.g. 09:00 or 21:30).</div>
            </div>

            <button type="button" id="confirmBtn" disabled>Set Date &amp; Time</button>
        </div>
    </div>

    <script>
        const today = new Date();
        let viewYear = today.getFullYear();
        let viewMonth = today.getMonth();
        let selDay = null;
        let selHour = null;
        let pickedMonth = null;
        let pickedYearVal = null;
        let pickedDatetime = null;

        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        const calModal = document.getElementById('calModal');
        const calTitle = document.getElementById('calTitle');
        const calGrid = document.getElementById('calGrid');
        const confirmBtn = document.getElementById('confirmBtn');
        const dateDisplay = document.getElementById('dateDisplay');
        const proceedBtn = document.getElementById('proceedBtn');
        const alertMsg = document.getElementById('alert');
        const taskForm = document.getElementById('taskForm');
        const step1 = document.getElementById('step1');
        const scheduledAt = document.getElementById('scheduled_at');
        const chosenLabel = document.getElementById('chosenDateLabel');
        const hourInput = document.getElementById('hourInput');
        const hourError = document.getElementById('hourError');
        const ampmBadge = document.getElementById('ampmBadge');

        /* ── UPDATE AM/PM BADGE ── */
        function updateAmPm(val) {
            const match = val.match(/^([01]\d|2[0-3]):([0-5]\d)$/);
            if (match) {
                const h = parseInt(match[1], 10);
                if (h < 12) {
                    ampmBadge.textContent = 'AM';
                    ampmBadge.className = 'am';
                } else {
                    ampmBadge.textContent = 'PM';
                    ampmBadge.className = 'pm';
                }
            } else {
                ampmBadge.textContent = '--';
                ampmBadge.className = '';
            }
        }

        /* ── HOUR INPUT VALIDATION ── */
        hourInput.addEventListener('input', () => {
            let val = hourInput.value.replace(/[^0-9:]/g, '');
            if (val.length === 2 && !val.includes(':')) val = val + ':';
            hourInput.value = val;

            hourInput.classList.remove('error');
            hourError.style.display = 'none';

            const valid = /^([01]\d|2[0-3]):([0-5]\d)$/.test(val);
            selHour = valid ? val : null;
            updateAmPm(val);
            updateConfirm();
        });

        hourInput.addEventListener('blur', () => {
            const val = hourInput.value.trim();
            if (val && !/^([01]\d|2[0-3]):([0-5]\d)$/.test(val)) {
                hourInput.classList.add('error');
                hourError.style.display = 'block';
                selHour = null;
                ampmBadge.textContent = '--';
                ampmBadge.className = '';
                updateConfirm();
            }
        });

        /* ── RENDER CALENDAR ── */
        function renderCalendar() {
            calTitle.textContent = `${monthNames[viewMonth]} ${viewYear}`;
            calGrid.querySelectorAll('.cal-day').forEach(el => el.remove());

            const firstDay = new Date(viewYear, viewMonth, 1).getDay();
            const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                const empty = document.createElement('div');
                empty.className = 'cal-day empty';
                calGrid.appendChild(empty);
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const cell = document.createElement('div');
                cell.className = 'cal-day';
                cell.textContent = d;

                if (d === today.getDate() && viewMonth === today.getMonth() && viewYear === today.getFullYear())
                    cell.classList.add('today');
                if (d === selDay && viewMonth === pickedMonth && viewYear === pickedYearVal)
                    cell.classList.add('selected');

                cell.addEventListener('click', () => {
                    calGrid.querySelectorAll('.cal-day.selected').forEach(c => c.classList.remove('selected'));
                    cell.classList.add('selected');
                    selDay = d;
                    pickedMonth = viewMonth;
                    pickedYearVal = viewYear;
                    updateConfirm();
                });

                calGrid.appendChild(cell);
            }
        }

        function updateConfirm() {
            confirmBtn.disabled = !(selDay && selHour);
        }

        document.getElementById('prevMonth').addEventListener('click', () => {
            if (--viewMonth < 0) {
                viewMonth = 11;
                viewYear--;
            }
            renderCalendar();
        });
        document.getElementById('nextMonth').addEventListener('click', () => {
            if (++viewMonth > 11) {
                viewMonth = 0;
                viewYear++;
            }
            renderCalendar();
        });

        document.getElementById('openCal').addEventListener('click', () => {
            renderCalendar();
            calModal.classList.add('open');
        });
        document.getElementById('closeModal').addEventListener('click', () => calModal.classList.remove('open'));
        calModal.addEventListener('click', e => {
            if (e.target === calModal) calModal.classList.remove('open');
        });

        confirmBtn.addEventListener('click', () => {
            if (!selDay || !selHour || pickedMonth === null) return;
            const mm = String(pickedMonth + 1).padStart(2, '0');
            const dd = String(selDay).padStart(2, '0');
            pickedDatetime = `${pickedYearVal}-${mm}-${dd}T${selHour}`;

            const [hh, min] = selHour.split(':').map(Number);
            const suffix = hh < 12 ? 'AM' : 'PM';
            const hr12 = hh === 0 ? 12 : hh > 12 ? hh - 12 : hh;
            const label = `${monthNames[pickedMonth]} ${selDay}, ${pickedYearVal} · ${hr12}:${String(min).padStart(2,'0')} ${suffix}`;

            dateDisplay.textContent = label;
            dateDisplay.classList.add('has-value');
            calModal.classList.remove('open');
        });

        proceedBtn.addEventListener('click', () => {
            if (!pickedDatetime) {
                alertMsg.classList.remove('hidden');
                return;
            }
            alertMsg.classList.add('hidden');
            scheduledAt.value = pickedDatetime;
            chosenLabel.textContent = '📅 ' + dateDisplay.textContent;
            step1.classList.add('hidden');
            taskForm.classList.remove('hidden');
            taskForm.scrollIntoView({
                behavior: 'smooth'
            });
        });

        renderCalendar();
    </script>
</x-app-layout>