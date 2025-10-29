<?php
// Initialize variables
$calculationType = isset($_POST['calculationType']) ? $_POST['calculationType'] : 'daysBetween';
$result = '';
$resultDetails = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($calculationType) {
        case 'daysBetween':
            if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
                $startDate = new DateTime($_POST['startDate']);
                $endDate = new DateTime($_POST['endDate']);
                $interval = $startDate->diff($endDate);
                $days = $interval->days;
                $result = abs($days) . " days";
                $resultDetails = "From " . $startDate->format('F j, Y') . " to " . $endDate->format('F j, Y');
                
                // Additional details
                $years = $interval->y;
                $months = $interval->m;
                $remainingDays = $interval->d;
                $resultDetails .= "<br>That's $years years, $months months, and $remainingDays days";
                
                // Add weekday information
                $weekdays = getWeekdaysBetweenDates($startDate, $endDate);
                $resultDetails .= "<br>Weekdays (Mon-Fri): $weekdays";
            }
            break;
            
        case 'addSubtract':
            if (isset($_POST['baseDate']) && isset($_POST['operation']) && isset($_POST['amount']) && isset($_POST['unit'])) {
                $baseDate = new DateTime($_POST['baseDate']);
                $original = clone $baseDate;
                $operation = $_POST['operation'];
                $amount = (int)$_POST['amount'];
                $unit = $_POST['unit'];
                
                if ($operation === 'subtract') {
                    $amount = -$amount;
                }
                
                $interval = "P" . ($unit === 'days' ? $amount . "D" : 
                                  ($unit === 'weeks' ? ($amount * 7) . "D" : 
                                  ($unit === 'months' ? $amount . "M" : 
                                  ($unit === 'years' ? $amount . "Y" : ""))));
                
                $baseDate->add(new DateInterval($interval));
                $result = $baseDate->format('F j, Y');
                $resultDetails = "Starting from " . $original->format('F j, Y') . ", " . 
                                ($operation === 'add' ? "adding" : "subtracting") . " $amount $unit";
            }
            break;
            
        case 'ageCalculator':
            if (isset($_POST['birthDate'])) {
                $birthDate = new DateTime($_POST['birthDate']);
                $today = new DateTime();
                $age = $today->diff($birthDate);
                
                $result = $age->y . " years, " . $age->m . " months, " . $age->d . " days";
                $resultDetails = "Born on " . $birthDate->format('F j, Y') . "<br>";
                $resultDetails .= "That's " . $age->days . " total days";
                
                // Add next birthday countdown
                $nextBirthday = new DateTime($birthDate->format('Y-m-d'));
                $nextBirthday->setDate($today->format('Y'), $birthDate->format('m'), $birthDate->format('d'));
                if ($nextBirthday < $today) {
                    $nextBirthday->setDate($today->format('Y') + 1, $birthDate->format('m'), $birthDate->format('d'));
                }
                $daysUntilBirthday = $today->diff($nextBirthday)->days;
                $resultDetails .= "<br>Days until next birthday: $daysUntilBirthday";
            }
            break;
            
        case 'weekdayFinder':
            if (isset($_POST['checkDate'])) {
                $checkDate = new DateTime($_POST['checkDate']);
                $result = $checkDate->format('l');
                $resultDetails = $checkDate->format('F j, Y') . " falls on a " . $result;
            }
            break;
            
        case 'workingDays':
            if (isset($_POST['workStartDate']) && isset($_POST['workEndDate'])) {
                $startDate = new DateTime($_POST['workStartDate']);
                $endDate = new DateTime($_POST['workEndDate']);
                
                // Get holidays if provided
                $holidays = [];
                if (!empty($_POST['holidays'])) {
                    $holidayDates = explode(',', $_POST['holidays']);
                    foreach ($holidayDates as $date) {
                        $date = trim($date);
                        if (!empty($date)) {
                            try {
                                $holidays[] = new DateTime($date);
                            } catch (Exception $e) {
                                // Skip invalid dates
                            }
                        }
                    }
                }
                
                $workingDays = calculateWorkingDays($startDate, $endDate, $holidays);
                $result = $workingDays . " working days";
                $resultDetails = "From " . $startDate->format('F j, Y') . " to " . $endDate->format('F j, Y');
                $resultDetails .= "<br>Excluding weekends" . (count($holidays) > 0 ? " and " . count($holidays) . " holidays" : "");
            }
            break;
            
        case 'weekNumber':
            if (isset($_POST['weekDate'])) {
                $weekDate = new DateTime($_POST['weekDate']);
                $result = "Week " . $weekDate->format('W');
                $resultDetails = $weekDate->format('F j, Y') . " is in " . $result . " of the year " . $weekDate->format('Y');
                $resultDetails .= "<br>According to ISO 8601 standard";
            }
            break;
            
        case 'leapYear':
            if (isset($_POST['yearToCheck'])) {
                $year = (int)$_POST['yearToCheck'];
                $isLeap = isLeapYear($year);
                $result = $isLeap ? "Yes, it's a leap year" : "No, it's not a leap year";
                $resultDetails = "The year $year " . ($isLeap ? "is" : "is not") . " a leap year";
                $resultDetails .= "<br>" . getLeapYearExplanation($year);
            }
            break;
            
        case 'timeDuration':
            if (isset($_POST['startDateTime']) && isset($_POST['endDateTime'])) {
                $startDateTime = new DateTime($_POST['startDateTime']);
                $endDateTime = new DateTime($_POST['endDateTime']);
                $interval = $startDateTime->diff($endDateTime);
                
                $result = formatTimeInterval($interval);
                $resultDetails = "From " . $startDateTime->format('F j, Y H:i:s') . " to " . $endDateTime->format('F j, Y H:i:s');
                $resultDetails .= "<br>Total seconds: " . calculateTotalSeconds($startDateTime, $endDateTime);
            }
            break;
            
        case 'calendarConverter':
            if (isset($_POST['gregorianDate']) && isset($_POST['targetCalendar'])) {
                $gregorianDate = new DateTime($_POST['gregorianDate']);
                $targetCalendar = $_POST['targetCalendar'];
                
                $result = convertCalendar($gregorianDate, $targetCalendar);
                $resultDetails = "Converted from Gregorian date " . $gregorianDate->format('F j, Y');
                $resultDetails .= "<br>To $targetCalendar calendar";
            }
            break;
            
        case 'timezoneConverter':
            if (isset($_POST['sourceDateTime']) && isset($_POST['sourceTimezone']) && isset($_POST['targetTimezone'])) {
                $sourceDateTime = new DateTime($_POST['sourceDateTime'], new DateTimeZone($_POST['sourceTimezone']));
                $targetTimezone = new DateTimeZone($_POST['targetTimezone']);
                
                $sourceDateTime->setTimezone($targetTimezone);
                $result = $sourceDateTime->format('F j, Y H:i:s');
                $resultDetails = "Converted from " . $_POST['sourceTimezone'] . " to " . $_POST['targetTimezone'];
            }
            break;
            
        case 'fiscalYear':
            if (isset($_POST['fiscalDate']) && isset($_POST['fiscalStartMonth'])) {
                $date = new DateTime($_POST['fiscalDate']);
                $fiscalStartMonth = (int)$_POST['fiscalStartMonth'];
                
                $result = calculateFiscalYear($date, $fiscalStartMonth);
                $resultDetails = "Based on fiscal year starting in month $fiscalStartMonth";
                $resultDetails .= "<br>Date: " . $date->format('F j, Y');
            }
            break;
    }
}

