<?php
session_start();
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIV RHEMAHOUSE - Church Accounting System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        navy: { 800: '#1e3a8a', 900: '#0f172a' },
                        brand: { red: '#dc2626' }
                    }
                }
            }
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Inter', sans-serif; 
            background: #f8fafc;
            overflow: hidden;
            height: 100vh;
        }
        
        .fade-in { 
            animation: fadeIn 0.3s ease-out; 
        }
        
        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(10px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        .toast { 
            position: fixed; 
            bottom: 20px; 
            right: 20px; 
            z-index: 1000; 
            animation: slideUp 0.3s ease; 
        }
        
        @keyframes slideUp { 
            from { transform: translateY(100px); opacity: 0; } 
            to { transform: translateY(0); opacity: 1; } 
        }
        
        .active-nav { 
            background-color: #1e3a8a !important; 
            color: white !important; 
        }
        
        .active-mobile { 
            color: #1e3a8a !important; 
        }
        
        /* Custom scrollbar for content area */
        #contentArea::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        #contentArea::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }
        
        #contentArea::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }
        
        #contentArea::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
        
        /* Ensure sidebar doesn't overflow */
        .sidebar-fixed {
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-fixed::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-fixed::-webkit-scrollbar-track {
            background: #0f172a;
        }
        
        .sidebar-fixed::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<!-- Login Page -->
<div id="loginPage" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900" <?php echo $isLoggedIn ? 'style="display:none"' : ''; ?>>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 mx-4">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-navy-100 mb-4">
                <i class="fas fa-church text-3xl text-navy-800"></i>
            </div>
            <h1 class="text-3xl font-bold text-navy-900">MIV RHEMAHOUSE</h1>
            <p class="text-slate-500 mt-2">Church Management System</p>
        </div>
        <form id="loginForm">
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                <input type="email" id="email" value="admin@rhema.com" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy-800 outline-none" required>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <input type="password" id="password" value="admin123" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy-800 outline-none" required>
            </div>
            <button type="submit" class="w-full bg-navy-800 text-white font-bold py-3 rounded-xl hover:bg-navy-900 transition">Sign In</button>
        </form>
    </div>
</div>

<!-- Main App - Fixed height layout -->
<div id="appWrapper" class="hidden h-screen w-full overflow-hidden flex flex-col md:flex-row" style="height: 100vh; max-height: 100vh;">
    
    <!-- Sidebar - Fixed height with scroll -->
    <aside class="hidden md:flex md:flex-col w-72 bg-navy-900 text-white shadow-xl sidebar-fixed">
        <div class="p-6 border-b border-navy-800 flex-shrink-0">
            <div class="flex items-center gap-3">
                <i class="fas fa-church text-2xl text-brand-red"></i>
                <span class="text-xl font-bold">RHEMAHOUSE</span>
            </div>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <button onclick="loadModule('dashboard')" class="nav-btn w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 hover:bg-navy-800 transition" data-module="dashboard">
                <i class="fas fa-chart-pie w-5"></i> Dashboard
            </button>
            <button onclick="loadModule('attendance')" class="nav-btn w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 hover:bg-navy-800 transition" data-module="attendance">
                <i class="fas fa-users w-5"></i> Attendance
            </button>
            <button onclick="loadModule('offerings')" class="nav-btn w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 hover:bg-navy-800 transition" data-module="offerings">
                <i class="fas fa-hand-holding-dollar w-5"></i> Tithes & Offerings
            </button>
            <button onclick="loadModule('expenses')" class="nav-btn w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 hover:bg-navy-800 transition" data-module="expenses">
                <i class="fas fa-file-invoice-dollar w-5"></i> Expenses
            </button>
        </nav>
        <div class="p-6 border-t border-navy-800 flex-shrink-0">
            <button onclick="logout()" class="w-full text-left text-navy-300 hover:text-white flex items-center gap-2 transition">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
    </aside>

    <!-- Main Content - Flex column with proper height -->
    <main class="flex-1 flex flex-col overflow-hidden bg-slate-50">
        <!-- Header - Fixed height -->
        <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center flex-shrink-0">
            <h2 id="pageTitle" class="text-xl font-bold text-navy-800">Dashboard</h2>
            <div class="flex gap-3">
                <button onclick="exportCSV()" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 hover:bg-green-700 transition">
                    <i class="fas fa-download"></i> Export CSV
                </button>
                <button onclick="openAddModal()" id="addBtn" class="bg-navy-800 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 hover:bg-navy-900 transition">
                    <i class="fas fa-plus"></i> Add
                </button>
            </div>
        </header>
        
        <!-- Scrollable Content Area -->
        <div id="contentArea" class="flex-1 overflow-y-auto p-6">
            <div id="dynamicContent">Loading...</div>
        </div>
    </main>

    <!-- Mobile Bottom Nav - Fixed at bottom -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t flex justify-around py-3 z-30 shadow-lg">
        <button onclick="loadModule('dashboard')" class="mobile-nav flex flex-col items-center gap-1 text-slate-400" data-mobile="dashboard">
            <i class="fas fa-chart-pie text-xl"></i>
            <span class="text-xs">Home</span>
        </button>
        <button onclick="loadModule('attendance')" class="mobile-nav flex flex-col items-center gap-1 text-slate-400" data-mobile="attendance">
            <i class="fas fa-users text-xl"></i>
            <span class="text-xs">Attendance</span>
        </button>
        <button onclick="loadModule('offerings')" class="mobile-nav flex flex-col items-center gap-1 text-slate-400" data-mobile="offerings">
            <i class="fas fa-hand-holding-dollar text-xl"></i>
            <span class="text-xs">Giving</span>
        </button>
        <button onclick="loadModule('expenses')" class="mobile-nav flex flex-col items-center gap-1 text-slate-400" data-mobile="expenses">
            <i class="fas fa-receipt text-xl"></i>
            <span class="text-xs">Expenses</span>
        </button>
    </div>
</div>

<!-- Modal -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b sticky top-0 bg-white z-10">
            <h3 id="modalTitle" class="text-xl font-bold text-navy-800">Add Record</h3>
            <button onclick="closeModal()" class="text-2xl hover:text-red-500 transition">&times;</button>
        </div>
        <form id="modalForm" class="p-6 space-y-4">
            <!-- Dynamic fields -->
        </form>
    </div>
</div>

<div id="toast" class="toast hidden px-5 py-3 rounded-xl shadow-lg flex items-center gap-2 z-50"></div>

<script>
let currentModule = 'dashboard';
let currentData = [];
let editId = null;

// ============ PAGE PERSISTENCE ============
function saveCurrentModule(module) {
    localStorage.setItem('currentModule', module);
    sessionStorage.setItem('currentModule', module);
}

function getSavedModule() {
    return sessionStorage.getItem('currentModule') || localStorage.getItem('currentModule') || 'dashboard';
}

function clearSavedModule() {
    localStorage.removeItem('currentModule');
    sessionStorage.removeItem('currentModule');
}

// ============ UI Active State Management ============
function updateActiveNav(module) {
    $('.nav-btn').removeClass('active-nav');
    $(`.nav-btn[data-module="${module}"]`).addClass('active-nav');
    
    $('.mobile-nav').removeClass('active-mobile text-navy-800').addClass('text-slate-400');
    $(`.mobile-nav[data-mobile="${module}"]`).removeClass('text-slate-400').addClass('active-mobile text-navy-800');
    
    const titles = {
        'dashboard': 'Dashboard',
        'attendance': 'Attendance Management',
        'offerings': 'Tithes & Offerings',
        'expenses': 'Expenses Management'
    };
    $('#pageTitle').text(titles[module] || module.charAt(0).toUpperCase() + module.slice(1));
}

// ============ Check authentication on page load ============
$(document).ready(function() {
    <?php if($isLoggedIn): ?>
    $('#loginPage').hide();
    $('#appWrapper').show();
    const savedModule = getSavedModule();
    loadModule(savedModule, true);
    <?php else: ?>
    $.get('api.php?action=checkAuth', function(res) {
        if(res.loggedIn === true) {
            $('#loginPage').hide();
            $('#appWrapper').show();
            const savedModule = getSavedModule();
            loadModule(savedModule, true);
        } else {
            $('#loginPage').show();
            $('#appWrapper').hide();
            clearSavedModule();
        }
    }, 'json').fail(function() {
        $('#loginPage').show();
        $('#appWrapper').hide();
    });
    <?php endif; ?>
});

// ============ Login ============
$('#loginForm').submit(function(e) {
    e.preventDefault();
    const btn = $(this).find('button[type="submit"]');
    const originalText = btn.html();
    btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Logging in...').prop('disabled', true);
    
    $.post('api.php?action=login', {email: $('#email').val(), password: $('#password').val()}, function(res) {
        if(res.status === 'success') {
            $('#loginPage').fadeOut(300, function() {
                $('#appWrapper').css('display', 'flex').hide().fadeIn(300);
                const savedModule = getSavedModule();
                loadModule(savedModule, true);
                showToast('Welcome back!', 'success');
            });
        } else {
            showToast('Invalid credentials', 'error');
            btn.html(originalText).prop('disabled', false);
        }
    }, 'json');
});

// ============ Logout ============
function logout() {
    if(confirm('Are you sure you want to logout?')) {
        $.get('api.php?action=logout', function() {
            clearSavedModule();
            $('#appWrapper').fadeOut(300, function() {
                $('#loginPage').fadeIn(300);
            });
            showToast('Logged out successfully', 'info');
        });
    }
}

// ============ Load Module with Persistence ============
function loadModule(module, isRestore = false) {
    const validModules = ['dashboard', 'attendance', 'offerings', 'expenses'];
    if(!validModules.includes(module)) {
        module = 'dashboard';
    }
    
    currentModule = module;
    editId = null;
    
    if(!isRestore) {
        saveCurrentModule(module);
    }
    
    updateActiveNav(module);
    
    $('#dynamicContent').html('<div class="flex justify-center items-center py-20"><i class="fas fa-spinner fa-spin text-4xl text-navy-600"></i><p class="mt-4 text-slate-500 ml-3">Loading ' + module + '...</p></div>');
    
    $.get(`api.php?action=get${module}`, function(res) {
        if(res.status === 'success') {
            currentData = res.data;
            if(module === 'dashboard') {
                renderDashboard(res.data);
            } else {
                renderTable(module, res.data);
            }
        } else if(res.redirect === true) {
            $('#appWrapper').hide();
            $('#loginPage').show();
            clearSavedModule();
            showToast('Session expired. Please login again.', 'warning');
        } else {
            $('#dynamicContent').html('<div class="text-center py-20 text-red-500"><i class="fas fa-exclamation-circle text-4xl mb-3"></i><p>Error loading data</p><button onclick="loadModule(\'' + module + '\')" class="mt-4 px-4 py-2 bg-navy-800 text-white rounded-lg">Retry</button></div>');
        }
    }, 'json').fail(function() {
        $('#dynamicContent').html('<div class="text-center py-20 text-red-500"><i class="fas fa-wifi text-4xl mb-3"></i><p>Network error. Please check your connection.</p><button onclick="loadModule(\'' + module + '\')" class="mt-4 px-4 py-2 bg-navy-800 text-white rounded-lg">Retry</button></div>');
    });
}

// ============ Dashboard Render ============
function renderDashboard(data) {
    const stats = data.stats;
    const recent = data.recent || [];
    const html = `
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8 fade-in">
            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-blue-500 hover:shadow-md transition">
                <p class="text-slate-500 text-sm">Total Attendance</p>
                <h3 class="text-2xl font-bold text-navy-800 mt-1">${(stats.totalAttendance || 0).toLocaleString()}</h3>
                <span class="text-xs text-green-600"><i class="fas fa-church"></i> All services</span>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-green-500 hover:shadow-md transition">
                <p class="text-slate-500 text-sm">Total Tithes</p>
                <h3 class="text-2xl font-bold text-green-600 mt-1">₦${(stats.totalTithe || 0).toLocaleString()}</h3>
                <span class="text-xs text-slate-400">Faithful contributions</span>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-amber-500 hover:shadow-md transition">
                <p class="text-slate-500 text-sm">Total Offerings</p>
                <h3 class="text-2xl font-bold text-amber-600 mt-1">₦${(stats.totalOffering || 0).toLocaleString()}</h3>
                <span class="text-xs text-slate-400">Special & Sunday</span>
            </div>
            <div class="bg-gradient-to-br from-navy-800 to-navy-900 text-white p-5 rounded-xl shadow-lg hover:shadow-xl transition">
                <p class="text-navy-200 text-sm">Net Balance</p>
                <h3 class="text-2xl font-bold mt-1">₦${(stats.netBalance || 0).toLocaleString()}</h3>
                <span class="text-xs text-navy-300"><i class="fas fa-wallet"></i> Available funds</span>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden fade-in">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-lg text-navy-800">Recent Transactions</h3>
                <button onclick="loadModule('offerings')" class="text-sm text-navy-600 hover:text-navy-800">View All <i class="fas fa-arrow-right ml-1"></i></button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-3 text-left text-sm font-semibold text-slate-600">Date</th>
                            <th class="p-3 text-left text-sm font-semibold text-slate-600">Description</th>
                            <th class="p-3 text-left text-sm font-semibold text-slate-600">Type</th>
                            <th class="p-3 text-right text-sm font-semibold text-slate-600">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        ${recent.length > 0 ? recent.map(t => `
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-3 text-slate-600">${t.date}</td>
                            <td class="p-3 font-medium text-navy-800">${t.description}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium ${t.type === 'Expense' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'}">
                                    ${t.type}
                                </span>
                            </td>
                            <td class="p-3 text-right font-bold ${t.type === 'Expense' ? 'text-red-600' : 'text-green-600'}">
                                ${t.type === 'Expense' ? '-' : '+'}₦${Number(t.amount).toLocaleString()}
                            </td>
                        </tr>
                        `).join('') : `
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400">
                                <i class="fas fa-inbox text-3xl mb-2 block"></i>
                                No recent transactions
                            </td>
                        </tr>
                        `}
                    </tbody>
                </table>
            </div>
        </div>
    `;
    $('#dynamicContent').html(html);
}

// ============ Table Render ============
function renderTable(module, data) {
    let headers = [], rows = '';
    
    if(module === 'attendance') {
        headers = ['Date', 'Male', 'Female', 'Children', 'Total', 'Actions'];
        rows = data.map(item => `
            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                <td class="p-3 text-navy-800 font-medium">${item.date}</td>
                <td class="p-3 text-slate-600">${item.male}</td>
                <td class="p-3 text-slate-600">${item.female}</td>
                <td class="p-3 text-slate-600">${item.children}</td>
                <td class="p-3 font-bold text-navy-800">${item.male + item.female + item.children}</td>
                <td class="p-3 text-right whitespace-nowrap">
                    <button onclick="editRecord(${item.id})" class="text-blue-600 hover:text-blue-800 mr-2 p-1"><i class="fas fa-edit"></i></button>
                    <button onclick="deleteRecord(${item.id})" class="text-red-600 hover:text-red-800 p-1"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `).join('');
    } 
    else if(module === 'offerings') {
        headers = ['Date', 'Payer', 'Type', 'Mode', 'Amount', 'Actions'];
        rows = data.map(item => `
            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                <td class="p-3 text-navy-800 font-medium">${item.date}</td>
                <td class="p-3 text-slate-700">${item.payer}</td>
                <td class="p-3"><span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">${item.type}</span></td>
                <td class="p-3 text-slate-500 text-sm">${item.mode}</td>
                <td class="p-3 font-bold text-green-600">₦${Number(item.amount).toLocaleString()}</td>
                <td class="p-3 text-right whitespace-nowrap">
                    <button onclick="editRecord(${item.id})" class="text-blue-600 hover:text-blue-800 mr-2 p-1"><i class="fas fa-edit"></i></button>
                    <button onclick="deleteRecord(${item.id})" class="text-red-600 hover:text-red-800 p-1"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `).join('');
    } 
    else {
        headers = ['Date', 'Purpose', 'Type', 'Amount', 'Actions'];
        rows = data.map(item => `
            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                <td class="p-3 text-navy-800 font-medium">${item.date}</td>
                <td class="p-3 text-slate-700">${item.purpose}</td>
                <td class="p-3"><span class="px-2 py-1 ${item.type === 'Expense' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'} rounded-full text-xs font-medium">${item.type}</span></td>
                <td class="p-3 font-bold ${item.type === 'Expense' ? 'text-red-600' : 'text-green-600'}">${item.type === 'Expense' ? '-' : '+'}₦${Number(item.amount).toLocaleString()}</td>
                <td class="p-3 text-right whitespace-nowrap">
                    <button onclick="editRecord(${item.id})" class="text-blue-600 hover:text-blue-800 mr-2 p-1"><i class="fas fa-edit"></i></button>
                    <button onclick="deleteRecord(${item.id})" class="text-red-600 hover:text-red-800 p-1"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `).join('');
    }
    
    const html = `
        <div class="bg-white rounded-xl shadow-sm overflow-hidden fade-in">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-100">
                        <tr>
                            ${headers.map(h => `<th class="p-3 text-left text-sm font-semibold text-slate-700">${h}</th>`).join('')}
                        </tr>
                    </thead>
                    <tbody>
                        ${rows || `
                        <tr>
                            <td colspan="${headers.length}" class="p-12 text-center text-slate-400">
                                <i class="fas fa-database text-4xl mb-3 block"></i>
                                <p>No records found</p>
                                <button onclick="openAddModal()" class="mt-3 text-navy-600 hover:text-navy-800 text-sm">
                                    <i class="fas fa-plus"></i> Add your first record
                                </button>
                            </td>
                        </tr>
                        `}
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-t border-slate-100 bg-slate-50 text-sm text-slate-500">
                <i class="fas fa-info-circle mr-1"></i> Total: ${data.length} record(s)
            </div>
        </div>
    `;
    $('#dynamicContent').html(html);
}

// ============ CRUD Operations ============
function openAddModal() {
    editId = null;
    $('#modalTitle').text(`Add New ${currentModule.slice(0,-1).toUpperCase()}`);
    let fields = '';
    
    if(currentModule === 'attendance') {
        fields = `
            <input type="hidden" name="action" value="saveAttendance">
            <div><label class="block text-sm font-medium mb-2">Service Date</label><input type="date" name="date" value="${new Date().toISOString().split('T')[0]}" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-navy-800 outline-none" required></div>
            <div class="grid grid-cols-2 gap-4"><div><label>Male</label><input type="number" name="male" class="w-full p-3 border rounded-xl" required></div><div><label>Female</label><input type="number" name="female" class="w-full p-3 border rounded-xl" required></div></div>
            <div><label>Children</label><input type="number" name="children" class="w-full p-3 border rounded-xl" required></div>
        `;
    } 
    else if(currentModule === 'offerings') {
        fields = `
            <input type="hidden" name="action" value="saveOffering">
            <div><label>Date</label><input type="date" name="date" value="${new Date().toISOString().split('T')[0]}" class="w-full p-3 border rounded-xl" required></div>
            <div><label>Payer Name</label><input type="text" name="payer" placeholder="e.g., John Doe" class="w-full p-3 border rounded-xl" required></div>
            <div class="grid grid-cols-2 gap-4"><div><label>Type</label><select name="type" class="w-full p-3 border rounded-xl"><option>Tithe</option><option>Offering</option></select></div><div><label>Mode</label><select name="mode" class="w-full p-3 border rounded-xl"><option>Cash</option><option>Transfer</option><option>Cheque</option></select></div></div>
            <div><label>Amount (₦)</label><input type="number" step="0.01" name="amount" placeholder="0.00" class="w-full p-3 border rounded-xl" required></div>
        `;
    } 
    else {
        fields = `
            <input type="hidden" name="action" value="saveExpense">
            <div><label>Date</label><input type="date" name="date" value="${new Date().toISOString().split('T')[0]}" class="w-full p-3 border rounded-xl" required></div>
            <div><label>Purpose/Description</label><input type="text" name="purpose" placeholder="e.g., Generator Fuel" class="w-full p-3 border rounded-xl" required></div>
            <div><label>Type</label><select name="type" class="w-full p-3 border rounded-xl"><option>Expense</option><option>Add Funds</option></select></div>
            <div><label>Amount (₦)</label><input type="number" step="0.01" name="amount" placeholder="0.00" class="w-full p-3 border rounded-xl" required></div>
        `;
    }
    
    $('#modalForm').html(fields + `<div class="flex gap-3 pt-4"><button type="button" onclick="closeModal()" class="flex-1 px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition">Cancel</button><button type="submit" class="flex-1 px-4 py-2 bg-navy-800 text-white rounded-lg hover:bg-navy-900 transition">Save Record</button></div>`);
    $('#modal').removeClass('hidden').addClass('flex');
}

function editRecord(id) {
    const item = currentData.find(i => i.id == id);
    if(!item) return;
    editId = id;
    $('#modalTitle').text(`Edit ${currentModule.slice(0,-1).toUpperCase()}`);
    let fields = '';
    
    if(currentModule === 'attendance') {
        fields = `
            <input type="hidden" name="action" value="saveAttendance">
            <input type="hidden" name="id" value="${item.id}">
            <div><label>Date</label><input type="date" name="date" value="${item.date}" class="w-full p-3 border rounded-xl" required></div>
            <div class="grid grid-cols-2 gap-4"><div><label>Male</label><input type="number" name="male" value="${item.male}" class="w-full p-3 border rounded-xl" required></div><div><label>Female</label><input type="number" name="female" value="${item.female}" class="w-full p-3 border rounded-xl" required></div></div>
            <div><label>Children</label><input type="number" name="children" value="${item.children}" class="w-full p-3 border rounded-xl" required></div>
        `;
    } 
    else if(currentModule === 'offerings') {
        fields = `
            <input type="hidden" name="action" value="saveOffering">
            <input type="hidden" name="id" value="${item.id}">
            <div><label>Date</label><input type="date" name="date" value="${item.date}" class="w-full p-3 border rounded-xl" required></div>
            <div><label>Payer</label><input type="text" name="payer" value="${item.payer}" class="w-full p-3 border rounded-xl" required></div>
            <div class="grid grid-cols-2 gap-4"><div><label>Type</label><select name="type" class="w-full p-3 border rounded-xl"><option ${item.type==='Tithe'?'selected':''}>Tithe</option><option ${item.type==='Offering'?'selected':''}>Offering</option></select></div><div><label>Mode</label><select name="mode" class="w-full p-3 border rounded-xl"><option ${item.mode==='Cash'?'selected':''}>Cash</option><option ${item.mode==='Transfer'?'selected':''}>Transfer</option><option ${item.mode==='Cheque'?'selected':''}>Cheque</option></select></div></div>
            <div><label>Amount</label><input type="number" step="0.01" name="amount" value="${item.amount}" class="w-full p-3 border rounded-xl" required></div>
        `;
    } 
    else {
        fields = `
            <input type="hidden" name="action" value="saveExpense">
            <input type="hidden" name="id" value="${item.id}">
            <div><label>Date</label><input type="date" name="date" value="${item.date}" class="w-full p-3 border rounded-xl" required></div>
            <div><label>Purpose</label><input type="text" name="purpose" value="${item.purpose}" class="w-full p-3 border rounded-xl" required></div>
            <div><label>Type</label><select name="type" class="w-full p-3 border rounded-xl"><option ${item.type==='Expense'?'selected':''}>Expense</option><option ${item.type==='Add Funds'?'selected':''}>Add Funds</option></select></div>
            <div><label>Amount</label><input type="number" step="0.01" name="amount" value="${item.amount}" class="w-full p-3 border rounded-xl" required></div>
        `;
    }
    
    $('#modalForm').html(fields + `<div class="flex gap-3 pt-4"><button type="button" onclick="closeModal()" class="flex-1 px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition">Cancel</button><button type="submit" class="flex-1 px-4 py-2 bg-navy-800 text-white rounded-lg hover:bg-navy-900 transition">Update Record</button></div>`);
    $('#modal').removeClass('hidden').addClass('flex');
}

$('#modalForm').submit(function(e) {
    e.preventDefault();
    const formData = $(this).serialize();
    const action = $('[name="action"]').val();
    
    $.post(`api.php?action=${action}`, formData, function(res) {
        if(res.status === 'success') {
            closeModal();
            loadModule(currentModule);
            showToast(editId ? 'Updated successfully!' : 'Added successfully!', 'success');
        } else {
            showToast('Error saving record', 'error');
        }
    }, 'json');
});

function deleteRecord(id) {
    if(confirm('⚠️ Are you sure you want to delete this record permanently?\nThis action cannot be undone.')) {
        $.post('api.php?action=deleteRecord', {id: id, module: currentModule}, function(res) {
            if(res.status === 'success') {
                loadModule(currentModule);
                showToast('Record deleted successfully', 'success');
            }
        }, 'json');
    }
}

function exportCSV() {
    if(!currentData.length) {
        showToast('No data to export', 'warning');
        return;
    }
    
    let csv = [];
    if(currentModule === 'attendance') {
        csv = [['ID','Date','Male','Female','Children','Total']];
        currentData.forEach(row => {
            csv.push([row.id, row.date, row.male, row.female, row.children, row.male+row.female+row.children]);
        });
    } 
    else if(currentModule === 'offerings') {
        csv = [['ID','Date','Payer','Type','Mode','Amount']];
        currentData.forEach(row => {
            csv.push([row.id, row.date, row.payer, row.type, row.mode, row.amount]);
        });
    } 
    else {
        csv = [['ID','Date','Purpose','Type','Amount']];
        currentData.forEach(row => {
            csv.push([row.id, row.date, row.purpose, row.type, row.amount]);
        });
    }
    
    const csvContent = csv.map(r => r.join(',')).join('\n');
    const blob = new Blob(["\uFEFF" + csvContent], {type: 'text/csv;charset=utf-8;'});
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.href = url;
    link.setAttribute('download', `${currentModule}_export_${new Date().toISOString().slice(0,19)}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    showToast(`Exported ${currentData.length} records`, 'success');
}

function closeModal() { 
    $('#modal').addClass('hidden').removeClass('flex');
    $('#modalForm').trigger('reset');
}

function showToast(msg, type) {
    const icon = type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle');
    const bgColor = type === 'success' ? 'bg-green-600' : (type === 'error' ? 'bg-red-600' : 'bg-navy-800');
    $('#toast').removeClass('bg-navy-800 bg-green-600 bg-red-600').addClass(bgColor);
    $('#toast').html(`<i class="fas ${icon} mr-2"></i>${msg}`).removeClass('hidden').fadeIn(200);
    setTimeout(() => $('#toast').fadeOut(300), 3000);
}
</script>
</body>
</html>