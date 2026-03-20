<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once "config/database.php";
require_once "models/Auth.php";
require_once "models/Attendance.php";
require_once "models/Offering.php";
require_once "models/Expense.php";

// Initialize database
$database = new Database();
$db = $database->getConnection();

// Initialize Auth
$auth = new Auth($db);

// Handle login
if(isset($_GET['action']) && $_GET['action'] == 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if($auth->login($email, $password)) {
        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
    }
    exit;
}

// Handle logout
if(isset($_GET['action']) && $_GET['action'] == 'logout') {
    $auth->logout();
    echo json_encode(['status' => 'success', 'message' => 'Logged out']);
    exit;
}

// Check authentication status (for page refresh)
if(isset($_GET['action']) && $_GET['action'] == 'checkAuth') {
    echo json_encode(['status' => 'success', 'loggedIn' => $auth->isLoggedIn()]);
    exit;
}

// Check authentication for all other requests
if(!$auth->isLoggedIn()) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized', 'redirect' => true]);
    exit;
}

// Initialize models
$attendanceModel = new Attendance($db);
$offeringModel = new Offering($db);
$expenseModel = new Expense($db);

$action = $_GET['action'] ?? '';

// Dashboard
if($action == 'getdashboard') {
    $attendance = $attendanceModel->getAll();
    $offerings = $offeringModel->getAll();
    $expenses = $expenseModel->getAll();
    
    $totalAttendance = array_sum(array_map(function($a) { return $a['male'] + $a['female'] + $a['children']; }, $attendance));
    $totalTithe = array_sum(array_filter(array_map(function($o) { return $o['type'] == 'Tithe' ? $o['amount'] : 0; }, $offerings)));
    $totalOffering = array_sum(array_filter(array_map(function($o) { return $o['type'] == 'Offering' ? $o['amount'] : 0; }, $offerings)));
    $totalExpenses = array_sum(array_filter(array_map(function($e) { return $e['type'] == 'Expense' ? $e['amount'] : 0; }, $expenses)));
    $totalFunds = array_sum(array_filter(array_map(function($e) { return $e['type'] == 'Add Funds' ? $e['amount'] : 0; }, $expenses)));
    
    $netBalance = $totalTithe + $totalOffering + $totalFunds - $totalExpenses;
    
    // Get recent transactions
    $recent = [];
    foreach($offerings as $o) {
        $recent[] = ['date' => $o['date'], 'description' => $o['payer'], 'type' => $o['type'], 'amount' => $o['amount']];
    }
    foreach($expenses as $e) {
        $recent[] = ['date' => $e['date'], 'description' => $e['purpose'], 'type' => $e['type'], 'amount' => $e['amount']];
    }
    usort($recent, function($a, $b) { return strtotime($b['date']) - strtotime($a['date']); });
    $recent = array_slice($recent, 0, 5);
    
    echo json_encode([
        'status' => 'success',
        'data' => [
            'stats' => [
                'totalAttendance' => $totalAttendance,
                'totalTithe' => $totalTithe,
                'totalOffering' => $totalOffering,
                'netBalance' => $netBalance
            ],
            'recent' => $recent
        ]
    ]);
    exit;
}

// Get data endpoints
if($action == 'getattendance') {
    if(isset($_GET['id'])) {
        echo json_encode(['status' => 'success', 'data' => $attendanceModel->getById($_GET['id'])]);
    } else {
        echo json_encode(['status' => 'success', 'data' => $attendanceModel->getAll()]);
    }
    exit;
}

if($action == 'getofferings') {
    if(isset($_GET['id'])) {
        echo json_encode(['status' => 'success', 'data' => $offeringModel->getById($_GET['id'])]);
    } else {
        echo json_encode(['status' => 'success', 'data' => $offeringModel->getAll()]);
    }
    exit;
}

if($action == 'getexpenses') {
    if(isset($_GET['id'])) {
        echo json_encode(['status' => 'success', 'data' => $expenseModel->getById($_GET['id'])]);
    } else {
        echo json_encode(['status' => 'success', 'data' => $expenseModel->getAll()]);
    }
    exit;
}

// Save endpoints
if($action == 'saveAttendance') {
    $data = $_POST;
    $success = isset($data['id']) && $data['id'] ? 
               $attendanceModel->update($data) : 
               $attendanceModel->create($data);
    echo json_encode(['status' => $success ? 'success' : 'error']);
    exit;
}

if($action == 'saveOffering') {
    $data = $_POST;
    $success = isset($data['id']) && $data['id'] ? 
               $offeringModel->update($data) : 
               $offeringModel->create($data);
    echo json_encode(['status' => $success ? 'success' : 'error']);
    exit;
}

if($action == 'saveExpense') {
    $data = $_POST;
    $success = isset($data['id']) && $data['id'] ? 
               $expenseModel->update($data) : 
               $expenseModel->create($data);
    echo json_encode(['status' => $success ? 'success' : 'error']);
    exit;
}

// Delete endpoint
if($action == 'deleteRecord') {
    $id = $_POST['id'] ?? 0;
    $module = $_POST['module'] ?? '';
    $success = false;
    
    if($module == 'attendance') $success = $attendanceModel->delete($id);
    elseif($module == 'offerings') $success = $offeringModel->delete($id);
    elseif($module == 'expenses') $success = $expenseModel->delete($id);
    
    echo json_encode(['status' => $success ? 'success' : 'error']);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>