// Helper functions
function getWeekdaysBetweenDates($startDate, $endDate) {
    $days = $startDate->diff($endDate)->days;
    $weekdays = 0;
    
    for ($i = 0; $i <= $days; $i++) {
        $current = clone $startDate;
        $current->modify("+$i days");
        $dayOfWeek = $current->format('N');
        
        if ($dayOfWeek <= 5) { // 1 (Monday) through 5 (Friday)
            $weekdays++;
        }
    }
    
    return $weekdays;
}

function calculateWorkingDays($startDate, $endDate, $holidays = []) {
    $days = $startDate->diff($endDate)->days;
    $workingDays = 0;
    
    for ($i = 0; $i <= $days; $i++) {
        $current = clone $startDate;
        $current->modify("+$i days");
        $dayOfWeek = $current->format('N');
        
        // Check if it's a weekday (1-5) and not a holiday
        if ($dayOfWeek <= 5) {
            $isHoliday = false;
            foreach ($holidays as $holiday) {
                if ($current->format('Y-m-d') == $holiday->format('Y-m-d')) {
                    $isHoliday = true;
                    break;
                }
            }
            
            if (!$isHoliday) {
                $workingDays++;
            }
        }
    }
    
    return $workingDays;
}

function isLeapYear($year) {
    return (($year % 4 == 0) && ($year % 100 != 0)) || ($year % 400 == 0);
}

function getLeapYearExplanation($year) {
    if ($year % 400 == 0) {
        return "It's a leap year because it's divisible by 400.";
    } elseif ($year % 100 == 0) {
        return "It's not a leap year because it's divisible by 100 but not by 400.";
    } elseif ($year % 4 == 0) {
        return "It's a leap year because it's divisible by 4 but not by 100.";
    } else {
        return "It's not a leap year because it's not divisible by 4.";
    }
}

