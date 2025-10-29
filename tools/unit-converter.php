<?php
// Define unit categories and conversion formulas
$unitCategories = [
    'Length' => [
        'meter' => ['base' => 1, 'formula' => 'x * [value]', 'description' => 'The base unit of length in the metric system'],
        'kilometer' => ['base' => 1000, 'formula' => 'x * [value]', 'description' => '1,000 meters (0.621 miles)'],
        'centimeter' => ['base' => 0.01, 'formula' => 'x * [value]', 'description' => '0.01 meters (0.394 inches)'],
        'millimeter' => ['base' => 0.001, 'formula' => 'x * [value]', 'description' => '0.001 meters (0.0394 inches)'],
        'inch' => ['base' => 0.0254, 'formula' => 'x * [value]', 'description' => '0.0254 meters (2.54 centimeters)'],
        'foot' => ['base' => 0.3048, 'formula' => 'x * [value]', 'description' => '0.3048 meters (12 inches)'],
        'yard' => ['base' => 0.9144, 'formula' => 'x * [value]', 'description' => '0.9144 meters (3 feet)'],
        'mile' => ['base' => 1609.34, 'formula' => 'x * [value]', 'description' => '1,609.34 meters (5,280 feet)']
    ],
    'Weight' => [
        'kilogram' => ['base' => 1, 'formula' => 'x * [value]', 'description' => 'The base unit of mass in the metric system'],
        'gram' => ['base' => 0.001, 'formula' => 'x * [value]', 'description' => '0.001 kilograms'],
        'milligram' => ['base' => 0.000001, 'formula' => 'x * [value]', 'description' => '0.000001 kilograms (0.001 grams)'],
        'pound' => ['base' => 0.453592, 'formula' => 'x * [value]', 'description' => '0.453592 kilograms (16 ounces)'],
        'ounce' => ['base' => 0.0283495, 'formula' => 'x * [value]', 'description' => '0.0283495 kilograms (28.35 grams)'],
        'ton' => ['base' => 907.185, 'formula' => 'x * [value]', 'description' => '907.185 kilograms (2,000 pounds)'],
        'metric ton' => ['base' => 1000, 'formula' => 'x * [value]', 'description' => '1,000 kilograms']
    ],
    'Temperature' => [
        'celsius' => ['formula' => '([value] * 9/5) + 32', 'reverse' => '([value] - 32) * 5/9', 'description' => 'Water freezes at 0°C and boils at 100°C'],
        'fahrenheit' => ['formula' => '([value] - 32) * 5/9', 'reverse' => '([value] * 9/5) + 32', 'description' => 'Water freezes at 32°F and boils at 212°F'],
        'kelvin' => ['formula' => '[value] - 273.15', 'reverse' => '[value] + 273.15', 'description' => 'Absolute temperature scale where 0K is absolute zero (-273.15°C)']
    ],
    'Area' => [
        'square meter' => ['base' => 1, 'formula' => 'x * [value]', 'description' => 'The area of a square with sides of 1 meter'],
        'square kilometer' => ['base' => 1000000, 'formula' => 'x * [value]', 'description' => '1,000,000 square meters'],
        'square centimeter' => ['base' => 0.0001, 'formula' => 'x * [value]', 'description' => '0.0001 square meters'],
        'square foot' => ['base' => 0.092903, 'formula' => 'x * [value]', 'description' => '0.092903 square meters (144 square inches)'],
        'square inch' => ['base' => 0.00064516, 'formula' => 'x * [value]', 'description' => '0.00064516 square meters'],
        'acre' => ['base' => 4046.86, 'formula' => 'x * [value]', 'description' => '4,046.86 square meters (43,560 square feet)'],
        'hectare' => ['base' => 10000, 'formula' => 'x * [value]', 'description' => '10,000 square meters (2.471 acres)']
    ],
    'Volume' => [
        'cubic meter' => ['base' => 1, 'formula' => 'x * [value]', 'description' => 'The volume of a cube with sides of 1 meter'],
        'liter' => ['base' => 0.001, 'formula' => 'x * [value]', 'description' => '0.001 cubic meters (1,000 milliliters)'],
        'milliliter' => ['base' => 0.000001, 'formula' => 'x * [value]', 'description' => '0.000001 cubic meters (1 cubic centimeter)'],
        'gallon US' => ['base' => 0.00378541, 'formula' => 'x * [value]', 'description' => '0.00378541 cubic meters (3.785 liters)'],
        'quart US' => ['base' => 0.000946353, 'formula' => 'x * [value]', 'description' => '0.000946353 cubic meters (0.25 gallons US)'],
        'pint US' => ['base' => 0.000473176, 'formula' => 'x * [value]', 'description' => '0.000473176 cubic meters (0.5 quarts US)'],
        'fluid ounce US' => ['base' => 0.0000295735, 'formula' => 'x * [value]', 'description' => '0.0000295735 cubic meters (29.5735 milliliters)'],
        'cubic foot' => ['base' => 0.0283168, 'formula' => 'x * [value]', 'description' => '0.0283168 cubic meters (28.3168 liters)']
    ],
    'Time' => [
        'second' => ['base' => 1, 'formula' => 'x * [value]', 'description' => 'The base unit of time'],
        'minute' => ['base' => 60, 'formula' => 'x * [value]', 'description' => '60 seconds'],
        'hour' => ['base' => 3600, 'formula' => 'x * [value]', 'description' => '3,600 seconds (60 minutes)'],
        'day' => ['base' => 86400, 'formula' => 'x * [value]', 'description' => '86,400 seconds (24 hours)'],
        'week' => ['base' => 604800, 'formula' => 'x * [value]', 'description' => '604,800 seconds (7 days)'],
        'month' => ['base' => 2629746, 'formula' => 'x * [value]', 'description' => 'Approximately 30.44 days (average)'],
        'year' => ['base' => 31556952, 'formula' => 'x * [value]', 'description' => 'Approximately 365.24 days']
    ],
    'Speed' => [
        'meter per second' => ['base' => 1, 'formula' => 'x * [value]', 'description' => 'Distance in meters traveled per second'],
        'kilometer per hour' => ['base' => 0.277778, 'formula' => 'x * [value]', 'description' => '0.277778 meters per second (1,000 meters per 3,600 seconds)'],
        'mile per hour' => ['base' => 0.44704, 'formula' => 'x * [value]', 'description' => '0.44704 meters per second (1,609.34 meters per 3,600 seconds)'],
        'foot per second' => ['base' => 0.3048, 'formula' => 'x * [value]', 'description' => '0.3048 meters per second'],
        'knot' => ['base' => 0.514444, 'formula' => 'x * [value]', 'description' => '0.514444 meters per second (1.852 kilometers per hour)']
    ],
    'Data' => [
        'byte' => ['base' => 1, 'formula' => 'x * [value]', 'description' => 'The basic unit of digital information (8 bits)'],
        'kilobyte' => ['base' => 1024, 'formula' => 'x * [value]', 'description' => '1,024 bytes'],
        'megabyte' => ['base' => 1048576, 'formula' => 'x * [value]', 'description' => '1,048,576 bytes (1,024 kilobytes)'],
        'gigabyte' => ['base' => 1073741824, 'formula' => 'x * [value]', 'description' => '1,073,741,824 bytes (1,024 megabytes)'],
        'terabyte' => ['base' => 1099511627776, 'formula' => 'x * [value]', 'description' => '1,099,511,627,776 bytes (1,024 gigabytes)'],
        'petabyte' => ['base' => 1125899906842624, 'formula' => 'x * [value]', 'description' => '1,125,899,906,842,624 bytes (1,024 terabytes)']
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universal Unit Converter - Convert Measurements Accurately</title>
    <meta name="description" content="Free online unit converter tool for length, weight, temperature, volume, time, and more. Instant conversions with accurate results.">
    <meta name="keywords" content="unit converter, measurement converter, length converter, weight converter, temperature converter">
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4ade80;
            --warning-color: #fbbf24;
            --danger-color: #f87171;
        }
        
        body {
            background-color: #f0f2f5;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .page-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .app-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 0 0 20px 20px;
            padding: 20px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .converter-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border: none;
            overflow: hidden;
        }
        
        .converter-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            color: white;
            font-weight: 600;
            padding: 15px 20px;
            border: none;
        }
        
        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            box-shadow: none;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .result-area {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid var(--primary-color);
        }
        
        .unit-switch {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: var(--primary-color);
        }
        
        .unit-switch:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .history-item {
            background: white;
            border-radius: 10px;
            padding: 12px 15px;
            margin: 8px 0;
            border-left: 3px solid var(--accent-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .history-item:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .copy-btn, .share-btn {
            cursor: pointer;
            transition: all 0.2s;
            color: var(--dark-color);
            opacity: 0.7;
            padding: 5px;
        }
        .copy-btn:hover, .share-btn:hover {
           opacity: 1;
           color: var(--primary-color);
       }
       
       .clear-history {
           color: var(--danger-color);
           cursor: pointer;
           font-size: 0.9rem;
           display: inline-flex;
           align-items: center;
       }
       
       .tooltip-icon {
           color: var(--accent-color);
           margin-left: 5px;
           cursor: help;
       }
       
       .category-icon {
           width: 24px;
           height: 24px;
           margin-right: 10px;
           opacity: 0.8;
       }
       
       /* Toast notification */
       .toast-container {
           position: fixed;
           bottom: 20px;
           right: 20px;
           z-index: 1050;
       }
       
       .toast {
           background-color: var(--dark-color);
           color: white;
           padding: 15px 20px;
           border-radius: 8px;
           opacity: 0;
           transition: opacity 0.3s ease;
       }
       
       .toast.show {
           opacity: 1;
       }
       
       /* Share modal */
       .share-modal .modal-content {
           border-radius: 16px;
           border: none;
       }
       
       .share-modal .modal-header {
           background: linear-gradient(to right, var(--primary-color), var(--accent-color));
           color: white;
           border-radius: 16px 16px 0 0;
           border: none;
       }
       
       .share-option {
           display: flex;
           align-items: center;
           padding: 15px;
           border-radius: 12px;
           transition: all 0.2s;
           cursor: pointer;
       }
       
       .share-option:hover {
           background-color: var(--light-color);
       }
       
       .share-icon {
           width: 40px;
           height: 40px;
           border-radius: 50%;
           display: flex;
           align-items: center;
           justify-content: center;
           margin-right: 15px;
           color: white;
       }
       
       /* Responsive styles */
       @media (max-width: 768px) {
           .converter-card {
               margin-bottom: 20px;
           }
           
           .unit-switch {
               width: 36px;
               height: 36px;
               margin: 10px auto;
           }
       }
   </style>
</head>
<body>
<div class="app-header text-center py-4 mb-4">
   <div class="container">
       <h1 class="display-5 fw-bold"><i class="fas fa-exchange-alt me-2"></i>UniConverter ~ Infinitytoolspace</h1>
       <p class="lead">Fast, accurate unit conversions for any measurement</p>
   </div>
</div>

<div class="container page-container">
   <div class="row justify-content-center">
       <div class="col-lg-10">
           <div class="converter-card p-0 mb-4">
               <div class="card-header d-flex justify-content-between align-items-center">
                   <h5 class="m-0"><i class="fas fa-calculator me-2"></i>Convert Units</h5>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                       <label class="form-check-label text-white" for="darkModeSwitch">Dark Mode</label>
                   </div>
               </div>
               <div class="card-body p-4">
                   <div class="row g-4">
                       <div class="col-12">
                           <select class="form-select form-select-lg" id="categorySelect">
                               <?php foreach ($unitCategories as $category => $units): ?>
                                   <option value="<?= $category ?>"><?= $category ?></option>
                               <?php endforeach; ?>
                           </select>
                       </div>
                       
                       <div class="col-md-5">
                           <div class="input-group">
                               <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                               <input type="number" class="form-control form-control-lg" id="inputValue" 
                                      placeholder="Enter value" step="any" autofocus>
                           </div>
                       </div>
                       
                       <div class="col-md-3">
                           <div class="input-group">
                               <span class="input-group-text"><i class="fas fa-arrows-alt-h"></i></span>
                               <select class="form-select form-select-lg" id="fromUnit"></select>
                               <span class="input-group-text tooltip-icon" id="fromUnitInfo">
                                   <i class="fas fa-info-circle"></i>
                               </span>
                           </div>
                       </div>
                       
                       <div class="col-md-1 d-flex justify-content-center align-items-center">
                           <div class="unit-switch" id="switchUnits">
                               <i class="fas fa-exchange-alt"></i>
                           </div>
                       </div>
                       
                       <div class="col-md-3">
                           <div class="input-group">
                               <span class="input-group-text"><i class="fas fa-arrows-alt-h"></i></span>
                               <select class="form-select form-select-lg" id="toUnit"></select>
                               <span class="input-group-text tooltip-icon" id="toUnitInfo">
                                   <i class="fas fa-info-circle"></i>
                               </span>
                           </div>
                       </div>
                   </div>
                   
                   <div class="result-area mt-4">
                       <div class="d-flex justify-content-between align-items-center">
                           <h4 class="fw-bold">Result:</h4>
                           <div>
                               <button class="btn btn-sm btn-outline-secondary copy-btn" 
                                       onclick="copyResult()" title="Copy Result">
                                   <i class="fas fa-copy me-1"></i> Copy
                               </button>
                               <button class="btn btn-sm btn-outline-primary share-btn ms-2" 
                                       onclick="showShareModal()" title="Share Result">
                                   <i class="fas fa-share-alt me-1"></i> Share
                               </button>
                           </div>
                       </div>
                       <h2 class="text-center mt-3">
                           <span id="resultValue" class="text-primary">0</span>
                           <span id="resultUnit" class="text-muted"></span>
                       </h2>
                       <p class="text-center text-muted">
                           <span id="conversionFormula"></span>
                       </p>
                   </div>
               </div>
           </div>

           <!-- Additional Features Section -->
           <div class="row">
               <div class="col-md-6 mb-4">
                   <div class="converter-card p-0 h-100">
                       <div class="card-header d-flex justify-content-between align-items-center">
                           <h5 class="m-0"><i class="fas fa-history me-2"></i>Recent Conversions</h5>
                           <span class="clear-history" onclick="clearHistory()">
                               <i class="fas fa-trash-alt me-1"></i> Clear
                           </span>
                       </div>
                       <div class="card-body p-3">
                           <div id="historyList" class="p-2">
                               <div class="text-center text-muted py-4">
                                   No recent conversions
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               
               <div class="col-md-6 mb-4">
                   <div class="converter-card p-0 h-100">
                       <div class="card-header">
                           <h5 class="m-0"><i class="fas fa-table me-2"></i>Common Conversions</h5>
                       </div>
                       <div class="card-body p-3">
                           <div id="multiResults" class="p-2">
                               <div class="text-center text-muted py-4">
                                   Select a category and enter a value
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <!-- Toast Notifications -->
   <div class="toast-container">
       <div class="toast" id="copyToast" role="alert" aria-live="assertive" aria-atomic="true">
           <div class="d-flex align-items-center">
               <i class="fas fa-check-circle me-2"></i>
               <div class="toast-body">Copied to clipboard!</div>
           </div>
       </div>
   </div>

   <!-- Share Modal -->
   <div class="modal fade share-modal" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="shareModalLabel"><i class="fas fa-share-alt me-2"></i>Share Conversion</h5>
                   <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <div class="mb-3">
                       <label for="shareLink" class="form-label">Conversion Link</label>
                       <div class="input-group">
                           <input type="text" class="form-control" id="shareLink" readonly>
                           <button class="btn btn-outline-secondary" type="button" onclick="copyShareLink()">
                               <i class="fas fa-copy"></i>
                           </button>
                       </div>
                   </div>
                   
                   <div class="mt-4">
                       <p class="text-muted mb-3">Share via:</p>
                       <div class="row g-2">
                           <div class="col-4">
                               <div class="share-option" onclick="shareVia('whatsapp')">
                                   <div class="share-icon" style="background-color: #25D366;">
                                       <i class="fab fa-whatsapp"></i>
                                   </div>
                                   <span>WhatsApp</span>
                               </div>
                           </div>
                           <div class="col-4">
                               <div class="share-option" onclick="shareVia('twitter')">
                                   <div class="share-icon" style="background-color: #1DA1F2;">
                                       <i class="fab fa-twitter"></i>
                                   </div>
                                   <span>Twitter</span>
                               </div>
                           </div>
                           <div class="col-4">
                               <div class="share-option" onclick="shareVia('facebook')">
                                   <div class="share-icon" style="background-color: #1877F2;">
                                       <i class="fab fa-facebook-f"></i>
                                   </div>
                                   <span>Facebook</span>
                               </div>
                           </div>
                           <div class="col-4">
                               <div class="share-option" onclick="shareVia('email')">
                                   <div class="share-icon" style="background-color: #D44638;">
                                       <i class="fas fa-envelope"></i>
                                   </div>
                                   <span>Email</span>
                               </div>
                           </div>
                           <div class="col-4">
                               <div class="share-option" onclick="shareVia('telegram')">
                                   <div class="share-icon" style="background-color: #0088cc;">
                                       <i class="fab fa-telegram-plane"></i>
                                   </div>
                                   <span>Telegram</span>
                               </div>
                           </div>
                           <div class="col-4">
                               <div class="share-option" onclick="shareVia('linkedin')">
                                   <div class="share-icon" style="background-color: #0A66C2;">
                                       <i class="fab fa-linkedin-in"></i>
                                   </div>
                                   <span>LinkedIn</span>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <!-- Unit Info Modal -->
   <div class="modal fade" id="unitInfoModal" tabindex="-1" aria-labelledby="unitInfoModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="unitInfoModalLabel">Unit Information</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body" id="unitInfoContent">
                   <!-- Unit info will be inserted here -->
               </div>
           </div>
       </div>
   </div>

   <!-- SEO Content -->
   <div class="mt-5 text-muted">
       <div class="converter-card p-4">
           <h2 class="h4 mb-3">Universal Unit Converter - Your Complete Conversion Tool</h2>
           <p>
               Our free online unit converter provides instant, accurate conversions across multiple measurement categories. 
               Perfect for students, professionals, engineers, and anyone needing quick and reliable conversions between 
               metric and imperial units.
           </p>
           <div class="row mt-4">
               <div class="col-md-4 mb-3">
                   <h3 class="h5"><i class="fas fa-ruler me-2 text-primary"></i>Length Conversions</h3>
                   <p class="small">Convert between meters, kilometers, miles, feet, inches and more with high precision.</p>
               </div>
               <div class="col-md-4 mb-3">
                   <h3 class="h5"><i class="fas fa-weight-hanging me-2 text-primary"></i>Weight Conversions</h3>
                   <p class="small">Easily switch between kilograms, pounds, ounces, grams, and other weight units.</p>
               </div>
               <div class="col-md-4 mb-3">
                   <h3 class="h5"><i class="fas fa-temperature-high me-2 text-primary"></i>Temperature Conversions</h3>
                   <p class="small">Convert between Celsius, Fahrenheit, and Kelvin temperature scales instantly.</p>
               </div>
           </div>
       </div>
   </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Unit data from PHP
const unitCategories = <?= json_encode($unitCategories) ?>;
let conversionHistory = JSON.parse(localStorage.getItem('conversionHistory')) || [];
// Initialize tooltips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

// DOM elements
const categorySelect = document.getElementById('categorySelect');
const fromUnitSelect = document.getElementById('fromUnit');
const toUnitSelect = document.getElementById('toUnit');
const inputValue = document.getElementById('inputValue');
const resultValue = document.getElementById('resultValue');
const resultUnit = document.getElementById('resultUnit');
const conversionFormula = document.getElementById('conversionFormula');
const historyList = document.getElementById('historyList');
const multiResults = document.getElementById('multiResults');
const fromUnitInfo = document.getElementById('fromUnitInfo');
const toUnitInfo = document.getElementById('toUnitInfo');
const copyToast = document.getElementById('copyToast');
const switchUnitsBtn = document.getElementById('switchUnits');
const darkModeSwitch = document.getElementById('darkModeSwitch');
const shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
const unitInfoModal = new bootstrap.Modal(document.getElementById('unitInfoModal'));

// Initialize unit selects
function populateUnits() {
   const category = categorySelect.value;
   const units = Object.keys(unitCategories[category]);
   
   fromUnitSelect.innerHTML = units.map(unit => `<option value="${unit}">${unit}</option>`).join('');
   toUnitSelect.innerHTML = units.map(unit => `<option value="${unit}">${unit}</option>`).join('');
   
   // Set default units
   if (category === 'Temperature') {
       fromUnitSelect.value = 'celsius';
       toUnitSelect.value = 'fahrenheit';
   } else {
       fromUnitSelect.value = units[0];
       toUnitSelect.value = units.length > 1 ? units[1] : units[0];
   }
   
   calculateConversion();
}

// Calculate conversion result
function calculateConversion() {
   const category = categorySelect.value;
   const fromUnit = fromUnitSelect.value;
   const toUnit = toUnitSelect.value;
   const value = parseFloat(inputValue.value) || 0;
   
   const result = convertUnits(category, value, fromUnit, toUnit);
   
   // Display result with appropriate formatting
   const formattedResult = formatResult(result);
   resultValue.textContent = formattedResult;
   resultUnit.textContent = toUnit;
   
   // Show conversion formula
   updateConversionFormula(category, value, fromUnit, toUnit, result);
   
   // Update history and multiple conversions
   if (value !== 0) {
       updateHistory(value, fromUnit, result, toUnit);
       updateMultipleConversions(value, fromUnit);
   }
}

// Convert units based on category
function convertUnits(category, value, fromUnit, toUnit) {
   const units = unitCategories[category];
   
   if (fromUnit === toUnit) return value;
   
   if (category === 'Temperature') {
       // Special case for temperature
       let baseTemp;
       
       // Convert to Celsius as the intermediate
       if (fromUnit === 'celsius') {
           baseTemp = value;
       } else if (fromUnit === 'fahrenheit') {
           baseTemp = (value - 32) * 5/9;
       } else if (fromUnit === 'kelvin') {
           baseTemp = value - 273.15;
       }
       
       // Convert from Celsius to target
       if (toUnit === 'celsius') {
           return baseTemp;
       } else if (toUnit === 'fahrenheit') {
           return (baseTemp * 9/5) + 32;
       } else if (toUnit === 'kelvin') {
           return baseTemp + 273.15;
       }
   } else {
       // Standard conversion using base values
       const baseValue = value * units[fromUnit].base;
       return baseValue / units[toUnit].base;
   }
}

// Format result with appropriate decimal places
function formatResult(value) {
   if (Math.abs(value) >= 1000000) {
       return value.toExponential(4);
   } else if (Math.abs(value) >= 1000) {
       return value.toLocaleString(undefined, { maximumFractionDigits: 4 });
   } else if (Math.abs(value) >= 1) {
       return value.toFixed(4).replace(/\.?0+$/, '');
   } else if (value === 0) {
       return '0';
   } else {
       // For small numbers, use appropriate precision
       return value.toPrecision(4).replace(/\.?0+$/, '');
   }
}

// Update conversion formula display
function updateConversionFormula(category, value, fromUnit, toUnit, result) {
   if (category === 'Temperature') {
       let formula = '';
       if (fromUnit === 'celsius' && toUnit === 'fahrenheit') {
           formula = `(${value} × 9/5) + 32 = ${result.toFixed(2)}`;
       } else if (fromUnit === 'fahrenheit' && toUnit === 'celsius') {
           formula = `(${value} - 32) × 5/9 = ${result.toFixed(2)}`;
       } else if (fromUnit === 'celsius' && toUnit === 'kelvin') {
           formula = `${value} + 273.15 = ${result.toFixed(2)}`;
       } else if (fromUnit === 'kelvin' && toUnit === 'celsius') {
           formula = `${value} - 273.15 = ${result.toFixed(2)}`;
       } else if (fromUnit === 'fahrenheit' && toUnit === 'kelvin') {
           formula = `((${value} - 32) × 5/9) + 273.15 = ${result.toFixed(2)}`;
       } else if (fromUnit === 'kelvin' && toUnit === 'fahrenheit') {
           formula = `((${value} - 273.15) × 9/5) + 32 = ${result.toFixed(2)}`;
       }
       conversionFormula.textContent = formula;
   } else {
       const units = unitCategories[category];
       const conversionFactor = (units[toUnit].base !== 0) ? units[fromUnit].base / units[toUnit].base : 0;
       conversionFormula.textContent = `1 ${fromUnit} = ${conversionFactor.toPrecision(4)} ${toUnit}`;
   }
}

// Update conversion history
function updateHistory(value, fromUnit, result, toUnit) {
   const formattedResult = formatResult(result);
   const entry = {
       input: `${value} ${fromUnit}`,
       output: `${formattedResult} ${toUnit}`,
       category: categorySelect.value,
       timestamp: new Date().getTime()
   };
   
   // Check if this conversion already exists in history
   const existingIndex = conversionHistory.findIndex(item => 
       item.input === entry.input && item.output === entry.output && item.category === entry.category
   );
   
   if (existingIndex !== -1) {
       // Remove the existing entry to move it to the top
       conversionHistory.splice(existingIndex, 1);
   }
   
   // Add to beginning of array
   conversionHistory.unshift(entry);
   
   // Keep only the most recent 10 conversions
   if (conversionHistory.length > 10) {
       conversionHistory.pop();
   }
   
   // Save to local storage
   localStorage.setItem('conversionHistory', JSON.stringify(conversionHistory));
   
   // Update the history display
   renderHistory();
}

// Render history list
function renderHistory() {
   if (conversionHistory.length === 0) {
       historyList.innerHTML = `
           <div class="text-center text-muted py-4">
               <i class="fas fa-history fa-2x mb-2"></i>
               <p>No recent conversions</p>
           </div>
       `;
       return;
   }
   
   historyList.innerHTML = conversionHistory.map(item => `
       <div class="history-item">
           <div>
               <div class="fw-bold">${item.input} → ${item.output}</div>
               <small class="text-muted">${item.category} · ${formatTimeAgo(item.timestamp)}</small>
           </div>
           <div>
               <i class="fas fa-redo ms-2 copy-btn" onclick="useHistoryItem('${item.input}', '${item.category}')" 
                  data-bs-toggle="tooltip" title="Use again"></i>
               <i class="fas fa-copy ms-2 copy-btn" onclick="copyToClipboard('${item.output}')" 
                  data-bs-toggle="tooltip" title="Copy result"></i>
               <i class="fas fa-share-alt ms-2 share-btn" onclick="shareConversion('${item.input}', '${item.output}', '${item.category}')" 
                  data-bs-toggle="tooltip" title="Share"></i>
           </div>
       </div>
   `).join('');
}

// Clear history
function clearHistory() {
   conversionHistory = [];
   localStorage.removeItem('conversionHistory');
   renderHistory();
   
   showToast('History cleared');
}

// Format timestamp to relative time
function formatTimeAgo(timestamp) {
   const seconds = Math.floor((new Date().getTime() - timestamp) / 1000);
   
   if (seconds < 60) return 'just now';
   
   const minutes = Math.floor(seconds / 60);
   if (minutes < 60) return `${minutes}m ago`;
   
   const hours = Math.floor(minutes / 60);
   if (hours < 24) return `${hours}h ago`;
   
   const days = Math.floor(hours / 24);
   return `${days}d ago`;
}

// Update multiple conversions display
function updateMultipleConversions(value, fromUnit) {
   const category = categorySelect.value;
   const units = unitCategories[category];
   const unitNames = Object.keys(units);
   
   // For temperature, we need special handling
   if (category === 'Temperature') {
       multiResults.innerHTML = unitNames.map(unit => {
           if (unit === fromUnit) return ''; // Skip the source unit
           const result = convertUnits(category, value, fromUnit, unit);
           return `
               <div class="history-item">
                   <span>${formatResult(result)} ${unit}</span>
                   <i class="fas fa-copy copy-btn" onclick="copyToClipboard('${formatResult(result)} ${unit}')"></i>
               </div>
           `;
       }).filter(Boolean).join('');
   } else {
       // Sort units by ascending order of conversion result
       const sortedUnits = unitNames
           .filter(unit => unit !== fromUnit) // Skip the source unit
           .sort((a, b) => {
               const aResult = convertUnits(category, value, fromUnit, a);
               const bResult = convertUnits(category, value, fromUnit, b);
               return aResult - bResult;
           });
       
       multiResults.innerHTML = sortedUnits.map(unit => {
           const result = convertUnits(category, value, fromUnit, unit);
           return `
               <div class="history-item">
                   <span>${formatResult(result)} ${unit}</span>
                   <i class="fas fa-copy copy-btn" onclick="copyToClipboard('${formatResult(result)} ${unit}')"></i>
               </div>
           `;
       }).join('');
   }
}

// Copy result to clipboard
function copyResult() {
   const result = `${resultValue.textContent} ${resultUnit.textContent}`;
   copyToClipboard(result);
}

// Copy text to clipboard
function copyToClipboard(text) {
   navigator.clipboard.writeText(text);
   showToast('Copied to clipboard!');
}

// Show toast notification
function showToast(message) {
   copyToast.querySelector('.toast-body').textContent = message;
   copyToast.classList.add('show');
   
   setTimeout(() => {
       copyToast.classList.remove('show');
   }, 2000);
}

// Use history item
function useHistoryItem(input, itemCategory) {
   // Set the category
   categorySelect.value = itemCategory;
   
   // Update unit selects
   populateUnits();
   
   // Parse the input
   const parts = input.split(' ');
   const value = parseFloat(parts[0]);
   const unit = parts.slice(1).join(' ');
   
   // Set values
   inputValue.value = value;
   fromUnitSelect.value = unit;
   
   // Recalculate
   calculateConversion();
}

// Show unit info modal
function showUnitInfo(unit, category) {
   const unitData = unitCategories[category][unit];
   const modalTitle = document.getElementById('unitInfoModalLabel');
   const modalContent = document.getElementById('unitInfoContent');
   
   modalTitle.textContent = `${unit} (${category})`;
   
   let content = `<p>${unitData.description}</p>`;
   
   if (category !== 'Temperature') {
       if (unitData.base === 1) {
           content += `<div class="alert alert-info">This is the base unit for ${category.toLowerCase()} measurements.</div>`;
       } else {
           const baseUnit = Object.keys(unitCategories[category]).find(u => unitCategories[category][u].base === 1);
           content += `<div class="mt-3">
               <strong>Conversion to base unit:</strong><br>
               1 ${unit} = ${unitData.base} ${baseUnit}
           </div>`;
       }
   } else {
       content += `<div class="mt-3">
           <strong>Conversion formulas:</strong><br>`;
       
       if (unit === 'celsius') {
           content += `°C to °F: (°C × 9/5) + 32<br>
                       °C to K: °C + 273.15`;
       } else if (unit === 'fahrenheit') {
           content += `°F to °C: (°F - 32) × 5/9<br>
                       °F to K: (°F - 32) × 5/9 + 273.15`;
       } else if (unit === 'kelvin') {
           content += `K to °C: K - 273.15<br>
                       K to °F: (K - 273.15) × 9/5 + 32`;
       }
       
       content += `</div>`;
   }
   
   modalContent.innerHTML = content;
   unitInfoModal.show();
}

// Switch units
function switchUnits() {
   const tempFromUnit = fromUnitSelect.value;
   fromUnitSelect.value = toUnitSelect.value;
   toUnitSelect.value = tempFromUnit;
   calculateConversion();
}

// Toggle dark mode
function toggleDarkMode() {
   const isDarkMode = darkModeSwitch.checked;
   document.body.classList.toggle('dark-mode', isDarkMode);
   localStorage.setItem('darkMode', isDarkMode);
}

// Share functionality
function showShareModal() {
   const shareLink = generateShareLink();
   document.getElementById('shareLink').value = shareLink;
   shareModal.show();
}

function copyShareLink() {
   const shareLink = document.getElementById('shareLink');
   shareLink.select();
   navigator.clipboard.writeText(shareLink.value);
   showToast('Link copied to clipboard!');
}

function generateShareLink() {
   const category = encodeURIComponent(categorySelect.value);
   const fromUnit = encodeURIComponent(fromUnitSelect.value);
   const toUnit = encodeURIComponent(toUnitSelect.value);
   const value = encodeURIComponent(inputValue.value);
   
   // Create URL with parameters
   const baseUrl = window.location.href.split('?')[0]; // Remove any existing query params
   return `${baseUrl}?category=${category}&from=${fromUnit}&to=${toUnit}&value=${value}`;
}

function shareVia(platform) {
   const shareText = `Check out this conversion: ${inputValue.value} ${fromUnitSelect.value} = ${resultValue.textContent} ${resultUnit.textContent}`;
   const shareLink = generateShareLink();
   let shareUrl;
   
   switch (platform) {
       case 'whatsapp':
           shareUrl = `https://wa.me/?text=${encodeURIComponent(shareText + ' ' + shareLink)}`;
           break;
       case 'twitter':
           shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(shareText)}&url=${encodeURIComponent(shareLink)}`;
           break;
       case 'facebook':
           shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareLink)}`;
           break;
       case 'email':
           shareUrl = `mailto:?subject=Unit Conversion&body=${encodeURIComponent(shareText + '\n\n' + shareLink)}`;
           break;
       case 'telegram':
           shareUrl = `https://t.me/share/url?url=${encodeURIComponent(shareLink)}&text=${encodeURIComponent(shareText)}`;
           break;
       case 'linkedin':
           shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareLink)}`;
           break;
   }
   
   window.open(shareUrl, '_blank');
   shareModal.hide();
}

// Check for shared conversion in URL
function loadSharedConversion() {
   const urlParams = new URLSearchParams(window.location.search);
   
   if (urlParams.has('category') && urlParams.has('from') && urlParams.has('to') && urlParams.has('value')) {
       const category = urlParams.get('category');
       const fromUnit = urlParams.get('from');
       const toUnit = urlParams.get('to');
       const value = urlParams.get('value');
       
       // Set the values if they're valid
       if (unitCategories[category]) {
           categorySelect.value = category;
           populateUnits(); // This will populate the unit dropdowns
           
           if (Object.keys(unitCategories[category]).includes(fromUnit)) {
               fromUnitSelect.value = fromUnit;
           }
           
           if (Object.keys(unitCategories[category]).includes(toUnit)) {
               toUnitSelect.value = toUnit;
           }
           
           inputValue.value = parseFloat(value);
           calculateConversion();
       }
   }
}

// Share a specific conversion from history
function shareConversion(input, output, category) {
   const parts = input.split(' ');
   const value = parts[0];
   const fromUnit = parts.slice(1).join(' ');
   
   const outputParts = output.split(' ');
   const toUnit = outputParts.slice(1).join(' ');
   
   categorySelect.value = category;
   populateUnits();
   
   fromUnitSelect.value = fromUnit;
   toUnitSelect.value = toUnit;
   inputValue.value = value;
   
   calculateConversion();
   showShareModal();
}

// Event Listeners
categorySelect.addEventListener('change', populateUnits);
inputValue.addEventListener('input', calculateConversion);
fromUnitSelect.addEventListener('change', calculateConversion);
toUnitSelect.addEventListener('change', calculateConversion);
fromUnitInfo.addEventListener('click', () => showUnitInfo(fromUnitSelect.value, categorySelect.value));
toUnitInfo.addEventListener('click', () => showUnitInfo(toUnitSelect.value, categorySelect.value));
switchUnitsBtn.addEventListener('click', switchUnits);
darkModeSwitch.addEventListener('change', toggleDarkMode);

// Check for dark mode preference
const savedDarkMode = localStorage.getItem('darkMode');
if (savedDarkMode === 'true') {
   darkModeSwitch.checked = true;
   toggleDarkMode();
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
   populateUnits();
   renderHistory();
   loadSharedConversion();
});
</script>
</body>
</html>