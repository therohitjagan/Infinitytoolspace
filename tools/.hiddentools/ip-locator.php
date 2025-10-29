<?php
$ip = '';
$data = null;
$self_ip = $_SERVER['REMOTE_ADDR'];
$history = json_decode($_COOKIE['ip_history'] ?? '[]', true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $ip = trim($_POST['ip']);
    if (empty($ip)) {
        $ip = $self_ip;
    }
    
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        // Add to history
        if (!in_array($ip, $history)) {
            array_unshift($history, $ip);
            $history = array_slice($history, 0, 5);
            setcookie('ip_history', json_encode($history), time() + 30 * 86400, '/');
        }
        
        // Try multiple API endpoints
        $apis = [
            "https://ipapi.co/{$ip}/json/",
            "http://ip-api.com/json/{$ip}?fields=status,message,continent,continentCode,country,countryCode,region,regionName,city,district,zip,lat,lon,timezone,offset,currency,isp,org,as,asname,reverse,mobile,proxy,hosting,query"
        ];
        
        foreach ($apis as $url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            
            $data = json_decode($response);
            if ($data && (!isset($data->status) || $data->status === 'success')) {
                break;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Locator - Advanced IP Address Tracking & Geolocation</title>
    <meta name="description" content="Free Advanced IP Location Finder with detailed geolocation, threat analysis, network information, and interactive map. Track any IP address with professional tools.">
    <meta name="keywords" content="ip tracker, geolocation, ip lookup, network analysis, threat detection, ip mapper, ip analyzer">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #4cc9f0;
            --text-color: #2b2d42;
            --light-text: #8d99ae;
            --bg-gradient: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            --card-bg: #ffffff;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            color: var(--text-color);
            padding-bottom: 50px;
        }
        
        .container {
            max-width: 1200px;
        }
        
        .card {
            background: var(--card-bg);
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            border: none;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 25px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .header-section {
            padding: 60px 0 40px;
        }
        
        .header-section h1 {
            font-weight: 700;
            font-size: 2.8rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .header-section p {
            font-size: 1.2rem;
            opacity: 0.9;
            color: white;
        }
        
        .search-card {
            padding: 25px;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 20px;
            font-size: 1rem;
            border: 1px solid #e9ecef;
            box-shadow: none;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }
        
        .history-chip {
            background: rgba(67, 97, 238, 0.1);
            border-radius: 30px;
            padding: 8px 15px;
            margin: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.85rem;
            color: var(--primary-color);
            display: inline-flex;
            align-items: center;
        }
        
        .history-chip:hover {
            background: rgba(67, 97, 238, 0.2);
            transform: translateY(-2px);
        }
        
        .history-chip i {
            margin-right: 5px;
        }
        
        #map {
            height: 350px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 15px 25px;
            border-bottom: none;
            font-weight: 600;
        }
        
        .result-section {
            padding: 0;
        }
        
        .result-card {
            margin-bottom: 0;
            border-radius: 0;
        }
        
        .result-item {
            margin-bottom: 15px;
        }
        
        .result-item strong {
            display: block;
            color: var(--light-text);
            font-size: 0.85rem;
            margin-bottom: 5px;
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary-color);
            position: relative;
            padding-left: 15px;
        }
        
        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 5px;
            background: var(--primary-color);
            border-radius: 10px;
        }
        
        .export-btn-group {
            position: absolute;
            right: 15px;
            top: 12px;
        }
        
        .export-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 12px;
            font-size: 0.8rem;
            margin-left: 5px;
            transition: all 0.3s;
        }
        
        .export-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .detail-card {
            padding: 30px;
        }
        
        .detail-section {
            margin-bottom: 30px;
        }
        
        .detail-section:last-child {
            margin-bottom: 0;
        }
        
        .seo-content {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 40px;
            backdrop-filter: blur(10px);
            margin-top: 50px;
        }
        
        .seo-content h2 {
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .seo-content h3 {
            font-weight: 600;
            margin: 25px 0 15px;
        }
        
        .seo-content ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .seo-content li {
            background: rgba(255, 255, 255, 0.15);
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.9rem;
        }
        
        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s;
        }
        
        .loader-overlay.active {
            visibility: visible;
            opacity: 1;
        }
        
        .loader {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.2);
            border-top-color: white;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-section h1 {
                font-size: 2rem;
            }
            
            .header-section p {
                font-size: 1rem;
            }
            
            .detail-card {
                padding: 20px;
            }
            
            #map {
                height: 250px;
            }
            
            .seo-content {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header-section text-center">
            <h1>Advanced IP Locator</h1>
            <p>Comprehensive IP Analysis with Geolocation, Network Details & Threat Data</p>
        </div>

        <!-- Search Card -->
        <div class="card search-card">
            <form method="POST" class="search-box">
                <div class="input-group">
                    <input type="text" name="ip" class="form-control" 
                           placeholder="Enter IP Address (e.g., <?= $self_ip ?>)" 
                           value="<?= htmlspecialchars($ip) ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>
                        <span class="submit-text">Analyze IP</span>
                    </button>
                </div>
                <?php if(!empty($history)): ?>
                <div class="mt-3 d-flex flex-wrap">
                    <div class="me-2 mt-1 text-muted small">Recent searches:</div>
                    <?php foreach($history as $h): ?>
                    <div class="history-chip" onclick="document.querySelector('[name=ip]').value='<?= $h ?>'">
                        <i class="fas fa-history"></i>
                        <?= htmlspecialchars($h) ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </form>
        </div>

        <?php if ($data && (!isset($data->status) || $data->status === 'success')) { ?>
        <!-- Results Section -->
        <div class="card result-card">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    Results for <?= htmlspecialchars($data->ip ?? $data->query) ?>
                </h5>
                <div class="export-btn-group ms-auto">
                    <button class="export-btn" onclick="exportJSON()">
                        <i class="fas fa-download me-1"></i> JSON
                    </button>
                    <button class="export-btn" onclick="exportCSV()">
                        <i class="fas fa-table me-1"></i> CSV
                    </button>
                </div>
            </div>
            
            <div class="card-body detail-card">
                <!-- Map Section -->
                <div id="map" class="mb-4"></div>
                
                <div class="row">
                    <div class="col-lg-4">
                        <!-- Geolocation Details -->
                        <div class="detail-section">
                            <h6 class="section-title">
                                <i class="fas fa-globe-americas me-2"></i> Geolocation
                            </h6>
                            <div class="result-item">
                                <strong>Country</strong>
                                <?= $data->country_name ?? $data->country ?>
                            </div>
                            <div class="result-item">
                                <strong>City</strong>
                                <?= $data->city ?>
                            </div>
                            <div class="result-item">
                                <strong>Coordinates</strong>
                                <?= $data->latitude ?? $data->lat ?>, <?= $data->longitude ?? $data->lon ?>
                            </div>
                            <div class="result-item">
                                <strong>Timezone</strong>
                                <?= $data->timezone ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <!-- Network Details -->
                        <div class="detail-section">
                            <h6 class="section-title">
                                <i class="fas fa-network-wired me-2"></i> Network
                            </h6>
                            <div class="result-item">
                                <strong>ISP</strong>
                                <?= $data->isp ?? $data->org ?>
                            </div>
                            <div class="result-item">
                                <strong>AS Number</strong>
                                <?= $data->as ?>
                            </div>
                            <div class="result-item">
                                <strong>Organization</strong>
                                <?= $data->org ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <!-- Security Details -->
                        <div class="detail-section">
                            <h6 class="section-title">
                                <i class="fas fa-shield-alt me-2"></i> Security
                            </h6>
                            <div class="result-item">
                                <strong>Proxy/VPN</strong>
                                <span class="<?= ($data->proxy ?? $data->security->proxy) ? 'text-danger' : 'text-success' ?>">
                                    <?= ($data->proxy ?? $data->security->proxy) ? 'Detected' : 'Not Detected' ?>
                                </span>
                            </div>
                            <div class="result-item">
                                <strong>Hosting</strong>
                                <?= ($data->hosting ?? $data->security->hosting) ? 'Yes' : 'No' ?>
                            </div>
                            <div class="result-item">
                                <strong>Threat Level</strong>
                                <span class="<?= ($data->threat ?? 'Low') !== 'Low' ? 'text-danger' : 'text-success' ?>">
                                    <?= $data->threat ?? 'Low' ?>
                                </span>
                            </div>
                            <div class="result-item">
                                <strong>Abuse Score</strong>
                                <?= $data->abuse_score ?? 'N/A' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') { ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            Invalid IP address or unable to fetch analysis data.
        </div>
        <?php } ?>

        <!-- SEO Content -->
        <div class="seo-content text-center">
            <h2>Professional IP Geolocation Service</h2>
            <p>Our advanced IP lookup tool provides comprehensive network analysis and geolocation data for any IPv4 or IPv6 address. Get detailed insights including ISP information, network owner details, security risk assessment, and precise mapping coordinates. Essential for network administrators, cybersecurity professionals, and web developers.</p>
            <h3>Key Features</h3>
            <ul>
                <li><i class="fas fa-map me-2"></i> Interactive Geolocation Mapping</li>
                <li><i class="fas fa-server me-2"></i> Network Infrastructure Analysis</li>
                <li><i class="fas fa-user-shield me-2"></i> Security Threat Evaluation</li>
                <li><i class="fas fa-file-export me-2"></i> Multiple Data Export Formats</li>
                <li><i class="fas fa-history me-2"></i> Historical Lookup Tracking</li>
            </ul>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loader-overlay">
        <div class="loader"></div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Initialize Map
        <?php if ($data && isset($data->lat)): ?>
        const map = L.map('map').setView([<?= $data->lat ?>, <?= $data->lon ?>], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        const marker = L.marker([<?= $data->lat ?>, <?= $data->lon ?>]).addTo(map);
        marker.bindPopup(`
            <strong>IP Location:</strong> <?= $data->city ?>, <?= $data->country_name ?? $data->country ?><br>
            <strong>ISP:</strong> <?= $data->isp ?? $data->org ?>
        `).openPopup();
        <?php endif; ?>

        // Export Functions
        function exportJSON() {
            const data = <?= json_encode($data) ?>;
            const blob = new Blob([JSON.stringify(data, null, 2)], {type: 'application/json'});
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'ip-analysis.json';
            link.click();
        }

        function exportCSV() {
            const data = <?= json_encode($data) ?>;
            let csv = 'Category,Key,Value\n';
            for (const [key, value] of Object.entries(data)) {
                if (typeof value !== 'object') {
                    csv += `General,${key},${value}\n`;
                }
            }
            const blob = new Blob([csv], {type: 'text/csv'});
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'ip-analysis.csv';
            link.click();
        }

        // Form Submission Handler
        document.querySelector('form').addEventListener('submit', function(e) {
            document.querySelector('.loader-overlay').classList.add('active');
        });

        // Animate elements on scroll
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scroll behavior
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</body>
</html>