function formatTimeInterval($interval) {
    $parts = [];
    
    if ($interval->y > 0) {
        $parts[] = $interval->y . " year" . ($interval->y > 1 ? "s" : "");
    }
    if ($interval->m > 0) {
        $parts[] = $interval->m . " month" . ($interval->m > 1 ? "s" : "");
    }
    if ($interval->d > 0) {
        $parts[] = $interval->d . " day" . ($interval->d > 1 ? "s" : "");
    }
    if ($interval->h > 0) {
        $parts[] = $interval->h . " hour" . ($interval->h > 1 ? "s" : "");
    }
    if ($interval->i > 0) {
        $parts[] = $interval->i . " minute" . ($interval->i > 1 ? "s" : "");
    }
    if ($interval->s > 0 || count($parts) == 0) {
        $parts[] = $interval->s . " second" . ($interval->s != 1 ? "s" : "");
    }
    
    return implode(", ", $parts);
}

function calculateTotalSeconds($startDateTime, $endDateTime) {
    return $endDateTime->getTimestamp() - $startDateTime->getTimestamp();
}

function convertCalendar($gregorianDate, $targetCalendar) {
    $year = (int)$gregorianDate->format('Y');
    $month = (int)$gregorianDate->format('m');
    $day = (int)$gregorianDate->format('d');
    
    switch ($targetCalendar) {
        case 'Julian':
            // Simple Julian calendar conversion (approximate)
            $julianDate = clone $gregorianDate;
            $julianDate->modify('-13 days');
            return $julianDate->format('F j, Y') . " (Julian)";
            
        case 'Hijri':
            // Approximate Hijri calendar conversion
            $hijriYear = round(($year - 622) * (33/32));
            $hijriMonth = $month; // Simplified
            $hijriDay = $day;
            return "$hijriDay/$hijriMonth/$hijriYear (Hijri)";
            
        case 'Hebrew':
            // Approximate Hebrew calendar conversion
            $hebrewYear = $year + 3760;
            return "$day/$month/$hebrewYear (Hebrew)";
            
        case 'Hindu':
                // Convert to Hindu/Saka calendar
                return convertToHinduCalendar($gregorianDate);
                
        default:
                return $gregorianDate->format('F j, Y') . " (Gregorian)";
    }
}

function convertToHinduCalendar($gregorianDate) {
    // Get Gregorian date components
    $gregorianYear = (int)$gregorianDate->format('Y');
    $gregorianMonth = (int)$gregorianDate->format('m');
    $gregorianDay = (int)$gregorianDate->format('d');
    
    // Constants for Hindu calendar calculation
    $sakaEpoch = 78; // Saka calendar starts 78 years after AD
    
    // Calculate the approximate Saka year
    $sakaYear = $gregorianYear - $sakaEpoch;
    
    // Define month names in Hindu/Saka calendar
    $hinduMonths = [
        1 => 'Chaitra',
        2 => 'Vaisakha',
        3 => 'Jyeshtha',
        4 => 'Ashadha',
        5 => 'Shravana',
        6 => 'Bhadrapada',
        7 => 'Ashwina',
        8 => 'Kartika',
        9 => 'Margashirsha',
        10 => 'Pausha',
        11 => 'Magha',
        12 => 'Phalguna'
    ];
    
    // Approximate month and day conversion
    // The Hindu solar calendar typically begins around mid-April (Gregorian)
    if ($gregorianMonth < 4 || ($gregorianMonth == 4 && $gregorianDay < 14)) {
        $hinduMonth = $gregorianMonth + 9;
        if ($hinduMonth > 12) {
            $hinduMonth -= 12;
        }
        $sakaYear--; // Previous Saka year
    } else {
        $hinduMonth = $gregorianMonth - 3;
        if ($hinduMonth <= 0) {
            $hinduMonth += 12;
        }
    }
    
    // Day is approximate - generally offset by about 13-14 days
    $hinduDay = $gregorianDay;
    if ($gregorianDay > 14) {
        $hinduDay -= 13;
        if ($hinduDay <= 0) {
            $hinduDay += 30; // Approximate month length
            $hinduMonth--;
            if ($hinduMonth <= 0) {
                $hinduMonth += 12;
                $sakaYear--;
            }
        }
    } else {
        $hinduDay += 17;
        if ($hinduDay > 30) { // Approximate month length
            $hinduDay -= 30;
            $hinduMonth++;
            if ($hinduMonth > 12) {
                $hinduMonth = 1;
                $sakaYear++;
            }
        }
    }
    
    $hinduMonthName = $hinduMonths[$hinduMonth];
    
    return "$hinduDay $hinduMonthName, Saka $sakaYear";
}

