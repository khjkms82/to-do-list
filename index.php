<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>할 일 목록</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', 'Noto Sans KR', sans-serif;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        .slide-in {
            animation: slideIn 0.5s ease-out;
        }
        
        .glass-effect {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .glass-dark {
            background: rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .checkbox-custom {
            appearance: none;
            width: 24px;
            height: 24px;
            border: 2px solid #cbd5e1;
            border-radius: 8px;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .checkbox-custom:checked {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
        }
        
        .checkbox-custom:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 16px;
            font-weight: bold;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        .todo-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .todo-item:hover {
            transform: translateX(4px);
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-4px) scale(1.02);
        }
        
        .calendar-day {
            position: relative;
            transition: all 0.2s ease;
        }
        
        .calendar-day:hover {
            transform: scale(1.1);
        }
        
        .calendar-day.selected {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: bold;
        }
        
        .calendar-day.today {
            border: 2px solid #f093fb;
            font-weight: bold;
        }
        
        .calendar-day.today.selected {
            border: 2px solid white;
        }
        
        .todo-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 8px;
            min-width: 16px;
            text-align: center;
            line-height: 1.2;
        }
    </style>
</head>
<body class="min-h-screen py-8 px-4 relative overflow-x-hidden">
    <!-- 배경 그라데이션 -->
    <div class="fixed inset-0 bg-gradient-to-br from-purple-900 via-indigo-900 to-pink-900 -z-10"></div>
    <div class="fixed inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20 -z-10"></div>
    
    <!-- 떠다니는 원형 장식 -->
    <div class="fixed top-20 left-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 float-animation -z-10"></div>
    <div class="fixed bottom-20 right-10 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 float-animation -z-10" style="animation-delay: 2s;"></div>
    <div class="fixed top-1/2 right-1/4 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 float-animation -z-10" style="animation-delay: 4s;"></div>
    
    <div class="max-w-3xl mx-auto relative z-10">
        <!-- 헤더 -->
        <div class="text-center mb-12 slide-in">
            <div class="inline-block mb-4">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-2xl transform rotate-3 hover:rotate-6 transition-transform duration-300">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-6xl font-extrabold mb-4 flex items-center justify-center gap-4">
                <i class="fas fa-list-check gradient-text text-5xl"></i>
                <span class="gradient-text">To Do List</span>
            </h1>
            <p class="text-white/80 text-lg font-light">소중한 오늘 하루를 관리해보세요!</p>
        </div>

        <!-- 날짜 선택 섹션 -->
        <div class="glass-effect rounded-3xl shadow-2xl p-6 mb-4 slide-in" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <button 
                    id="prevDateButton"
                    class="p-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl transition-all transform hover:scale-110 active:scale-95 group"
                >
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <div class="flex-1 mx-6 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div id="dateDisplay" class="text-white text-2xl font-bold">
                                2024년 1월 15일
                            </div>
                            <div id="dayDisplay" class="text-white/70 text-sm font-medium mt-1">
                                월요일
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <button 
                        id="todayButton"
                        class="px-4 py-2 bg-gradient-to-r from-purple-500/40 to-pink-500/40 hover:from-purple-500/60 hover:to-pink-500/60 backdrop-blur-sm text-white text-sm font-semibold rounded-xl transition-all transform hover:scale-105 active:scale-95 whitespace-nowrap"
                    >
                        오늘
                    </button>
                    <button 
                        id="nextDateButton"
                        class="p-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl transition-all transform hover:scale-110 active:scale-95 group"
                    >
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- 캘린더 섹션 -->
        <div class="glass-effect rounded-3xl shadow-2xl p-6 mb-4 slide-in" style="animation-delay: 0.12s;">
            <div class="mb-4 flex items-center justify-between">
                <button 
                    id="prevMonthButton"
                    class="p-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg transition-all transform hover:scale-110 active:scale-95 group"
                >
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <h3 id="calendarMonth" class="text-white text-xl font-bold">2024년 1월</h3>
                <button 
                    id="nextMonthButton"
                    class="p-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg transition-all transform hover:scale-110 active:scale-95 group"
                >
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            
            <!-- 요일 헤더 -->
            <div class="grid grid-cols-7 gap-2 mb-2">
                <div class="text-center text-white/60 text-sm font-medium py-2">일</div>
                <div class="text-center text-white/60 text-sm font-medium py-2">월</div>
                <div class="text-center text-white/60 text-sm font-medium py-2">화</div>
                <div class="text-center text-white/60 text-sm font-medium py-2">수</div>
                <div class="text-center text-white/60 text-sm font-medium py-2">목</div>
                <div class="text-center text-white/60 text-sm font-medium py-2">금</div>
                <div class="text-center text-white/60 text-sm font-medium py-2">토</div>
            </div>
            
            <!-- 캘린더 날짜 그리드 -->
            <div id="calendarGrid" class="grid grid-cols-7 gap-2">
                <!-- JavaScript로 동적 생성 -->
            </div>
        </div>

        <!-- 입력 섹션 -->
        <div class="glass-effect rounded-3xl shadow-2xl p-8 mb-8 slide-in" style="animation-delay: 0.15s;">
            <div class="flex gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500/20 to-pink-500/20 rounded-2xl blur-xl"></div>
                    <input 
                        type="text" 
                        id="todoInput"
                        placeholder="새로운 할 일을 입력하세요..." 
                        class="relative w-full px-6 py-4 bg-white/90 backdrop-blur-sm border-2 border-white/50 rounded-2xl focus:outline-none focus:border-purple-400 focus:ring-4 focus:ring-purple-300/50 transition-all text-gray-800 placeholder-gray-400 text-lg font-medium shadow-lg"
                    >
                </div>
                <button 
                    id="addButton"
                    class="px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl hover:from-purple-700 hover:to-pink-700 active:scale-95 transition-all shadow-2xl hover:shadow-purple-500/50 font-semibold text-lg transform hover:scale-105 relative overflow-hidden group"
                >
                    <span class="relative z-10 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        추가
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </button>
            </div>
        </div>

        <!-- 할 일 목록 -->
        <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden slide-in" style="animation-delay: 0.2s;">
            <div id="todoList" class="divide-y divide-white/20">
                <!-- 동적으로 생성됨 -->
            </div>

            <!-- 빈 상태 메시지 -->
            <div id="emptyState" class="hidden p-16 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-3xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-12 h-12 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <p class="text-white/60 text-xl font-medium mb-2">할 일이 없습니다</p>
                <p class="text-white/40 text-sm">새로운 할 일을 추가해보세요!</p>
            </div>
        </div>

        <!-- 통계 정보 -->
        <div class="mt-8 grid grid-cols-3 gap-6 slide-in" style="animation-delay: 0.3s;">
            <div class="stat-card glass-dark rounded-2xl p-6 text-center cursor-pointer">
                <div class="w-12 h-12 mx-auto mb-3 bg-gradient-to-br from-purple-400/30 to-pink-400/30 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <p class="text-white/60 text-xs font-medium mb-2 uppercase tracking-wider">전체</p>
                <p id="totalCount" class="text-4xl font-bold text-white">0</p>
            </div>
            <div class="stat-card glass-dark rounded-2xl p-6 text-center cursor-pointer">
                <div class="w-12 h-12 mx-auto mb-3 bg-gradient-to-br from-purple-400/30 to-pink-400/30 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <p class="text-white/60 text-xs font-medium mb-2 uppercase tracking-wider">완료</p>
                <p id="completedCount" class="text-4xl font-bold text-white">0</p>
            </div>
            <div class="stat-card glass-dark rounded-2xl p-6 text-center cursor-pointer">
                <div class="w-12 h-12 mx-auto mb-3 bg-gradient-to-br from-purple-400/30 to-pink-400/30 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-white/60 text-xs font-medium mb-2 uppercase tracking-wider">남은 일</p>
                <p id="remainingCount" class="text-4xl font-bold text-white">0</p>
            </div>
        </div>
    </div>

    <script>
        // 전역 변수
        let currentDate = new Date();
        let todoIdCounter = Date.now();

        // 날짜 포맷팅 함수
        function formatDate(date) {
            const year = date.getFullYear();
            const month = date.getMonth() + 1;
            const day = date.getDate();
            const days = ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'];
            const dayName = days[date.getDay()];
            
            return {
                dateString: `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`,
                displayDate: `${year}년 ${month}월 ${day}일`,
                dayName: dayName
            };
        }

        // 날짜 표시 업데이트
        function updateDateDisplay() {
            const formatted = formatDate(currentDate);
            document.getElementById('dateDisplay').textContent = formatted.displayDate;
            document.getElementById('dayDisplay').textContent = formatted.dayName;
            renderCalendar();
        }

        // 오늘 날짜 확인
        function isToday(date) {
            const today = new Date();
            return date.getDate() === today.getDate() &&
                   date.getMonth() === today.getMonth() &&
                   date.getFullYear() === today.getFullYear();
        }

        // 선택한 날짜인지 확인
        function isSelectedDate(date) {
            return date.getDate() === currentDate.getDate() &&
                   date.getMonth() === currentDate.getMonth() &&
                   date.getFullYear() === currentDate.getFullYear();
        }

        // 캘린더 렌더링
        function renderCalendar() {
            const calendarGrid = document.getElementById('calendarGrid');
            const calendarMonth = document.getElementById('calendarMonth');
            
            // 현재 선택된 날짜의 년월
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            // 월 표시 업데이트
            calendarMonth.textContent = `${year}년 ${month + 1}월`;
            
            // 해당 월의 첫 번째 날과 마지막 날
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDayOfWeek = firstDay.getDay();
            
            // 오늘 날짜
            const today = new Date();
            
            let calendarHTML = '';
            
            // 이전 달의 마지막 날들 (빈 칸 채우기)
            const prevMonthLastDay = new Date(year, month, 0).getDate();
            for (let i = startingDayOfWeek - 1; i >= 0; i--) {
                const date = new Date(year, month - 1, prevMonthLastDay - i);
                calendarHTML += `
                    <div class="calendar-day p-2 text-center text-white/30 text-sm rounded-lg cursor-default">
                        ${prevMonthLastDay - i}
                    </div>
                `;
            }
            
            // 현재 달의 날들
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month, day);
                const isTodayDate = isToday(date);
                const isSelected = isSelectedDate(date);
                
                // 해당 날짜의 할 일 개수 확인
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const todos = getTodosForDate(dateString);
                const todoCount = todos.length;
                
                let classes = 'calendar-day p-2 text-center text-white text-sm rounded-lg cursor-pointer hover:bg-white/20 transition-all';
                
                if (isSelected) {
                    classes += ' selected';
                }
                if (isTodayDate) {
                    classes += ' today';
                }
                
                const badgeHTML = todoCount > 0 ? `<span class="todo-badge">${todoCount}</span>` : '';
                
                calendarHTML += `
                    <div 
                        class="${classes}"
                        onclick="selectCalendarDate(${year}, ${month}, ${day})"
                    >
                        ${day}
                        ${badgeHTML}
                    </div>
                `;
            }
            
            // 다음 달의 첫 날들 (빈 칸 채우기)
            const totalCells = startingDayOfWeek + daysInMonth;
            const remainingCells = 42 - totalCells; // 6주 * 7일 = 42
            for (let day = 1; day <= remainingCells && day <= 14; day++) {
                calendarHTML += `
                    <div class="calendar-day p-2 text-center text-white/30 text-sm rounded-lg cursor-default">
                        ${day}
                    </div>
                `;
            }
            
            calendarGrid.innerHTML = calendarHTML;
        }

        // 캘린더에서 날짜 선택
        function selectCalendarDate(year, month, day) {
            currentDate = new Date(year, month, day);
            updateDateDisplay();
            renderTodos();
            updateStats();
        }

        // 로컬 스토리지에서 할 일 가져오기
        function getTodosForDate(dateString) {
            const todos = localStorage.getItem(`todos_${dateString}`);
            return todos ? JSON.parse(todos) : [];
        }

        // 로컬 스토리지에 할 일 저장하기
        function saveTodosForDate(dateString, todos) {
            localStorage.setItem(`todos_${dateString}`, JSON.stringify(todos));
        }

        // 할 일 추가
        function addTodo(text) {
            if (!text.trim()) return;
            
            const formatted = formatDate(currentDate);
            const todos = getTodosForDate(formatted.dateString);
            
            const newTodo = {
                id: todoIdCounter++,
                text: text.trim(),
                completed: false
            };
            
            todos.push(newTodo);
            saveTodosForDate(formatted.dateString, todos);
            renderTodos();
            renderCalendar();
            updateStats();
            
            // 입력 필드 초기화
            document.getElementById('todoInput').value = '';
        }

        // 할 일 삭제
        function deleteTodo(id) {
            const formatted = formatDate(currentDate);
            const todos = getTodosForDate(formatted.dateString);
            const filteredTodos = todos.filter(todo => todo.id !== id);
            saveTodosForDate(formatted.dateString, filteredTodos);
            renderTodos();
            renderCalendar();
            updateStats();
        }

        // 할 일 완료 상태 토글
        function toggleTodo(id) {
            const formatted = formatDate(currentDate);
            const todos = getTodosForDate(formatted.dateString);
            const todo = todos.find(t => t.id === id);
            if (todo) {
                todo.completed = !todo.completed;
                saveTodosForDate(formatted.dateString, todos);
                renderTodos();
                renderCalendar();
                updateStats();
            }
        }

        // 할 일 목록 렌더링
        function renderTodos() {
            const formatted = formatDate(currentDate);
            const todos = getTodosForDate(formatted.dateString);
            const todoList = document.getElementById('todoList');
            const emptyState = document.getElementById('emptyState');
            
            if (todos.length === 0) {
                todoList.innerHTML = '';
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
                todoList.innerHTML = todos.map(todo => `
                    <div class="todo-item p-6 ${todo.completed ? 'bg-white/10' : ''} hover:bg-white/20 transition-all group">
                        <div class="flex items-center gap-4">
                            <input 
                                type="checkbox" 
                                ${todo.completed ? 'checked' : ''}
                                class="checkbox-custom"
                                onchange="toggleTodo(${todo.id})"
                            >
                            <span class="flex-1 text-lg font-medium group-hover:text-purple-200 transition-colors ${todo.completed ? 'text-white/60 line-through decoration-2 decoration-purple-300' : 'text-white'}">
                                ${todo.text}
                            </span>
                            <button 
                                onclick="deleteTodo(${todo.id})"
                                class="text-red-300/70 hover:text-red-400 transition-all p-3 hover:bg-red-500/20 rounded-xl backdrop-blur-sm transform hover:scale-110 active:scale-95"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `).join('');
            }
        }

        // 통계 업데이트
        function updateStats() {
            const formatted = formatDate(currentDate);
            const todos = getTodosForDate(formatted.dateString);
            const total = todos.length;
            const completed = todos.filter(t => t.completed).length;
            const remaining = total - completed;
            
            document.getElementById('totalCount').textContent = total;
            document.getElementById('completedCount').textContent = completed;
            document.getElementById('remainingCount').textContent = remaining;
        }

        // 날짜 변경
        function changeDate(days) {
            currentDate.setDate(currentDate.getDate() + days);
            updateDateDisplay();
            renderTodos();
            updateStats();
        }

        // 오늘로 이동
        function goToToday() {
            currentDate = new Date();
            updateDateDisplay();
            renderTodos();
            updateStats();
        }

        // 월 변경 (해당 월의 첫 번째 날로 이동)
        function changeMonth(months) {
            const newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + months, 1);
            currentDate = newDate;
            updateDateDisplay();
            renderTodos();
            updateStats();
        }

        // 이벤트 리스너 설정
        document.addEventListener('DOMContentLoaded', function() {
            // 초기화
            updateDateDisplay();
            renderCalendar();
            renderTodos();
            updateStats();
            
            // 추가 버튼
            document.getElementById('addButton').addEventListener('click', function() {
                const input = document.getElementById('todoInput');
                addTodo(input.value);
            });
            
            // Enter 키로 추가
            document.getElementById('todoInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    addTodo(this.value);
                }
            });
            
            // 날짜 이동 버튼
            document.getElementById('prevDateButton').addEventListener('click', function() {
                changeDate(-1);
            });
            
            document.getElementById('nextDateButton').addEventListener('click', function() {
                changeDate(1);
            });
            
            document.getElementById('todayButton').addEventListener('click', function() {
                goToToday();
            });
            
            // 월 이동 버튼 (캘린더)
            document.getElementById('prevMonthButton').addEventListener('click', function() {
                changeMonth(-1);
            });
            
            document.getElementById('nextMonthButton').addEventListener('click', function() {
                changeMonth(1);
            });
        });
    </script>
</body>
</html>
