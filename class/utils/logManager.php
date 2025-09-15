<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/LoggerOscar.php';

class EnhancedLogManager
{
    private string $logFile;
    private array $logLevels = ['ERROR', 'WARNING', 'INFO', 'DEBUG', 'SUCCESS'];

    public function __construct(string $logFile = __DIR__ . '/logs/astracore.log')
    {
        $this->logFile = $logFile;
        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) mkdir($logDir, 0777, true);
    }

    public function flush(): void
    {
        file_put_contents($this->logFile, '');
    }

    public function download(): void
    {
        if (!file_exists($this->logFile)) return;
        header('Content-Disposition: attachment; filename="astracore.log"');
        header('Content-Type: text/plain');
        readfile($this->logFile);
        exit();
    }

    public function getTotalLogs(): int
    {
        if (!file_exists($this->logFile)) return 0;
        return count(file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
    }

    public function getLogsPaginated(int $page = 1, int $perPage = 50, ?string $keyword = null, ?string $category = null, ?string $sessionId = null): array
    {
        if (!file_exists($this->logFile)) return ['logs' => [], 'total' => 0, 'pages' => 0];

        $allLogs = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $allLogs = array_reverse($allLogs); // Most recent first

        // Filter logs
        $filteredLogs = array_filter($allLogs, function ($line) use ($keyword, $category, $sessionId) {
            if ($keyword !== null && stripos($line, $keyword) === false) return false;
            if ($category !== null && stripos($line, "Category: $category") === false) return false;
            if ($sessionId !== null && stripos($line, "SessionID: $sessionId") === false) return false;
            return true;
        });

        $total = count($filteredLogs);
        $totalPages = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;
        $pagedLogs = array_slice($filteredLogs, $offset, $perPage);

        return [
            'logs' => $pagedLogs,
            'total' => $total,
            'pages' => $totalPages,
            'current_page' => $page,
            'per_page' => $perPage
        ];
    }

    public function getLogStats(): array
    {
        if (!file_exists($this->logFile)) return [];

        $logs = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $stats = ['total' => count($logs)];

        foreach ($this->logLevels as $level) {
            $stats[strtolower($level)] = count(array_filter($logs, function ($line) use ($level) {
                return stripos($line, $level) !== false;
            }));
        }

        return $stats;
    }

    public function searchLogs(string $query): array
    {
        if (!file_exists($this->logFile)) return [];

        $logs = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $logs = array_reverse($logs);

        return array_filter($logs, function ($line) use ($query) {
            return stripos($line, $query) !== false;
        });
    }
}

$manager = new EnhancedLogManager();

// Handle AJAX requests
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');

    if ($_GET['ajax'] === 'search') {
        $query = $_GET['q'] ?? '';
        $results = $manager->searchLogs($query);
        echo json_encode(array_slice($results, 0, 20)); // Limit to 20 results
        exit();
    }

    if ($_GET['ajax'] === 'logs') {
        $page = (int)($_GET['page'] ?? 1);
        $perPage = (int)($_GET['per_page'] ?? 50);
        $keyword = $_GET['keyword'] ?? null;
        $category = $_GET['category'] ?? null;
        $session = $_GET['session'] ?? null;

        $result = $manager->getLogsPaginated($page, $perPage, $keyword, $category, $session);
        echo json_encode($result);
        exit();
    }

    if ($_GET['ajax'] === 'stats') {
        echo json_encode($manager->getLogStats());
        exit();
    }
}

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['flush'])) {
        $manager->flush();
        $message = "✅ Logs flushed successfully!";
    } elseif (isset($_POST['download'])) {
        $manager->download();
    }
}