function calculateFiscalYear($date, $fiscalStartMonth) {
    $year = (int)$date->format('Y');
    $month = (int)$date->format('m');
    
    // Determine fiscal year
    if ($month < $fiscalStartMonth) {
        $fiscalYear = $year - 1;
    } else {
        $fiscalYear = $year;
    }
    
    // Calculate fiscal year start and end dates
    $fiscalStart = new DateTime($fiscalYear . '-' . str_pad($fiscalStartMonth, 2, '0', STR_PAD_LEFT) . '-01');
    $fiscalEnd = clone $fiscalStart;
    $fiscalEnd->modify('+1 year -1 day');
    
    return "Fiscal Year $fiscalYear-" . ($fiscalYear + 1) . 
           "<br>Starts: " . $fiscalStart->format('F j, Y') . 
           "<br>Ends: " . $fiscalEnd->format('F j, Y');
}

// Get available timezones
$timezones = DateTimeZone::listIdentifiers();

// Get common fiscal year start months
$fiscalStartMonths = [
    1 => 'January',
    4 => 'April',
    7 => 'July',
    10 => 'October'
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Date Calculator | Calculate Days Between Dates, Age, Working Days & More</title>
    <meta name="description" content="Use our free online date calculator to add or subtract days, weeks, months, or years. Calculate date differences easily with this simple tool.">
    <meta name="keywords" content="date calculator, online date calculator, date difference calculator, add days to date, subtract days from date, day calculator, time calculator, calendar tool

">
<link rel="canonical" href="https://infinitytoolspace.com/tools/date-calculator" />

<meta property="og:title" content="Date Calculator - Add, Subtract & Find Date Differences" />
<meta property="og:description" content="Calculate date differences or add/subtract time from a date with our free and easy-to-use date calculator tool." />
<meta property="og:url" content="https://infinitytoolspace.com/tools/date-calculator" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgp94c5BwOWCgkZkdM1JhJksNLEfM3cDOJjcbVsjV8lPLvjnXe93QaTEFPf57YM-zi41Z-UR8xnr2tldLHO6sCEb480Fx0teC7GRiXhoZ-AZMIyQ79WTAYDOEqhMeMBT73F6-zb3l0fvtfmbqoC46VvwkqOtJAnX4Ky_yXN3uP67o3v1UD_oP0Oft-fub0/s16000/date_calculator.jpeg" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #6c757d;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }
        
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8f9fc;
            color: #5a5c69;
        }
        
        .calculator-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 0.35rem;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
        }
        
        .card-header h2 {
            font-size: 1.25rem;
            margin-bottom: 0;
            color: #4e73df;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #bac8f3;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        
        .btn-primary:hover {
            background-color: #4262ca;
            border-color: #3d5cc0;
        }
        
        .result-card {
            background-color: #fff;
            border-left: 0.25rem solid #4e73df;
        }
        
        .result-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4e73df;
        }
        
        .result-details {
            font-size: 0.875rem;
            color: #6c757d;
        }
        
        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .nav-tabs .nav-link.active {
            color: #4e73df;
            border-bottom: 2px solid #4e73df;
            background-color: transparent;
        }
        
        .nav-tabs .nav-link:hover {
            border-color: transparent;
            color: #4e73df;
        }
        
        .form-label {
            font-weight: 600;
            color: #5a5c69;
        }
        
        .feature-icon {
            width: 4rem;
            height: 4rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e0e7ff;
            color: #4e73df;
            margin-bottom: 1rem;
        }
        
        footer {
            background-color: #fff;
            padding: 2rem 0;
            border-top: 1px solid #e3e6f0;
        }
        
        @media (max-width: 767.98px) {
            .card-body {
                padding: 1rem;
            }
            
            .nav-tabs .nav-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }
        }
        
        .tab-content {
            padding-top: 1.5rem;
        }
        
        .calculator-selection {
            margin-bottom: 1.5rem;
        }
        
        .fade-in {
            animation: fadeIn 0.5s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="calculator-container">
        <header class="text-center py-4">
            <h1 class="mb-2">Date Calculator - Infinitytoolspace</h1>
            <p class="lead mb-4">Calculate days between dates, age, working days, week numbers, and more</p>
        </header>
        
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($calculationType === 'daysBetween') ? 'active' : ''; ?>" href="#" data-calc="daysBetween">Days Between</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($calculationType === 'addSubtract') ? 'active' : ''; ?>" href="#" data-calc="addSubtract">Add/Subtract</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($calculationType === 'ageCalculator') ? 'active' : ''; ?>" href="#" data-calc="ageCalculator">Age Calculator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($calculationType === 'weekdayFinder') ? 'active' : ''; ?>" href="#" data-calc="weekdayFinder">Weekday Finder</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">More</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item <?php echo ($calculationType === 'workingDays') ? 'active' : ''; ?>" href="#" data-calc="workingDays">Working Days</a></li>
                            <li><a class="dropdown-item <?php echo ($calculationType === 'weekNumber') ? 'active' : ''; ?>" href="#" data-calc="weekNumber">Week Number</a></li>
                            <li><a class="dropdown-item <?php echo ($calculationType === 'leapYear') ? 'active' : ''; ?>" href="#" data-calc="leapYear">Leap Year</a></li>
                            <li><a class="dropdown-item <?php echo ($calculationType === 'timeDuration') ? 'active' : ''; ?>" href="#" data-calc="timeDuration">Time Duration</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item <?php echo ($calculationType === 'calendarConverter') ? 'active' : ''; ?>" href="#" data-calc="calendarConverter">Calendar Converter</a></li>
                            <li><a class="dropdown-item <?php echo ($calculationType === 'timezoneConverter') ? 'active' : ''; ?>" href="#" data-calc="timezoneConverter">Timezone Converter</a></li>
                            <li><a class="dropdown-item <?php echo ($calculationType === 'fiscalYear') ? 'active' : ''; ?>" href="#" data-calc="fiscalYear">Fiscal Year</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            
            <div class="card-body">
                <div class="tab-content">
                    <!-- Days Between Dates -->
                    <div class="tab-pane fade <?php echo ($calculationType === 'daysBetween') ? 'show active' : ''; ?>" id="daysBetween">
                        <form method="post" action="">
                            <input type="hidden" name="calculationType" value="daysBetween">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="startDate" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate" required value="<?php echo isset($_POST['startDate']) ? $_POST['startDate'] : date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="endDate" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate" required value="<?php echo isset($_POST['endDate']) ? $_POST['endDate'] : date('Y-m-d', strtotime('+30 days')); ?>">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Calculate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Add/Subtract Days -->
                    <div class="tab-pane fade <?php echo ($calculationType === 'addSubtract') ? 'show active' : ''; ?>" id="addSubtract">
                        <form method="post" action="">
                            <input type="hidden" name="calculationType" value="addSubtract">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="baseDate" class="form-label">Base Date</label>
                                    <input type="date" class="form-control" id="baseDate" name="baseDate" required value="<?php echo isset($_POST['baseDate']) ? $_POST['baseDate'] : date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="operation" class="form-label">Operation</label>
                                    <select class="form-select" id="operation" name="operation">
                                        <option value="add" <?php echo (isset($_POST['operation']) && $_POST['operation'] === 'add') ? 'selected' : ''; ?>>Add</option>
                                        <option value="subtract" <?php echo (isset($_POST['operation']) && $_POST['operation'] === 'subtract') ? 'selected' : ''; ?>>Subtract</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" required min="0" value="<?php echo isset($_POST['amount']) ? $_POST['amount'] : '7'; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="unit" class="form-label">Unit</label>
                                    <select class="form-select" id="unit" name="unit">
                                        <option value="days" <?php echo (isset($_POST['unit']) && $_POST['unit'] === 'days') ? 'selected' : ''; ?>>Days</option>
                                        <option value="weeks" <?php echo (isset($_POST['unit']) && $_POST['unit'] === 'weeks') ? 'selected' : ''; ?>>Weeks</option>
                                        <option value="months" <?php echo (isset($_POST['unit']) && $_POST['unit'] === 'months') ? 'selected' : ''; ?>>Months</option>
                                        <option value="years" <?php echo (isset($_POST['unit']) && $_POST['unit'] === 'years') ? 'selected' : ''; ?>>Years</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Calculate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Age Calculator -->
                    <div class="tab-pane fade <?php echo ($calculationType === 'ageCalculator') ? 'show active' : ''; ?>" id="ageCalculator">
                        <form method="post" action="">
                            <input type="hidden" name="calculationType" value="ageCalculator">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="birthDate" class="form-label">Birth Date</label>
                                    <input type="date" class="form-control" id="birthDate" name="birthDate" required value="<?php echo isset($_POST['birthDate']) ? $_POST['birthDate'] : '1990-01-01'; ?>">
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Calculate Age</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Weekday Finder -->
                    <div class="tab-pane fade <?php echo ($calculationType === 'weekdayFinder') ? 'show active' : ''; ?>" id="weekdayFinder">
                        <form method="post" action="">
                            <input type="hidden" name="calculationType" value="weekdayFinder">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="checkDate" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="checkDate" name="checkDate" required value="<?php echo isset($_POST['checkDate']) ? $_POST['checkDate'] : date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Find Weekday</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Working Days Calculator -->
                    <div class="tab-pane fade <?php echo ($calculationType === 'workingDays') ? 'show active' : ''; ?>" id="workingDays">
                        <form method="post" action="">
                            <input type="hidden" name="calculationType" value="workingDays">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="workStartDate" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="workStartDate" name="workStartDate" required value="<?php echo isset($_POST['workStartDate']) ? $_POST['workStartDate'] : date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="workEndDate" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="workEndDate" name="workEndDate" required value="<?php echo isset($_POST['workEndDate']) ? $_POST['workEndDate'] : date('Y-m-d', strtotime('+30 days')); ?>">
                                </div>
                                <div class="col-12">
                                    <label for="holidays" class="form-label">Holidays (optional)</label>
                                    <input type="text" class="form-control" id="holidays" name="holidays" placeholder="Enter dates separated by commas (YYYY-MM-DD)" value="<?php echo isset($_POST['holidays']) ? $_POST['holidays'] : ''; ?>">
                                    <div class="form-text">Example: 2023-12-25, 2023-01-01</div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Calculate Working Days</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Week Number Finder -->
                    <div class="tab-pane fade <?php echo ($calculationType === 'weekNumber') ? 'show active' : ''; ?>" id="weekNumber">
                        <form method="post" action="">
                            <input type="hidden" name="calculationType" value="weekNumber">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="weekDate" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="weekDate" name="weekDate" required value="<?php echo isset($_POST['weekDate']) ? $_POST['weekDate'] : date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Find Week Number</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Leap Year Checker -->
                    <div class="tab-pane fade <?php echo ($calculationType === 'leapYear') ? 'show active' : ''; ?>" id="leapYear">
                        <form method="post" action="">
                            <input type="hidden" name="calculationType" value="leapYear">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="yearToCheck" class="form-label">Year</label>
                                    <input type="number" class="form-control" id="yearToCheck" name="yearToCheck" required min="1" max="9999" value="<?php echo isset($_POST['yearToCheck']) ? $_POST['yearToCheck'] : date('Y'); ?>">
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Check Leap Year</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Time Duration Calculator -->
                    <div class="tab-pane fade <?php echo ($calculationType === 'timeDuration') ? 'show active' : ''; ?>" id="timeDuration">
                        <form method="post" action="">
                            <input type="hidden" name="calculationType" value="timeDuration">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="startDateTime" class="form-label">Start Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="startDateTime" name="startDateTime" required value="<?php echo isset($_POST['startDateTime']) ? $_POST['startDateTime'] : date('Y-m-d\TH:i'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="endDateTime" class="form-label">End Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="endDateTime" name="endDateTime" required value="<?php echo isset($_POST['endDateTime']) ? $_POST['endDateTime'] : date('Y-m-d\TH:i', strtotime('+1 day')); ?>">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Calculate Duration</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Calendar Converter -->
                    <div class="tab-pane fade <?php echo ($calculationType === 'calendarConverter') ? 'show active' : ''; ?>" id="calendarConverter">
                        <form method="post" action="">
                            <input type="hidden" name="calculationType" value="calendarConverter">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="gregorianDate" class="form-label">Gregorian Date</label>
                                    <input type="date" class="form-control" id="gregorianDate" name="gregorianDate" required value="<?php echo isset($_POST['gregorianDate']) ? $_POST['gregorianDate'] : date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="targetCalendar" class="form-label">Target Calendar</label>
                                    <select class="form-select" id="targetCalendar" name="targetCalendar">
                                        <option value="Julian" <?php echo (isset($_POST['targetCalendar']) && $_POST['targetCalendar'] === 'Julian') ? 'selected' : ''; ?>>Julian</option>
                                        <option value="Hijri" <?php echo (isset($_POST['targetCalendar']) && $_POST['targetCalendar'] === 'Hijri') ? 'selected' : ''; ?>>Hijri (Islamic)</option>
                                        <option value="Hebrew" <?php echo (isset($_POST['targetCalendar']) && $_POST['targetCalendar'] === 'Hebrew') ? 'selected' : ''; ?>>Hebrew</option>
                                        <option value="Hindu" <?php echo (isset($_POST['targetCalendar']) && $_POST['targetCalendar'] === 'Hindu') ? 'selected' : ''; ?>>Hindu (Saka)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Convert</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Timezone Converter -->
                    <div class="tab-pane fade <?php echo ($calculationType === 'timezoneConverter') ? 'show active' : ''; ?>" id="timezoneConverter">
                        <form method="post" action="">
                            <input type="hidden" name="calculationType" value="timezoneConverter">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="sourceDateTime" class="form-label">Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="sourceDateTime" name="sourceDateTime" required value="<?php echo isset($_POST['sourceDateTime']) ? $_POST['sourceDateTime'] : date('Y-m-d\TH:i'); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="sourceTimezone" class="form-label">From Timezone</label>
                                    <select class="form-select" id="sourceTimezone" name="sourceTimezone">
                                        <?php foreach ($timezones as $timezone): ?>
                                            <option value="<?php echo $timezone; ?>" <?php echo (isset($_POST['sourceTimezone']) && $_POST['sourceTimezone'] === $timezone) || (!isset($_POST['sourceTimezone']) && $timezone === 'UTC') ? 'selected' : ''; ?>><?php echo $timezone; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="targetTimezone" class="form-label">To Timezone</label>
                                    <select class="form-select" id="targetTimezone" name="targetTimezone">
                                        <?php foreach ($timezones as $timezone): ?>
                                            <option value="<?php echo $timezone; ?>" <?php echo (isset($_POST['targetTimezone']) && $_POST['targetTimezone'] === $timezone) || (!isset($_POST['targetTimezone']) && $timezone === 'America/New_York') ? 'selected' : ''; ?>><?php echo $timezone; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Convert</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Fiscal Year Calculator -->
                    <div class="tab-pane fade <?php echo ($calculationType === 'fiscalYear') ? 'show active' : ''; ?>" id="fiscalYear">
                        <form method="post" action="">
                            <input type="hidden" name="calculationType" value="fiscalYear">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="fiscalDate" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="fiscalDate" name="fiscalDate" required value="<?php echo isset($_POST['fiscalDate']) ? $_POST['fiscalDate'] : date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="fiscalStartMonth" class="form-label">Fiscal Year Start Month</label>
                                    <select class="form-select" id="fiscalStartMonth" name="fiscalStartMonth">
                                        <?php foreach ($fiscalStartMonths as $value => $month): ?>
                                            <option value="<?php echo $value; ?>" <?php echo (isset($_POST['fiscalStartMonth']) && (int)$_POST['fiscalStartMonth'] === $value) || (!isset($_POST['fiscalStartMonth']) && $value === 4) ? 'selected' : ''; ?>><?php echo $month; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Calculate Fiscal Year</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (!empty($result)): ?>
        <div class="card result-card mt-4 fade-in">
            <div class="card-body">
                <h3 class="card-title">Result</h3>
                <div class="result-value mb-3"><?php echo $result; ?></div>
                <div class="result-details"><?php echo $resultDetails; ?></div>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="text-center mb-4">Features</h2>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16">
                                <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                            </svg>
                        </div>
                        <h3 class="h5">Basic Features</h3>
                        <p>Calculate days between dates, add or subtract days, weeks, months, or years from a date, and find past or future dates with ease.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-calculator" viewBox="0 0 16 16">
                                <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"/>
                            </svg>
                        </div>
                        <h3 class="h5">Advanced Calculations</h3>
                        <p>Calculate age precisely, find weekdays, count working days, determine week numbers, check leap years, and calculate time durations.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
                                <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.47 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"/>
                            </svg>
                        </div>
                        <h3 class="h5">Global Support</h3>
                        <p>Convert between calendar systems, adjust for different time zones, and calculate fiscal years based on country-specific calendars.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h3>Date Calculator</h3>
                    <p>A comprehensive tool for all your date and time calculation needs. Whether you're calculating days between dates, your age, business days, or converting between calendars, our tool has you covered.</p>
                </div>
                <div class="col-md-4">
                    <h3>Quick Links</h3>
                    <ul class="list-unstyled">
                        <li><a href="#daysBetween" class="text-decoration-none">Days Between Dates</a></li>
                        <li><a href="#addSubtract" class="text-decoration-none">Add/Subtract Days</a></li>
                        <li><a href="#ageCalculator" class="text-decoration-none">Age Calculator</a></li>
                        <li><a href="#weekdayFinder" class="text-decoration-none">Weekday Finder</a></li>
                        <li><a href="#workingDays" class="text-decoration-none">Working Days Calculator</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; <?php echo date('Y'); ?> Date Calculator Tool. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- SEO Content for search engines -->
    <div class="d-none">
        <h2>Free Online Date Calculator Tool</h2>
        <p>Our date calculator offers a comprehensive suite of date and time calculation features. Calculate days between dates, add or subtract days from a date, find your age, determine weekdays, count working days, convert between calendar systems, and more.</p>
        
        <h2>Calculate Days Between Dates</h2>
        <p>Find the exact number of days, weeks, months, and years between any two dates. Our days between dates calculator helps you plan projects, count down to events, or calculate time passed.</p>
        
        <h2>Age Calculator: Find Your Exact Age</h2>
        <p>Calculate your precise age in years, months, days, hours, and even minutes. Our age calculator shows you exactly how long you've been alive.</p>
        
        <h2>Working Days Calculator</h2>
        <p>Calculate the number of business days between dates, excluding weekends and holidays. Perfect for project planning and deadline calculations.</p>
        
        <h2>Calendar Converter</h2>
        <p>Convert dates between different calendar systems including Gregorian, Julian, Hijri (Islamic), and Hebrew calendars.</p>
        
        <h2>Timezone Converter</h2>
        <p>Convert times between different timezones easily. Plan international meetings and calls without the confusion.</p>
        
        <h2>Date Calculator Features</h2>
        <ul>
            <li>Days Between Dates Calculator</li>
            <li>Add or Subtract Days Calculator</li>
            <li>Age Calculator</li>
            <li>Weekday Finder</li>
            <li>Working Days Calculator</li>
            <li>Week Number Calculator</li>
            <li>Leap Year Checker</li>
            <li>Time Duration Calculator</li>
            <li>Calendar Converter</li>
            <li>Timezone Converter</li>
            <li>Fiscal Year Calculator</li>
        </ul>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab navigation
            const navLinks = document.querySelectorAll('.nav-link, .dropdown-item');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.dataset.calc) {
                e.preventDefault();
                
                // Update active tab
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                
                // If it's a dropdown item, also activate the parent dropdown
                if (this.classList.contains('dropdown-item')) {
                    document.querySelector('[data-bs-toggle="dropdown"]').classList.add('active');
                }
                
                // Update form's calculator type
                const formId = this.dataset.calc;
                document.getElementById(formId).classList.add('show', 'active');
                
                // Hide other tabs
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    if (pane.id !== formId) {
                        pane.classList.remove('show', 'active');
                    }
                });
                
                // Update hidden input
                document.querySelectorAll('input[name="calculationType"]').forEach(input => {
                    input.value = formId;
                });
            }
        });
    });
            
            // Timezone filter
            const timezoneSelects = document.querySelectorAll('#sourceTimezone, #targetTimezone');
            timezoneSelects.forEach(select => {
                const filterInput = document.createElement('input');
                filterInput.className = 'form-control mb-2';
                filterInput.placeholder = 'Search timezone...';
                
                select.parentNode.insertBefore(filterInput, select);
                
                filterInput.addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    const options = select.querySelectorAll('option');
                    
                    options.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
            });
            
            // Highlight result section when new result is shown
            const resultCard = document.querySelector('.result-card');
            if (resultCard) {
                resultCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Holiday input enhancement
            const holidayInput = document.getElementById('holidays');
            if (holidayInput) {
                const addHolidayBtn = document.createElement('button');
                addHolidayBtn.type = 'button';
                addHolidayBtn.className = 'btn btn-outline-secondary mt-2';
                addHolidayBtn.textContent = 'Add Today';
                
                addHolidayBtn.addEventListener('click', function() {
                    const today = new Date().toISOString().split('T')[0];
                    if (holidayInput.value) {
                        if (!holidayInput.value.includes(today)) {
                            holidayInput.value += ', ' + today;
                        }
                    } else {
                        holidayInput.value = today;
                    }
                });
                
                holidayInput.parentNode.appendChild(addHolidayBtn);
            }
            
            // Auto-update week number when changing date
            const weekDateInput = document.getElementById('weekDate');
            if (weekDateInput) {
                weekDateInput.addEventListener('change', function() {
                    const weekNumberForm = this.closest('form');
                    if (weekNumberForm) {
                        weekNumberForm.submit();
                    }
                });
            }
            
            // Enable navigation to specific calculator via URL hash
            const hash = window.location.hash.substring(1);
            if (hash) {
                const tab = document.querySelector(`[data-calc="${hash}"]`);
                if (tab) {
                    tab.click();
                }
            }
        });
    </script>
    
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "Date Calculator",
  "url": "https://infinitytoolspace.com/tools/date-calculator",
  "description": "Free online date calculator tool to calculate date differences, or to add/subtract days, weeks, months, or years from any given date.",
  "applicationCategory": "Utility",
  "operatingSystem": "All",
  "browserRequirements": "Works on all modern browsers",
  "image": "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgp94c5BwOWCgkZkdM1JhJksNLEfM3cDOJjcbVsjV8lPLvjnXe93QaTEFPf57YM-zi41Z-UR8xnr2tldLHO6sCEb480Fx0teC7GRiXhoZ-AZMIyQ79WTAYDOEqhMeMBT73F6-zb3l0fvtfmbqoC46VvwkqOtJAnX4Ky_yXN3uP67o3v1UD_oP0Oft-fub0/s16000/date_calculator.jpeg"
}
</script>

</body>
</html>