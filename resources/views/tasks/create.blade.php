
<x-app-layout>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        {{-- Debug / Error Box --}}
        <div id="debugBox" class="hidden mb-6 p-4 bg-red-50 border border-red-300 text-red-700 rounded-xl text-sm font-medium"></div>

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">📋 Task Calendar</h1>
                <p class="text-sm text-gray-500 mt-1">Click any date to schedule a task — syncs with My Tasks</p>
            </div>
            <div class="flex items-center gap-3">
                <button id="prevBtn"
                    class="w-10 h-10 rounded-xl bg-white border border-gray-200 shadow-sm flex items-center justify-center text-gray-500 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all duration-150">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                </button>
                <span id="monthLabel" class="text-lg font-bold text-gray-800 min-w-[160px] text-center"></span>
                <button id="nextBtn"
                    class="w-10 h-10 rounded-xl bg-white border border-gray-200 shadow-sm flex items-center justify-center text-gray-500 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all duration-150">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Calendar Grid --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Day of week header --}}
            <div class="grid grid-cols-7 border-b border-gray-100">
                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $dow)
                <div class="py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-widest">{{ $dow }}</div>
                @endforeach
            </div>
            {{-- Days --}}
            <div class="grid grid-cols-7" id="daysGrid"></div>
        </div>

        {{-- Legend --}}
        <div class="flex items-center gap-6 mt-4 text-xs text-gray-400">
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-indigo-100 border-l-2 border-indigo-500 inline-block"></span> Pending</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-emerald-100 border-l-2 border-emerald-500 inline-block"></span> Completed</span>
        </div>
    </div>

    {{-- ── CREATE TASK MODAL ── --}}
    <div id="createOverlay" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div id="createModal" class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-7 relative animate-modal">
            <button id="closeCreate" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl leading-none w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">&times;</button>

            {{-- Date badge --}}
            <div class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded-xl px-3 py-1.5 text-sm font-semibold mb-5">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                <span id="modalDateLabel"></span>
            </div>

            <h2 class="text-2xl font-extrabold text-gray-900 mb-1">New Task</h2>
            <p class="text-sm text-gray-400 mb-6">Saves to My Tasks automatically</p>

            <div class="mb-4">
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Title *</label>
                <input id="taskTitle" type="text" placeholder="What needs to be done?"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Description <span class="normal-case font-normal">(optional)</span></label>
                <textarea id="taskDesc" rows="3" placeholder="Add some details…"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Time (HH:MM)</label>
                <div class="flex items-center gap-3">
                    <input id="timeInput" type="text" placeholder="e.g. 09:30" maxlength="5" autocomplete="off"
                        class="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    <span id="ampmBadge" class="px-4 py-3 rounded-xl text-sm font-bold bg-gray-50 border border-gray-200 text-gray-400 whitespace-nowrap transition-all">--</span>
                </div>
                <p class="text-xs text-gray-400 mt-1.5">24-hour format · 00:00 – 23:59</p>
                <p id="timeError" class="hidden text-xs text-red-500 mt-1">Invalid time. Use HH:MM format.</p>
            </div>

            <div class="flex gap-3">
                <button id="cancelCreate"
                    class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-500 text-sm font-medium hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button id="saveTask" disabled
                    class="flex-[2] py-3 rounded-xl bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 disabled:opacity-40 disabled:cursor-not-allowed transition">
                    ✦ Create Task
                </button>
            </div>
        </div>
    </div>

    {{-- ── TASK DETAIL MODAL ── --}}
    <div id="detailOverlay" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-7 relative animate-modal">
            <button id="closeDetail" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl leading-none w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">&times;</button>

            <span id="detailTag" class="inline-block rounded-lg px-3 py-1 text-xs font-semibold mb-4"></span>
            <h2 id="detailTitle" class="text-xl font-extrabold text-gray-900 mb-2"></h2>
            <p id="detailDesc" class="text-sm text-gray-500 leading-relaxed mb-4"></p>
            <div id="detailMeta" class="flex items-center gap-2 text-xs text-gray-400 flex-wrap"></div>

            <div class="flex gap-3 mt-6">
                <button id="markDoneBtn"
                    class="flex-1 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold hover:bg-emerald-100 transition">
                    ✔ Mark Done
                </button>
                <button id="deleteTask"
                    class="flex-1 py-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm font-semibold hover:bg-red-100 transition">
                    🗑 Delete
                </button>
            </div>
        </div>
    </div>

    {{-- ── TOAST ── --}}
    <div id="toast" class="fixed bottom-7 left-1/2 -translate-x-1/2 translate-y-16 opacity-0 pointer-events-none z-[9999] px-5 py-3 rounded-2xl text-sm font-semibold shadow-xl transition-all duration-300 bg-emerald-500 text-white"></div>

    <style>
        @keyframes modalIn {
            from {
                transform: translateY(20px) scale(.97);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .animate-modal {
            animation: modalIn .22s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        /* Day cell add hint */
        .day-cell .add-hint {
            display: none;
        }

        .day-cell:hover .add-hint {
            display: flex;
        }
    </style>

    <script>
        const MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let today = new Date();
        let viewYear = today.getFullYear();
        let viewMonth = today.getMonth();
        let tasks = [];
        let selectedDate = null,
            selectedTime = null,
            viewingTask = null;

        const $ = id => document.getElementById(id);
        const daysGrid = $('daysGrid');
        const monthLabel = $('monthLabel');
        const createOverlay = $('createOverlay');
        const detailOverlay = $('detailOverlay');
        const taskTitle = $('taskTitle');
        const taskDesc = $('taskDesc');
        const timeInput = $('timeInput');
        const timeError = $('timeError');
        const ampmBadge = $('ampmBadge');
        const saveTask = $('saveTask');
        const toast = $('toast');
        const debugBox = $('debugBox');

        // ── helpers
        function showDebug(msg) {
            debugBox.classList.remove('hidden');
            debugBox.textContent = '⚠ ' + msg;
        }

        function hideDebug() {
            debugBox.classList.add('hidden');
        }

        async function apiFetch(url, options = {}) {
            const res = await fetch(url, {
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                ...options
            });
            if (!res.ok) {
                const t = await res.text();
                throw new Error(`HTTP ${res.status}: ${t.substring(0,300)}`);
            }
            return res.json();
        }

        async function loadTasks() {
            try {
                tasks = await apiFetch('/calendar-api/tasks');
                hideDebug();
                renderCalendar();
            } catch (e) {
                showDebug('Failed to load tasks: ' + e.message);
                renderCalendar();
            }
        }

        function pad(n) {
            return String(n).padStart(2, '0');
        }

        function dateKey(y, m, d) {
            return `${y}-${pad(m+1)}-${pad(d)}`;
        }

        function dispDate(y, m, d) {
            return `${MONTHS[m]} ${d}, ${y}`;
        }

        function time12(t) {
            if (!t) return '';
            const [hh, mm] = t.split(':').map(Number);
            return `${hh===0?12:hh>12?hh-12:hh}:${pad(mm)} ${hh<12?'AM':'PM'}`;
        }

        function esc(s) {
            return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        }

        function taskTime(t) {
            return t.scheduled_at ? t.scheduled_at.slice(11, 16) : '';
        }

        function showToast(msg, isErr = false) {
            toast.textContent = msg;
            toast.className = `fixed bottom-7 left-1/2 -translate-x-1/2 z-[9999] px-5 py-3 rounded-2xl text-sm font-semibold shadow-xl transition-all duration-300 pointer-events-none ${isErr?'bg-red-500':'bg-emerald-500'} text-white translate-y-0 opacity-100`;
            setTimeout(() => toast.className = toast.className.replace('translate-y-0 opacity-100', 'translate-y-16 opacity-0'), 2600);
        }

        // ── Render
        function renderCalendar() {
            monthLabel.textContent = `${MONTHS[viewMonth]} ${viewYear}`;
            daysGrid.innerHTML = '';
            const first = new Date(viewYear, viewMonth, 1).getDay();
            const total = new Date(viewYear, viewMonth + 1, 0).getDate();

            // Empty leading cells
            for (let i = 0; i < first; i++) {
                const el = document.createElement('div');
                el.className = 'min-h-[110px] border-r border-b border-gray-100 bg-gray-50/60 last:border-r-0';
                daysGrid.appendChild(el);
            }

            for (let d = 1; d <= total; d++) {
                const isToday = d === today.getDate() && viewMonth === today.getMonth() && viewYear === today.getFullYear();
                const cell = document.createElement('div');
                cell.className = `day-cell min-h-[110px] p-2.5 border-r border-b border-gray-100 last:border-r-0 cursor-pointer hover:bg-indigo-50/60 transition-colors relative overflow-hidden group`;

                // Day number
                const numEl = document.createElement('div');
                numEl.className = `inline-flex items-center justify-center w-7 h-7 rounded-full text-[13px] font-medium mb-1.5 ${isToday ? 'bg-indigo-600 text-white font-bold' : 'text-gray-400 group-hover:text-gray-700'}`;
                numEl.textContent = d;
                cell.appendChild(numEl);

                // Tasks
                const key = dateKey(viewYear, viewMonth, d);
                const dayTasks = tasks.filter(t => t.scheduled_at && t.scheduled_at.slice(0, 10) === key);
                dayTasks.slice(0, 2).forEach(task => {
                    const pill = document.createElement('div');
                    pill.className = `flex items-center gap-1 rounded-md px-1.5 py-1 mb-0.5 text-[11px] font-medium cursor-pointer truncate border-l-2 ${task.is_done ? 'bg-emerald-50 border-emerald-400 text-emerald-700' : 'bg-indigo-50 border-indigo-400 text-indigo-700'} hover:opacity-80 transition`;
                    pill.innerHTML = `<span class="shrink-0 text-[10px] opacity-60">${esc(time12(taskTime(task)))}</span><span class="truncate">${esc(task.title)}</span>`;
                    pill.addEventListener('click', e => {
                        e.stopPropagation();
                        openDetail(task);
                    });
                    cell.appendChild(pill);
                });
                if (dayTasks.length > 2) {
                    const more = document.createElement('div');
                    more.className = 'text-[10px] text-gray-400 mt-0.5 pl-0.5';
                    more.textContent = `+${dayTasks.length-2} more`;
                    cell.appendChild(more);
                }

                // Add hint
                const hint = document.createElement('div');
                hint.className = 'add-hint absolute bottom-2 right-2 w-5 h-5 rounded-md bg-indigo-100 text-indigo-500 items-center justify-center text-base font-light';
                hint.textContent = '+';
                cell.appendChild(hint);

                cell.addEventListener('click', () => openCreate(d));
                daysGrid.appendChild(cell);
            }
        }

        // ── Create modal
        function openCreate(day) {
            selectedDate = {
                y: viewYear,
                m: viewMonth,
                d: day
            };
            selectedTime = null;
            taskTitle.value = '';
            taskDesc.value = '';
            timeInput.value = '';
            timeError.classList.add('hidden');
            ampmBadge.textContent = '--';
            ampmBadge.className = 'px-4 py-3 rounded-xl text-sm font-bold bg-gray-50 border border-gray-200 text-gray-400 whitespace-nowrap transition-all';
            saveTask.disabled = true;
            $('modalDateLabel').textContent = dispDate(viewYear, viewMonth, day);
            createOverlay.classList.remove('hidden');
            setTimeout(() => taskTitle.focus(), 100);
        }

        function closeCreate() {
            createOverlay.classList.add('hidden');
            selectedDate = null;
        }

        // ── Detail modal
        function openDetail(task) {
            viewingTask = task;
            const isDone = task.is_done;
            $('detailTag').textContent = isDone ? '✓ Completed' : '⏳ In Progress';
            $('detailTag').className = `inline-block rounded-lg px-3 py-1 text-xs font-semibold mb-4 ${isDone ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-indigo-100 text-indigo-700 border border-indigo-200'}`;
            $('detailTitle').textContent = task.title;
            $('detailDesc').textContent = task.description || 'No description provided.';
            const t12 = time12(taskTime(task));
            const ds = task.scheduled_at ? task.scheduled_at.slice(0, 10) : '';
            $('detailMeta').innerHTML = `
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            ${esc(ds)} ${t12 ? `<span class="mx-1">·</span> 🕐 ${esc(t12)}` : ''}`;
            $('markDoneBtn').classList.toggle('hidden', isDone);
            detailOverlay.classList.remove('hidden');
        }

        function closeDetail() {
            detailOverlay.classList.add('hidden');
            viewingTask = null;
        }

        // ── Time input
        timeInput.addEventListener('input', () => {
            let v = timeInput.value.replace(/[^0-9:]/g, '');
            if (v.length === 2 && !v.includes(':')) v += ':';
            timeInput.value = v;
            timeError.classList.add('hidden');
            const ok = /^([01]\d|2[0-3]):([0-5]\d)$/.test(v);
            if (ok) {
                const h = parseInt(v, 10);
                selectedTime = v;
                const isAM = h < 12;
                ampmBadge.textContent = isAM ? 'AM' : 'PM';
                ampmBadge.className = `px-4 py-3 rounded-xl text-sm font-bold whitespace-nowrap transition-all border ${isAM?'bg-indigo-50 border-indigo-200 text-indigo-600':'bg-amber-50 border-amber-200 text-amber-600'}`;
            } else {
                selectedTime = null;
                ampmBadge.textContent = '--';
                ampmBadge.className = 'px-4 py-3 rounded-xl text-sm font-bold bg-gray-50 border border-gray-200 text-gray-400 whitespace-nowrap transition-all';
            }
            updateSaveBtn();
        });
        timeInput.addEventListener('blur', () => {
            const v = timeInput.value.trim();
            if (v && !/^([01]\d|2[0-3]):([0-5]\d)$/.test(v)) timeError.classList.remove('hidden');
        });
        taskTitle.addEventListener('input', updateSaveBtn);

        function updateSaveBtn() {
            saveTask.disabled = !(taskTitle.value.trim() && selectedTime);
        }

        // ── Save
        saveTask.addEventListener('click', async () => {
            if (!selectedDate || !selectedTime || !taskTitle.value.trim()) return;
            const {
                y,
                m,
                d
            } = selectedDate;
            const scheduledAt = `${y}-${pad(m+1)}-${pad(d)} ${selectedTime}:00`;
            saveTask.disabled = true;
            saveTask.textContent = 'Saving…';
            try {
                const newTask = await apiFetch('/calendar-api/tasks', {
                    method: 'POST',
                    body: JSON.stringify({
                        title: taskTitle.value.trim(),
                        description: taskDesc.value.trim(),
                        scheduled_at: scheduledAt
                    })
                });
                tasks.push(newTask);
                closeCreate();
                renderCalendar();
                showToast('✓ Task added! Visible in My Tasks.');
            } catch (e) {
                showToast(e.message, true);
                showDebug(e.message);
            } finally {
                saveTask.disabled = false;
                saveTask.textContent = '✦ Create Task';
            }
        });

        // ── Mark done
        $('markDoneBtn').addEventListener('click', async () => {
            if (!viewingTask) return;
            try {
                await apiFetch(`/tasks/${viewingTask.id}/done`, {
                    method: 'PATCH'
                });
                viewingTask.is_done = true;
                const idx = tasks.findIndex(t => t.id === viewingTask.id);
                if (idx !== -1) tasks[idx].is_done = true;
                closeDetail();
                renderCalendar();
                showToast('✔ Marked as done!');
            } catch (e) {
                showToast(e.message, true);
            }
        });

        // ── Delete
        $('deleteTask').addEventListener('click', async () => {
            if (!viewingTask) return;
            try {
                await apiFetch(`/calendar-api/tasks/${viewingTask.id}`, {
                    method: 'DELETE'
                });
                tasks = tasks.filter(t => t.id !== viewingTask.id);
                closeDetail();
                renderCalendar();
                showToast('🗑 Task deleted');
            } catch (e) {
                showToast(e.message, true);
            }
        });

        // ── Modal controls
        $('closeCreate').addEventListener('click', closeCreate);
        $('cancelCreate').addEventListener('click', closeCreate);
        $('closeDetail').addEventListener('click', closeDetail);
        createOverlay.addEventListener('click', e => {
            if (e.target === createOverlay) closeCreate();
        });
        detailOverlay.addEventListener('click', e => {
            if (e.target === detailOverlay) closeDetail();
        });

        $('prevBtn').addEventListener('click', () => {
            if (--viewMonth < 0) {
                viewMonth = 11;
                viewYear--;
            }
            renderCalendar();
        });
        $('nextBtn').addEventListener('click', () => {
            if (++viewMonth > 11) {
                viewMonth = 0;
                viewYear++;
            }
            renderCalendar();
        });

        loadTasks();
    </script>
</x-app-layout>