$stats = $manager->getLogStats();
$initialData = $manager->getLogsPaginated(1, 50);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Astracore Log Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-tertiary: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --info: #06b6d4;
            --border: #e2e8f0;
            --border-hover: #cbd5e1;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        }

        .card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .card-header {
            background-color: var(--bg-tertiary);
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            color: var(--text-primary);
        }

        .log-container {
            background-color: #fafafa;
            border-radius: 8px;
            font-family: 'JetBrains Mono', 'Fira Code', 'Consolas', monospace;
            font-size: 13px;
            line-height: 1.5;
            max-height: 600px;
            overflow-y: auto;
            border: 1px solid var(--border);
        }

        .log-line {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f1f1;
            word-wrap: break-word;
            transition: all 0.2s ease;
            cursor: pointer;
            position: relative;
            color: var(--text-primary);
            background-color: #ffffff;
        }

        .log-line:nth-child(even) {
            background-color: #fafafa;
        }

        .log-line:hover {
            background-color: #e0f2fe;
            transform: translateX(2px);
        }

        .log-line.truncated {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .log-line.expanded {
            white-space: pre-wrap;
            background-color: #f0f9ff;
            border: 1px solid var(--accent);
            border-radius: 4px;
            margin: 2px 0;
        }

        .log-level-ERROR {
            border-left: 4px solid var(--error);
            background-color: #fef2f2;
        }

        .log-level-WARNING {
            border-left: 4px solid var(--warning);
            background-color: #fffbeb;
        }

        .log-level-INFO {
            border-left: 4px solid var(--info);
            background-color: #f0fdfa;
        }

        .log-level-DEBUG {
            border-left: 4px solid var(--text-muted);
            background-color: #f8fafc;
        }

        .log-level-SUCCESS {
            border-left: 4px solid var(--success);
            background-color: #ecfdf5;
        }

        .stats-card {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            border: 1px solid var(--border);
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn-custom {
            background-color: var(--accent);
            border-color: var(--accent);
            color: white;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-custom:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
            color: white;
            transform: translateY(-1px);
        }

        .form-control,
        .form-select {
            background-color: var(--bg-secondary);
            border-color: var(--border);
            color: var(--text-primary);
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--bg-secondary);
            border-color: var(--accent);
            color: var(--text-primary);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.1);
        }

        .pagination .page-link {
            background-color: var(--bg-secondary);
            border-color: var(--border);
            color: var(--text-primary);
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background-color: var(--bg-tertiary);
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        .search-container {
            position: relative;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 8px;
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .search-result-item {
            padding: 10px 14px;
            cursor: pointer;
            font-size: 12px;
            font-family: monospace;
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
            transition: background-color 0.2s ease;
        }

        .search-result-item:hover {
            background-color: var(--bg-tertiary);
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: var(--text-muted);
        }

        .expand-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.6;
            font-size: 12px;
            color: var(--accent);
        }

        .alert {
            border: none;
            border-radius: 8px;
        }

        .badge {
            font-weight: 500;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: var(--text-primary);
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        @media (max-width: 768px) {
            .log-container {
                font-size: 11px;
                max-height: 400px;
            }

            .log-line {
                padding: 8px 10px;
            }

            .stats-card {
                margin-bottom: 1rem;
            }
        }

        /* Scrollbar styling */
        .log-container::-webkit-scrollbar {
            width: 8px;
        }

        .log-container::-webkit-scrollbar-track {
            background: var(--bg-tertiary);
            border-radius: 4px;
        }

        .log-container::-webkit-scrollbar-thumb {
            background: var(--border-hover);
            border-radius: 4px;
        }

        .log-container::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col">
                <h1 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-file-alt me-3" style="color: var(--accent);"></i>
                    Enhanced Astracore Log Manager
                </h1>
                <p class="text-muted mb-0">Advanced log viewing and management system</p>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistics Row -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <h5 class="card-title text-info">Total</h5>
                        <h3 class="mb-0" id="stat-total"><?= $stats['total'] ?? 0 ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="color: var(--error);">Errors</h5>
                        <h3 class="mb-0" id="stat-error"><?= $stats['error'] ?? 0 ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="color: var(--warning);">Warnings</h5>
                        <h3 class="mb-0" id="stat-warning"><?= $stats['warning'] ?? 0 ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="color: var(--info);">Info</h5>
                        <h3 class="mb-0" id="stat-info"><?= $stats['info'] ?? 0 ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="color: var(--success);">Success</h5>
                        <h3 class="mb-0" id="stat-success"><?= $stats['success'] ?? 0 ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <h5 class="card-title text-secondary">Debug</h5>
                        <h3 class="mb-0" id="stat-debug"><?= $stats['debug'] ?? 0 ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i>Controls & Filters</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="search-container">
                            <label class="form-label">Live Search</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="liveSearch" placeholder="Search logs...">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <div class="search-results" id="searchResults"></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Keyword Filter</label>
                        <input type="text" class="form-control" id="keyword" placeholder="Filter keyword">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" placeholder="Category">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Session ID</label>
                        <input type="text" class="form-control" id="session" placeholder="Session ID">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Logs per page</label>
                        <select class="form-select" id="perPage">
                            <option value="25">25</option>
                            <option value="50" selected>50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Max Length</label>
                        <select class="form-select" id="maxLength">
                            <option value="100">100</option>
                            <option value="200" selected>200</option>
                            <option value="500">500</option>
                            <option value="0">No limit</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-custom me-2" onclick="applyFilters()">
                            <i class="fas fa-filter me-1"></i>Apply Filters
                        </button>
                        <button type="button" class="btn btn-secondary me-2" onclick="clearFilters()">
                            <i class="fas fa-eraser me-1"></i>Clear
                        </button>
                        <form method="post" class="d-inline">
                            <button type="submit" name="flush" class="btn btn-danger me-2" onclick="return confirm('Are you sure you want to flush all logs?')">
                                <i class="fas fa-trash me-1"></i>Flush Logs
                            </button>
                        </form>
                        <form method="post" class="d-inline">
                            <button type="submit" name="download" class="btn btn-success">
                                <i class="fas fa-download me-1"></i>Download
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logs Display -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Logs</h5>
                <div class="d-flex align-items-center">
                    <span class="badge bg-info me-2" id="logCount">Loading...</span>
                    <button class="btn btn-sm btn-outline-light" onclick="toggleAutoRefresh()">
                        <i class="fas fa-sync-alt" id="refreshIcon"></i> Auto-refresh
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="log-container" id="logContainer">
                    <div class="loading">
                        <i class="fas fa-spinner fa-spin"></i> Loading logs...
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <nav>
                    <ul class="pagination justify-content-center mb-0" id="pagination">
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentPage = 1;
        let currentData = null;
        let autoRefreshInterval = null;
        let searchTimeout = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadLogs();
            setupEventListeners();
        });

        function setupEventListeners() {
            // Live search
            document.getElementById('liveSearch').addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => liveSearch(e.target.value), 300);
            });

            // Click outside to hide search results
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.search-container')) {
                    document.getElementById('searchResults').style.display = 'none';
                }
            });

            // Filter inputs
            ['keyword', 'category', 'session', 'perPage'].forEach(id => {
                document.getElementById(id).addEventListener('keyup', function(e) {
                    if (e.key === 'Enter') applyFilters();
                });
            });

            document.getElementById('perPage').addEventListener('change', applyFilters);
        }

        function loadLogs(page = 1) {
            const params = new URLSearchParams({
                ajax: 'logs',
                page: page,
                per_page: document.getElementById('perPage').value,
                keyword: document.getElementById('keyword').value || '',
                category: document.getElementById('category').value || '',
                session: document.getElementById('session').value || ''
            });

            fetch(`?${params}`)
                .then(response => response.json())
                .then(data => {
                    currentData = data;
                    currentPage = page;
                    renderLogs(data.logs);
                    renderPagination(data);
                    updateLogCount(data);
                })
                .catch(error => {
                    console.error('Error loading logs:', error);
                    document.getElementById('logContainer').innerHTML = '<div class="text-center p-4 text-danger">Error loading logs</div>';
                });
        }

        function renderLogs(logs) {
            const container = document.getElementById('logContainer');
            const maxLength = parseInt(document.getElementById('maxLength').value);

            if (logs.length === 0) {
                container.innerHTML = '<div class="text-center p-4 text-muted">No logs found</div>';
                return;
            }

            const logHtml = logs.map((log, index) => {
                const level = detectLogLevel(log);
                const shouldTruncate = maxLength > 0 && log.length > maxLength;
                const displayLog = shouldTruncate ? log.substring(0, maxLength) + '...' : log;

                return `
                    <div class="log-line log-level-${level} ${shouldTruncate ? 'truncated' : ''}" 
                         onclick="toggleLogExpansion(this, '${escapeHtml(log)}')"
                         data-full-log="${escapeHtml(log)}">
                        ${escapeHtml(displayLog)}
                        ${shouldTruncate ? '<i class="expand-icon fas fa-expand-arrows-alt"></i>' : ''}
                    </div>
                `;
            }).join('');

            container.innerHTML = logHtml;
        }

        function detectLogLevel(log) {
            const logUpper = log.toUpperCase();
            if (logUpper.includes('ERROR')) return 'ERROR';
            if (logUpper.includes('WARNING') || logUpper.includes('WARN')) return 'WARNING';
            if (logUpper.includes('INFO')) return 'INFO';
            if (logUpper.includes('DEBUG')) return 'DEBUG';
            if (logUpper.includes('SUCCESS')) return 'SUCCESS';
            return 'INFO';
        }

        function toggleLogExpansion(element, fullLog) {
            if (element.classList.contains('truncated')) {
                element.classList.remove('truncated');
                element.classList.add('expanded');
                element.innerHTML = escapeHtml(fullLog) + '<i class="expand-icon fas fa-compress-arrows-alt"></i>';
            } else if (element.classList.contains('expanded')) {
                element.classList.remove('expanded');
                element.classList.add('truncated');
                const maxLength = parseInt(document.getElementById('maxLength').value);
                const displayLog = fullLog.substring(0, maxLength) + '...';
                element.innerHTML = escapeHtml(displayLog) + '<i class="expand-icon fas fa-expand-arrows-alt"></i>';
            }
        }

        function renderPagination(data) {
            const pagination = document.getElementById('pagination');
            if (data.pages <= 1) {
                pagination.innerHTML = '';
                return;
            }

            let paginationHtml = '';

            // Previous button
            if (data.current_page > 1) {
                paginationHtml += `<li class="page-item">
                    <a class="page-link" href="#" onclick="loadLogs(${data.current_page - 1}); return false;">Previous</a>
                </li>`;
            }

            // Page numbers
            const start = Math.max(1, data.current_page - 2);
            const end = Math.min(data.pages, data.current_page + 2);

            if (start > 1) {
                paginationHtml += `<li class="page-item">
                    <a class="page-link" href="#" onclick="loadLogs(1); return false;">1</a>
                </li>`;
                if (start > 2) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }

            for (let i = start; i <= end; i++) {
                paginationHtml += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="loadLogs(${i}); return false;">${i}</a>
                </li>`;
            }

            if (end < data.pages) {
                if (end < data.pages - 1) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                paginationHtml += `<li class="page-item">
                    <a class="page-link" href="#" onclick="loadLogs(${data.pages}); return false;">${data.pages}</a>
                </li>`;
            }

            // Next button
            if (data.current_page < data.pages) {
                paginationHtml += `<li class="page-item">
                    <a class="page-link" href="#" onclick="loadLogs(${data.current_page + 1}); return false;">Next</a>
                </li>`;
            }

            pagination.innerHTML = paginationHtml;
        }

        function updateLogCount(data) {
            document.getElementById('logCount').textContent = `${data.total} logs`;
        }

        function liveSearch(query) {
            if (query.length < 2) {
                document.getElementById('searchResults').style.display = 'none';
                return;
            }

            fetch(`?ajax=search&q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(results => {
                    const container = document.getElementById('searchResults');
                    if (results.length === 0) {
                        container.innerHTML = '<div class="search-result-item text-muted">No results found</div>';
                    } else {
                        const maxLength = 100;
                        container.innerHTML = results.map(result => {
                            const truncated = result.length > maxLength ? result.substring(0, maxLength) + '...' : result;
                            return `<div class="search-result-item" onclick="highlightLog('${escapeHtml(result)}')">${escapeHtml(truncated)}</div>`;
                        }).join('');
                    }
                    container.style.display = 'block';
                })
                .catch(error => console.error('Search error:', error));
        }

        function highlightLog(logText) {
            document.getElementById('searchResults').style.display = 'none';
            document.getElementById('liveSearch').value = '';
            // Here you could implement highlighting the specific log in the main view
        }

        function applyFilters() {
            currentPage = 1;
            loadLogs(1);
        }

        function clearFilters() {
            ['keyword', 'category', 'session', 'liveSearch'].forEach(id => {
                document.getElementById(id).value = '';
            });
            document.getElementById('perPage').value = '50';
            document.getElementById('maxLength').value = '200';
            document.getElementById('searchResults').style.display = 'none';
            loadLogs(1);
        }

        function toggleAutoRefresh() {
            const icon = document.getElementById('refreshIcon');
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
                autoRefreshInterval = null;
                icon.classList.remove('fa-spin');
            } else {
                autoRefreshInterval = setInterval(() => {
                    loadLogs(currentPage);
                    updateStats();
                }, 5000);
                icon.classList.add('fa-spin');
            }
        }

        function updateStats() {
            fetch('?ajax=stats')
                .then(response => response.json())
                .then(stats => {
                    Object.keys(stats).forEach(key => {
                        const element = document.getElementById(`stat-${key}`);
                        if (element) element.textContent = stats[key];
                    });
                })
                .catch(error => console.error('Stats update error:', error));
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
    <div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p>This was made by <a href="https://fauza.dev">FauZa</a> in 5 minute so 🤫</p>
    </div>
</body>

</html>