<?php
// Instagram Font Generator Tool - Single PHP File Application
// Copyright 2025 - All Rights Reserved

// Font Styles Array
$fontStyles = [
    'fancy' => [
        'name' => 'Fancy Style',
        'transformer' => function($text) {
            $fancy = '';
            $chars = [
                'a' => 'ᗩ', 'b' => 'ᗷ', 'c' => 'ᑕ', 'd' => 'ᗪ', 'e' => 'E', 'f' => 'ᖴ', 
                'g' => 'G', 'h' => 'ᕼ', 'i' => 'I', 'j' => 'ᒍ', 'k' => 'K', 'l' => 'ᒪ', 
                'm' => 'ᗰ', 'n' => 'ᑎ', 'o' => 'O', 'p' => 'ᑭ', 'q' => 'ᑫ', 'r' => 'ᖇ', 
                's' => 'ᔕ', 't' => 'T', 'u' => 'ᑌ', 'v' => 'ᐯ', 'w' => 'ᗯ', 'x' => '᙭', 
                'y' => 'Y', 'z' => 'ᘔ'
            ];
            for ($i = 0; $i < mb_strlen($text); $i++) {
                $char = mb_strtolower(mb_substr($text, $i, 1));
                $fancy .= isset($chars[$char]) ? $chars[$char] : $char;
            }
            return $fancy;
        }
    ],
    'bold' => [
        'name' => 'Bold Font',
        'transformer' => function($text) {
            $bold = '';
            $chars = [
                'a' => '𝗮', 'b' => '𝗯', 'c' => '𝗰', 'd' => '𝗱', 'e' => '𝗲', 'f' => '𝗳', 
                'g' => '𝗴', 'h' => '𝗵', 'i' => '𝗶', 'j' => '𝗷', 'k' => '𝗸', 'l' => '𝗹', 
                'm' => '𝗺', 'n' => '𝗻', 'o' => '𝗼', 'p' => '𝗽', 'q' => '𝗾', 'r' => '𝗿', 
                's' => '𝘀', 't' => '𝘁', 'u' => '𝘂', 'v' => '𝘃', 'w' => '𝘄', 'x' => '𝘅', 
                'y' => '𝘆', 'z' => '𝘇',
                'A' => '𝗔', 'B' => '𝗕', 'C' => '𝗖', 'D' => '𝗗', 'E' => '𝗘', 'F' => '𝗙', 
                'G' => '𝗚', 'H' => '𝗛', 'I' => '𝗜', 'J' => '𝗝', 'K' => '𝗞', 'L' => '𝗟', 
                'M' => '𝗠', 'N' => '𝗡', 'O' => '𝗢', 'P' => '𝗣', 'Q' => '𝗤', 'R' => '𝗥', 
                'S' => '𝗦', 'T' => '𝗧', 'U' => '𝗨', 'V' => '𝗩', 'W' => '𝗪', 'X' => '𝗫', 
                'Y' => '𝗬', 'Z' => '𝗭'
            ];
            for ($i = 0; $i < mb_strlen($text); $i++) {
                $char = mb_substr($text, $i, 1);
                $bold .= isset($chars[$char]) ? $chars[$char] : $char;
            }
            return $bold;
        }
    ],
    'italic' => [
        'name' => 'Italic Font',
        'transformer' => function($text) {
            $italic = '';
            $chars = [
                'a' => '𝘢', 'b' => '𝘣', 'c' => '𝘤', 'd' => '𝘥', 'e' => '𝘦', 'f' => '𝘧', 
                'g' => '𝘨', 'h' => '𝘩', 'i' => '𝘪', 'j' => '𝘫', 'k' => '𝘬', 'l' => '𝘭', 
                'm' => '𝘮', 'n' => '𝘯', 'o' => '𝘰', 'p' => '𝘱', 'q' => '𝘲', 'r' => '𝘳', 
                's' => '𝘴', 't' => '𝘵', 'u' => '𝘶', 'v' => '𝘷', 'w' => '𝘸', 'x' => '𝘹', 
                'y' => '𝘺', 'z' => '𝘻',
                'A' => '𝘈', 'B' => '𝘉', 'C' => '𝘊', 'D' => '𝘋', 'E' => '𝘌', 'F' => '𝘍', 
                'G' => '𝘎', 'H' => '𝘏', 'I' => '𝘐', 'J' => '𝘑', 'K' => '𝘒', 'L' => '𝘓', 
                'M' => '𝘔', 'N' => '𝘕', 'O' => '𝘖', 'P' => '𝘗', 'Q' => '𝘘', 'R' => '𝘙', 
                'S' => '𝘚', 'T' => '𝘛', 'U' => '𝘜', 'V' => '𝘝', 'W' => '𝘞', 'X' => '𝘟', 
                'Y' => '𝘠', 'Z' => '𝘡'
            ];
            for ($i = 0; $i < mb_strlen($text); $i++) {
                $char = mb_substr($text, $i, 1);
                $italic .= isset($chars[$char]) ? $chars[$char] : $char;
            }
            return $italic;
        }
    ],
    'script' => [
        'name' => 'Script Style',
        'transformer' => function($text) {
            $script = '';
            $chars = [
                'a' => '𝒶', 'b' => '𝒷', 'c' => '𝒸', 'd' => '𝒹', 'e' => 'ℯ', 'f' => '𝒻', 
                'g' => 'ℊ', 'h' => '𝒽', 'i' => '𝒾', 'j' => '𝒿', 'k' => '𝓀', 'l' => '𝓁', 
                'm' => '𝓂', 'n' => '𝓃', 'o' => 'ℴ', 'p' => '𝓅', 'q' => '𝓆', 'r' => '𝓇', 
                's' => '𝓈', 't' => '𝓉', 'u' => '𝓊', 'v' => '𝓋', 'w' => '𝓌', 'x' => '𝓍', 
                'y' => '𝓎', 'z' => '𝓏',
                'A' => '𝒜', 'B' => 'ℬ', 'C' => '𝒞', 'D' => '𝒟', 'E' => 'ℰ', 'F' => 'ℱ', 
                'G' => '𝒢', 'H' => 'ℋ', 'I' => 'ℐ', 'J' => '𝒥', 'K' => '𝒦', 'L' => 'ℒ', 
                'M' => 'ℳ', 'N' => '𝒩', 'O' => '𝒪', 'P' => '𝒫', 'Q' => '𝒬', 'R' => 'ℛ', 
                'S' => '𝒮', 'T' => '𝒯', 'U' => '𝒰', 'V' => '𝒱', 'W' => '𝒲', 'X' => '𝒳', 
                'Y' => '𝒴', 'Z' => '𝒵'
            ];
            for ($i = 0; $i < mb_strlen($text); $i++) {
                $char = mb_substr($text, $i, 1);
                $script .= isset($chars[$char]) ? $chars[$char] : $char;
            }
            return $script;
        }
    ],
    'double_struck' => [
        'name' => 'Double-Struck',
        'transformer' => function($text) {
            $doubleStruck = '';
            $chars = [
                'a' => '𝕒', 'b' => '𝕓', 'c' => '𝕔', 'd' => '𝕕', 'e' => '𝕖', 'f' => '𝕗', 
                'g' => '𝕘', 'h' => '𝕙', 'i' => '𝕚', 'j' => '𝕛', 'k' => '𝕜', 'l' => '𝕝', 
                'm' => '𝕞', 'n' => '𝕟', 'o' => '𝕠', 'p' => '𝕡', 'q' => '𝕢', 'r' => '𝕣', 
                's' => '𝕤', 't' => '𝕥', 'u' => '𝕦', 'v' => '𝕧', 'w' => '𝕨', 'x' => '𝕩', 
                'y' => '𝕪', 'z' => '𝕫',
                'A' => '𝔸', 'B' => '𝔹', 'C' => 'ℂ', 'D' => '𝔻', 'E' => '𝔼', 'F' => '𝔽', 
                'G' => '𝔾', 'H' => 'ℍ', 'I' => '𝕀', 'J' => '𝕁', 'K' => '𝕂', 'L' => '𝕃', 
                'M' => '𝕄', 'N' => 'ℕ', 'O' => '𝕆', 'P' => 'ℙ', 'Q' => 'ℚ', 'R' => 'ℝ', 
                'S' => '𝕊', 'T' => '𝕋', 'U' => '𝕌', 'V' => '𝕍', 'W' => '𝕎', 'X' => '𝕏', 
                'Y' => '𝕐', 'Z' => 'ℤ'
            ];
            for ($i = 0; $i < mb_strlen($text); $i++) {
                $char = mb_substr($text, $i, 1);
                $doubleStruck .= isset($chars[$char]) ? $chars[$char] : $char;
            }
            return $doubleStruck;
        }
    ],
    'small_caps' => [
        'name' => 'Small Caps',
        'transformer' => function($text) {
            $smallCaps = '';
            $chars = [
                'a' => 'ᴀ', 'b' => 'ʙ', 'c' => 'ᴄ', 'd' => 'ᴅ', 'e' => 'ᴇ', 'f' => 'ꜰ', 
                'g' => 'ɢ', 'h' => 'ʜ', 'i' => 'ɪ', 'j' => 'ᴊ', 'k' => 'ᴋ', 'l' => 'ʟ', 
                'm' => 'ᴍ', 'n' => 'ɴ', 'o' => 'ᴏ', 'p' => 'ᴘ', 'q' => 'ǫ', 'r' => 'ʀ', 
                's' => 's', 't' => 'ᴛ', 'u' => 'ᴜ', 'v' => 'ᴠ', 'w' => 'ᴡ', 'x' => 'x', 
                'y' => 'ʏ', 'z' => 'ᴢ'
            ];
            for ($i = 0; $i < mb_strlen($text); $i++) {
                $char = mb_strtolower(mb_substr($text, $i, 1));
                $smallCaps .= isset($chars[$char]) ? $chars[$char] : $char;
            }
            return $smallCaps;
        }
    ],
    'upside_down' => [
        'name' => 'Upside Down',
        'transformer' => function($text) {
            $upsideDown = '';
            $chars = [
                'a' => 'ɐ', 'b' => 'q', 'c' => 'ɔ', 'd' => 'p', 'e' => 'ǝ', 'f' => 'ɟ', 
                'g' => 'ƃ', 'h' => 'ɥ', 'i' => 'ᴉ', 'j' => 'ɾ', 'k' => 'ʞ', 'l' => 'l', 
                'm' => 'ɯ', 'n' => 'u', 'o' => 'o', 'p' => 'd', 'q' => 'b', 'r' => 'ɹ', 
                's' => 's', 't' => 'ʇ', 'u' => 'n', 'v' => 'ʌ', 'w' => 'ʍ', 'x' => 'x', 
                'y' => 'ʎ', 'z' => 'z',
                'A' => '∀', 'B' => 'B', 'C' => 'Ɔ', 'D' => 'D', 'E' => 'Ǝ', 'F' => 'Ⅎ', 
                'G' => 'פ', 'H' => 'H', 'I' => 'I', 'J' => 'ſ', 'K' => 'K', 'L' => '˥', 
                'M' => 'W', 'N' => 'N', 'O' => 'O', 'P' => 'Ԁ', 'Q' => 'Q', 'R' => 'R', 
                'S' => 'S', 'T' => '┴', 'U' => '∩', 'V' => 'Λ', 'W' => 'M', 'X' => 'X', 
                'Y' => '⅄', 'Z' => 'Z',
                '0' => '0', '1' => 'Ɩ', '2' => 'ᄅ', '3' => 'Ɛ', '4' => 'ㄣ', 
                '5' => 'ϛ', '6' => '9', '7' => 'ㄥ', '8' => '8', '9' => '6',
                ',' => '\'', '.' => '˙', '?' => '¿', '!' => '¡', 
                '"' => '„', '\'' => ',', '(' => ')', ')' => '(', 
                '[' => ']', ']' => '[', '{' => '}', '}' => '{', 
                '<' => '>', '>' => '<', '&' => '⅋', '_' => '‾'
            ];
            $text = strrev($text);
            for ($i = 0; $i < mb_strlen($text); $i++) {
                $char = mb_substr($text, $i, 1);
                $upsideDown .= isset($chars[$char]) ? $chars[$char] : $char;
            }
            return $upsideDown;
        }
    ],
    'aesthetic' => [
        'name' => 'Aesthetic',
        'transformer' => function($text) {
            $aesthetic = '';
            $chars = str_split(strtoupper($text));
            foreach ($chars as $char) {
                if ($char == ' ') {
                    $aesthetic .= '   ';
                } else {
                    $aesthetic .= $char . ' ';
                }
            }
            return $aesthetic;
        }
    ],
    'bubble' => [
        'name' => 'Bubble Font',
        'transformer' => function($text) {
            $bubble = '';
            $chars = [
                'a' => 'ⓐ', 'b' => 'ⓑ', 'c' => 'ⓒ', 'd' => 'ⓓ', 'e' => 'ⓔ', 'f' => 'ⓕ', 
                'g' => 'ⓖ', 'h' => 'ⓗ', 'i' => 'ⓘ', 'j' => 'ⓙ', 'k' => 'ⓚ', 'l' => 'ⓛ', 
                'm' => 'ⓜ', 'n' => 'ⓝ', 'o' => 'ⓞ', 'p' => 'ⓟ', 'q' => 'ⓠ', 'r' => 'ⓡ', 
                's' => 'ⓢ', 't' => 'ⓣ', 'u' => 'ⓤ', 'v' => 'ⓥ', 'w' => 'ⓦ', 'x' => 'ⓧ', 
                'y' => 'ⓨ', 'z' => 'ⓩ',
                'A' => 'Ⓐ', 'B' => 'Ⓑ', 'C' => 'Ⓒ', 'D' => 'Ⓓ', 'E' => 'Ⓔ', 'F' => 'Ⓕ', 
                'G' => 'Ⓖ', 'H' => 'Ⓗ', 'I' => 'Ⓘ', 'J' => 'Ⓙ', 'K' => 'Ⓚ', 'L' => 'Ⓛ', 
                'M' => 'Ⓜ', 'N' => 'Ⓝ', 'O' => 'Ⓞ', 'P' => 'Ⓟ', 'Q' => 'Ⓠ', 'R' => 'Ⓡ', 
                'S' => 'Ⓢ', 'T' => 'Ⓣ', 'U' => 'Ⓤ', 'V' => 'Ⓥ', 'W' => 'Ⓦ', 'X' => 'Ⓧ', 
                'Y' => 'Ⓨ', 'Z' => 'Ⓩ',
                '0' => '⓪', '1' => '①', '2' => '②', '3' => '③', '4' => '④', 
                '5' => '⑤', '6' => '⑥', '7' => '⑦', '8' => '⑧', '9' => '⑨'
            ];
            for ($i = 0; $i < mb_strlen($text); $i++) {
                $char = mb_substr($text, $i, 1);
                $bubble .= isset($chars[$char]) ? $chars[$char] : $char;
            }
            return $bubble;
        }
    ],
    'emoji' => [
        'name' => 'Emoji Style',
        'transformer' => function($text) {
            $emoji = '';
            $emojiMap = [
                'a' => '🅰️', 'b' => '🅱️', 'c' => '©️', 'd' => '🌀', 'e' => '📧', 'f' => '🎏', 
                'g' => '🌀', 'h' => '♓', 'i' => 'ℹ️', 'j' => '🗾', 'k' => '🎋', 'l' => '🕒', 
                'm' => 'Ⓜ️', 'n' => '🎵', 'o' => '⭕', 'p' => '🅿️', 'q' => '🍳', 'r' => '®️', 
                's' => '💲', 't' => '✝️', 'u' => '⛎', 'v' => '♈', 'w' => '〰️', 'x' => '❌', 
                'y' => '💹', 'z' => '💤'
            ];
            
            for ($i = 0; $i < mb_strlen($text); $i++) {
                $char = mb_strtolower(mb_substr($text, $i, 1));
                $emoji .= isset($emojiMap[$char]) ? $emojiMap[$char] : $char;
                $emoji .= ' ';
            }
            return $emoji;
        }
    ],
    'monospace' => [
        'name' => 'Monospace',
        'transformer' => function($text) {
            $monospace = '';
            $chars = [
                'a' => '𝚊', 'b' => '𝚋', 'c' => '𝚌', 'd' => '𝚍', 'e' => '𝚎', 'f' => '𝚏', 
                'g' => '𝚐', 'h' => '𝚑', 'i' => '𝚒', 'j' => '𝚓', 'k' => '𝚔', 'l' => '𝚕', 
                'm' => '𝚖', 'n' => '𝚗', 'o' => '𝚘', 'p' => '𝚙', 'q' => '𝚚', 'r' => '𝚛', 
                's' => '𝚜', 't' => '𝚝', 'u' => '𝚞', 'v' => '𝚟', 'w' => '𝚠', 'x' => '𝚡', 
                'y' => '𝚢', 'z' => '𝚣',
                'A' => '𝙰', 'B' => '𝙱', 'C' => '𝙲', 'D' => '𝙳', 'E' => '𝙴', 'F' => '𝙵', 
                'G' => '𝙶', 'H' => '𝙷', 'I' => '𝙸', 'J' => '𝙹', 'K' => '𝙺', 'L' => '𝙻', 
                'M' => '𝙼', 'N' => '𝙽', 'O' => '𝙾', 'P' => '𝙿', 'Q' => '𝚀', 'R' => '𝚁', 
                'S' => '𝚂', 'T' => '𝚃', 'U' => '𝚄', 'V' => '𝚅', 'W' => '𝚆', 'X' => '𝚇', 
                'Y' => '𝚈', 'Z' => '𝚉',
                '0' => '𝟶', '1' => '𝟷', '2' => '𝟸', '3' => '𝟹', '4' => '𝟺', 
                '5' => '𝟻', '6' => '𝟼', '7' => '𝟽', '8' => '𝟾', '9' => '𝟿'
            ];
            for ($i = 0; $i < mb_strlen($text); $i++) {
                $char = mb_substr($text, $i, 1);
                $monospace .= isset($chars[$char]) ? $chars[$char] : $char;
            }
            return $monospace;
        }
    ]
];

// Process form submission
$inputText = '';
$outputText = '';
$selectedStyle = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputText = isset($_POST['inputText']) ? $_POST['inputText'] : '';
    $selectedStyle = isset($_POST['fontStyle']) ? $_POST['fontStyle'] : 'fancy';
    
    if (!empty($inputText) && isset($fontStyles[$selectedStyle])) {
        $transformer = $fontStyles[$selectedStyle]['transformer'];
        $outputText = $transformer($inputText);
    }
}

// Privacy Policy
$privacyPolicy = "
<h2>Privacy Policy</h2>
<p>Last updated: March 12, 2025</p>

<p>This Privacy Policy describes how we collect, use, and handle your information when you use our Instagram Font Generator application.</p>

<h3>Information We Collect</h3>
<p>We do not collect or store any of the text you input into our font generator. All text processing happens locally in your browser, and we do not transmit your data to our servers.</p>

<h3>Device Information</h3>
<p>We may collect device-specific information (such as your hardware model, operating system version, unique device identifiers, and mobile network information).</p>

<h3>Log Data</h3>
<p>When you use our service, we may automatically collect and store certain information in server logs. This includes:</p>
<ul>
    <li>Details of how you used our service</li>
    <li>Device event information such as crashes, system activity, hardware settings</li>
    <li>IP address</li>
</ul>

<h3>Cookies</h3>
<p>We use cookies to enhance your experience and analyze our traffic. You can set your browser to refuse all cookies or to indicate when a cookie is being sent.</p>

<h3>How We Use Information</h3>
<p>We use the information we collect to:</p>
<ul>
    <li>Provide, maintain, and improve our services</li>
    <li>Develop new services</li>
    <li>Protect against abuse and unauthorized access</li>
    <li>Measure performance and understand how our services are used</li>
</ul>

<h3>Information Sharing</h3>
<p>We do not share personal information with companies, organizations, or individuals outside of our organization except in the following cases:</p>
<ul>
    <li>With your consent</li>
    <li>For legal reasons if we believe disclosure is necessary to comply with any applicable law, regulation, legal process, or governmental request</li>
</ul>

<h3>Children's Privacy</h3>
<p>Our services are not directed to children under 13, and we do not knowingly collect personal information from children under 13.</p>

<h3>Changes to This Privacy Policy</h3>
<p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page.</p>

<h3>Contact Us</h3>
<p>If you have any questions about this Privacy Policy, please contact us at: support@instafontgenerator.com</p>
";

// Terms of Service
$termsOfService = "
<h2>Terms of Service</h2>
<p>Last updated: March 12, 2025</p>

<p>Please read these Terms of Service carefully before using our Instagram Font Generator application.</p>

<h3>Your Agreement</h3>
<p>By using our application, you agree to be bound by these Terms. If you disagree with any part of the terms, you may not access the service.</p>

<h3>Description of Service</h3>
<p>Our Instagram Font Generator provides users with the ability to transform ordinary text into various stylized formats suitable for use on social media platforms, including Instagram.</p>

<h3>Fair Use</h3>
<p>You agree to use the service for personal, non-commercial purposes only. Mass generation of text for spamming or harassment purposes is prohibited.</p>

<h3>Content Responsibility</h3>
<p>You are solely responsible for the content you generate using our service. We do not monitor or control the content you create and are not responsible for any consequences that may arise from your use of the generated text.</p>

<h3>Intellectual Property</h3>
<p>Our service and its original content, features, and functionality are owned by us and are protected by international copyright, trademark, patent, trade secret, and other intellectual property or proprietary rights laws.</p>

<h3>Limitation of Liability</h3>
<p>In no event shall we be liable for any indirect, incidental, special, consequential or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from your access to or use of or inability to access or use the service.</p>

<h3>Disclaimer</h3>
<p>Your use of the service is at your sole risk. The service is provided on an \"AS IS\" and \"AS AVAILABLE\" basis. The service is provided without warranties of any kind, whether express or implied.</p>

<h3>Governing Law</h3>
<p>These Terms shall be governed and construed in accordance with the laws of our jurisdiction, without regard to its conflict of law provisions.</p>

<h3>Changes to Terms</h3>
<p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. By continuing to access or use our service after those revisions become effective, you agree to be bound by the revised terms.</p>

<h3>Contact Us</h3>
<p>If you have any questions about these Terms, please contact us at: legal@instafontgenerator.com</p>
";

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Instagram Font Generator - Create Stylish Bio & Captions</title>
   <meta name="description" content="Create stylish Instagram fonts for your bio, captions and comments. Copy and paste fancy text that works on Instagram. Free Instagram font generator.">
   <meta name="keywords" content="Instagram font, Instagram font generator, Instagram bio fonts, Instagram caption fonts, font generator, stylish text, fancy fonts, cool Instagram fonts">
   
   <!-- Favicon -->
   <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>✨</text></svg>">
   
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   
   <!-- Custom CSS -->
   <style>
       :root {
           --primary: #833AB4;
           --primary-light: #C13584;
           --primary-dark: #5851DB;
           --secondary: #E1306C;
           --accent: #FCAF45;
           --text-light: #ffffff;
           --text-dark: #262626;
           --bg-light: #FAFAFA;
           --bg-dark: #121212;
       }
       
       body {
           font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
           background: linear-gradient(135deg, var(--bg-light) 0%, #f5f5f5 100%);
           color: var(--text-dark);
           min-height: 100vh;
           padding-bottom: 60px;
           position: relative;
       }
       
       .dark-mode {
           background: linear-gradient(135deg, var(--bg-dark) 0%, #1a1a1a 100%);
           color: var(--text-light);
       }
       
       .container {
           max-width: 800px;
       }
       
       .app-title {
           background: -webkit-linear-gradient(45deg, var(--primary), var(--secondary));
           -webkit-background-clip: text;
           -webkit-text-fill-color: transparent;
           font-weight: 700;
           margin: 1.5rem 0;
       }
       
       .card {
           border-radius: 15px;
           border: none;
           box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
           overflow: hidden;
           transition: all 0.3s ease;
       }
       
       .card:hover {
           transform: translateY(-5px);
           box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
       }
       
       .dark-mode .card {
           background-color: #2a2a2a;
           color: var(--text-light);
           box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
       }
       
       .form-control, .btn, .form-select {
           border-radius: 10px;
           padding: 12px 20px;
           font-size: 16px;
       }
       
       .form-control:focus, .form-select:focus {
           box-shadow: 0 0 0 0.25rem rgba(131, 58, 180, 0.25);
           border-color: var(--primary);
       }
       
       .dark-mode .form-control, .dark-mode .form-select {
           background-color: #333;
           border-color: #444;
           color: var(--text-light);
       }
       
       .dark-mode .form-control::placeholder {
           color: #aaa;
       }
       
       textarea {
           resize: none;
           min-height: 120px;
       }
       
       .output-area {
           min-height: 120px;
           background-color: #fff;
           border-radius: 10px;
           padding: 15px;
           margin-bottom: 20px;
           word-wrap: break-word;
           overflow-wrap: break-word;
           border: 1px solid #dee2e6;
       }
       
       .dark-mode .output-area {
           background-color: #333;
           border-color: #444;
       }
       
       .btn-gradient {
           background: linear-gradient(45deg, var(--primary), var(--secondary));
           border: none;
           color: white;
           font-weight: 600;
           transition: all 0.3s ease;
       }
       
       .btn-gradient:hover {
           background: linear-gradient(45deg, var(--primary-dark), var(--primary));
           transform: translateY(-2px);
           box-shadow: 0 5px 15px rgba(131, 58, 180, 0.4);
       }
       
       .btn-outline-dark {
           border-color: var(--primary);
           color: var(--primary);
       }
       
       .btn-outline-dark:hover {
           background-color: var(--primary);
           border-color: var(--primary);
       }
       
       .dark-mode .btn-outline-dark {
           border-color: var(--primary-light);
           color: var(--primary-light);
       }
       
       .dark-mode .btn-outline-dark:hover {
           background-color: var(--primary-light);
           border-color: var(--primary-light);
           color: var(--text-light);
       }
       
       .font-preview {
           font-size: 1.2rem;
           padding: 10px;
           border-radius: 8px;
           margin-bottom: 10px;
           cursor: pointer;
           transition: all 0.2s ease;
           background-color: #fff;
           border: 1px solid #dee2e6;
       }
       
       .dark-mode .font-preview {
           background-color: #333;
           border-color: #444;
       }
       
       .font-preview:hover {
           background-color: #f8f9fa;
           transform: translateY(-2px);
       }
       
       .dark-mode .font-preview:hover {
           background-color: #444;
       }
       
       .theme-toggle {
           position: fixed;
           bottom: 20px;
           right: 20px;
           width: 50px;
           height: 50px;
           border-radius: 50%;
           background: linear-gradient(45deg, var(--primary), var(--secondary));
           color: white;
           display: flex;
           align-items: center;
           justify-content: center;
           cursor: pointer;
           box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
           z-index: 1000;
           border: none;
       }
       
       .info-icon {
           font-size: 1.2rem;
           cursor: pointer;
           color: var(--primary);
           margin-left: 10px;
       }
       
       .dark-mode .info-icon {
           color: var(--primary-light);
       }
       
       .modal-content {
           border-radius: 15px;
       }
       
       .dark-mode .modal-content {
           background-color: #2a2a2a;
           color: var(--text-light);
       }
       
       .dark-mode .modal-header, .dark-mode .modal-footer {
           border-color: #444;
       }
       
       .dark-mode .btn-close {
           filter: invert(1) grayscale(100%) brightness(200%);
       }
       
       .tab-content {
           padding: 20px 0;
       }
       
       .nav-tabs .nav-link {
           color: var(--text-dark);
       }
       
       .dark-mode .nav-tabs .nav-link {
           color: var(--text-light);
       }
       
       .nav-tabs .nav-link.active {
           color: var(--primary);
           background-color: transparent;
           border-color: transparent;
           border-bottom: 2px solid var(--primary);
       }
       
       .dark-mode .nav-tabs .nav-link.active {
           color: var(--primary-light);
           border-bottom: 2px solid var(--primary-light);
       }
       
       .how-to-use-item {
           margin-bottom: 15px;
           padding-left: 25px;
           position: relative;
       }
       
       .how-to-use-item:before {
           content: "✓";
           position: absolute;
           left: 0;
           color: var(--primary);
           font-weight: bold;
       }
       
       .dark-mode .how-to-use-item:before {
           color: var(--primary-light);
       }
       
       .loading {
           height: 40px;
           display: flex;
           align-items: center;
           justify-content: center;
       }
       
       .loading-dot {
           width: 8px;
           height: 8px;
           margin: 0 5px;
           background: var(--primary);
           border-radius: 50%;
           animation: loading 1.5s infinite ease-in-out;
       }
       
       .loading-dot:nth-child(2) {
           animation-delay: 0.2s;
           background: var(--primary-light);
       }
       
       .loading-dot:nth-child(3) {
           animation-delay: 0.4s;
           background: var(--secondary);
       }
       
       @keyframes loading {
           0%, 100% {
               transform: scale(0.5);
               opacity: 0.5;
           }
           50% {
               transform: scale(1.2);
               opacity: 1;
           }
       }
       
       .copy-tooltip {
           position: relative;
           display: inline-block;
       }
       
       .copy-tooltip .tooltiptext {
           visibility: hidden;
           width: 100px;
           background-color: var(--text-dark);
           color: var(--text-light);
           text-align: center;
           border-radius: 6px;
           padding: 5px;
           position: absolute;
           z-index: 1;
           bottom: 125%;
           left: 50%;
           margin-left: -50px;
           opacity: 0;
           transition: opacity 0.3s;
           font-size: 12px;
       }
       
       .dark-mode .copy-tooltip .tooltiptext {
           background-color: var(--text-light);
           color: var(--text-dark);
       }
       
       .copy-tooltip .tooltiptext::after {
           content: "";
           position: absolute;
           top: 100%;
           left: 50%;
           margin-left: -5px;
           border-width: 5px;
           border-style: solid;
           border-color: var(--text-dark) transparent transparent transparent;
       }
       
       .dark-mode .copy-tooltip .tooltiptext::after {
           border-color: var(--text-light) transparent transparent transparent;
       }
       
       .copy-tooltip:hover .tooltiptext {
           visibility: visible;
           opacity: 1;
       }
       
       @media (max-width: 767.98px) {
           .app-title {
               font-size: 1.8rem;
           }
           
           .card {
               margin-bottom: 20px;
           }
       }
       
       .legal-content {
           max-height: 300px;
           overflow-y: auto;
           font-size: 0.9rem;
       }
       
       .legal-content h2 {
           font-size: 1.5rem;
       }
       
       .legal-content h3 {
           font-size: 1.2rem;
           margin-top: 15px;
       }
   </style>
</head>
<body>
   <div class="container py-4">
       <h1 class="text-center app-title">Instagram Font Generator</h1>
       
       <div class="row">
           <div class="col-md-12">
               <div class="card mb-4">
                   <div class="card-body">
                       <form method="post" id="fontForm">
                           <div class="mb-3">
                               <label for="inputText" class="form-label">Enter Your Text</label>
                               <div class="d-flex align-items-center">
                                   <textarea class="form-control" id="inputText" name="inputText" placeholder="Type your text here..." required><?php echo htmlspecialchars($inputText); ?></textarea>
                               </div>
                           </div>
                           
                           <div class="mb-3">
                               <label for="fontStyle" class="form-label">Choose Font Style</label>
                               <select class="form-select" id="fontStyle" name="fontStyle">
                                   <?php foreach ($fontStyles as $key => $style) : ?>
                                       <option value="<?php echo $key; ?>" <?php echo ($selectedStyle === $key) ? 'selected' : ''; ?>>
                                           <?php echo $style['name']; ?>
                                       </option>
                                   <?php endforeach; ?>
                               </select>
                           </div>
                           
                           <div class="mb-3">
                               <label class="form-label">Preview</label>
                               <div class="loading" id="previewLoading">
                                   <div class="loading-dot"></div>
                                   <div class="loading-dot"></div>
                                   <div class="loading-dot"></div>
                               </div>
                               <div class="output-area" id="previewArea"></div>
                           </div>
                           
                           <div class="d-grid gap-2">
                               <button type="submit" class="btn btn-gradient">Generate Font</button>
                           </div>
                       </form>
                   </div>
               </div>
               
               <?php if (!empty($outputText)) : ?>
               <div class="card mb-4">
                   <div class="card-body">
                       <h5 class="card-title">Generated Font</h5>
                       <div class="output-area" id="outputText"><?php echo $outputText; ?></div>
                       <div class="d-grid gap-2">
                           <button type="button" class="btn btn-gradient" id="copyBtn">
                               Copy to Clipboard
                               <span class="copy-tooltip">
                                   <span class="tooltiptext" id="copyTooltip">Copy to clipboard</span>
                               </span>
                           </button>
                       </div>
                   </div>
               </div>
               <?php endif; ?>
               
               <div class="card mb-4">
                   <div class="card-body">
                       <h5 class="card-title">Popular Font Styles</h5>
                       <div class="row">
                           <?php 
                           $popularStyles = ['bold', 'italic', 'bubble', 'script', 'monospace']; 
                           foreach ($popularStyles as $styleKey) :
                               if (isset($fontStyles[$styleKey])) :
                                   $style = $fontStyles[$styleKey];
                                   $sampleText = $style['transformer']("Sample Text");
                           ?>
                           <div class="col-md-6 col-lg-4 mb-3">
                               <div class="font-preview" data-style="<?php echo $styleKey; ?>">
                                   <?php echo $sampleText; ?>
                               </div>
                           </div>
                           <?php 
                               endif;
                           endforeach; 
                           ?>
                       </div>
                   </div>
               </div>
               
               <div class="card">
                   <div class="card-body">
                       <h5 class="card-title d-flex align-items-center">
                           About Instagram Font Generator
                           <span class="info-icon" data-bs-toggle="modal" data-bs-target="#infoModal">ℹ️</span>
                       </h5>
                       <p>
                           Our Instagram Font Generator allows you to create stylish and unique text for your Instagram bio, captions, comments, and stories. Stand out from the crowd with fancy fonts that are compatible with Instagram and other social media platforms.
                       </p>
                       <p>
                           Simply type your text, choose a font style, and copy the generated text to paste into your Instagram profile or posts. All the fonts work on Instagram without any issues!
                       </p>
                   </div>
               </div>
           </div>
       </div>
   </div>
   
   <!-- Info Modal -->
   <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="infoModalLabel">Instagram Font Generator</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <ul class="nav nav-tabs" id="infoTabs" role="tablist">
                       <li class="nav-item" role="presentation">
                           <button class="nav-link active" id="howto-tab" data-bs-toggle="tab" data-bs-target="#howto" type="button" role="tab" aria-controls="howto" aria-selected="true">How to Use</button>
                       </li>
                       <li class="nav-item" role="presentation">
                           <button class="nav-link" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy" type="button" role="tab" aria-controls="privacy" aria-selected="false">Privacy Policy</button>
                       </li>
                       <li class="nav-item" role="presentation">
                           <button class="nav-link" id="terms-tab" data-bs-toggle="tab" data-bs-target="#terms" type="button" role="tab" aria-controls="terms" aria-selected="false">Terms of Service</button>
                       </li>
                   </ul>
                   <div class="tab-content" id="infoTabsContent">
                       <div class="tab-pane fade show active" id="howto" role="tabpanel" aria-labelledby="howto-tab">
                           <h4>How to Use the Instagram Font Generator</h4>
                           <div class="how-to-use-item">Type your text in the text box above.</div>
                           <div class="how-to-use-item">Select a font style from the dropdown menu.</div>
                           <div class="how-to-use-item">Click "Generate Font" to create your styled text.</div>
                           <div class="how-to-use-item">Click "Copy to Clipboard" to copy your styled text.</div>
                           <div class="how-to-use-item">Paste the text into your Instagram bio, captions, or comments.</div>
                           
                           <h5 class="mt-4">Tips for Using Fancy Fonts on Instagram</h5>
                           <p>Instagram supports Unicode characters, which is what allows our font generator to work. However, keep these tips in mind:</p>
                           <ul>
                               <li>Some fonts may look different on different devices.</li>
                               <li>Using too many special characters might make your text hard to read.</li>
                               <li>For best results, use fancy fonts sparingly to highlight important parts of your text.</li>
                               <li>If you're using fonts in your bio, make sure critical information (like contact details) remains easily readable.</li>
                           </ul>
                       </div>
                       <div class="tab-pane fade legal-content" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                           <?php echo $privacyPolicy; ?>
                       </div>
                       <div class="tab-pane fade legal-content" id="terms" role="tabpanel" aria-labelledby="terms-tab">
                           <?php echo $termsOfService; ?>
                       </div>
                   </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               </div>
           </div>
       </div>
   </div>
   
   <!-- Theme Toggle Button -->
   <button class="theme-toggle" id="themeToggle">
       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16" id="themeIcon">
           <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
       </svg>
   </button>
   
   <!-- SEO Content (hidden from users but visible to search engines) -->
   <div class="d-none">
       <h2>Instagram Font Generator - Create Stylish Text for Instagram</h2>
       <p>Looking for a way to make your Instagram profile stand out? Our Instagram Font Generator helps you create unique and eye-catching text for your Instagram bio, captions, and comments.</p>
       
       <h3>Why Use Instagram Fonts?</h3>
       <p>Instagram's standard font can be limiting when you want to express your personality. With our font generator, you can transform ordinary text into stylish and creative fonts that are fully compatible with Instagram.</p>
       
       <h3>Features of Our Instagram Font Generator:</h3>
       <p>• Multiple font styles to choose from including bold, italic, script, and more<br>
       • Real-time preview of how your text will look<br>
       • Simple copy and paste functionality<br>
       • Works with Instagram bio, captions, comments, and stories<br>
       • Completely free to use<br>
       • No registration required</p>
       
       <h3>How to Use Fancy Fonts on Instagram</h3>
       <p>1. Enter your text in our generator<br>
       2. Select your preferred font style<br>
       3. Copy the generated font<br>
       4. Paste it into your Instagram bio or captions</p>
       
       <h3>Popular Instagram Font Styles</h3>
       <p>• Bold fonts for making important text stand out<br>
       • Italic fonts for adding emphasis<br>
       • Script fonts for an elegant look<br>
       • Bubble fonts for a playful appearance<br>
       • Small caps for a clean, professional style</p>
       
       <h3>Make Your Instagram Profile Unique</h3>
       <p>Stand out from the crowd with stylish text that catches the eye. Whether you're an influencer looking to build your brand or just want to personalize your profile, our Instagram Font Generator gives you the tools to create a unique visual identity.</p>
   </div>
   
   <!-- Bootstrap JS Bundle with Popper -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
   
   <!-- Custom JavaScript -->
   <script>
       document.addEventListener('DOMContentLoaded', function() {
           // Theme toggle functionality
           const themeToggle = document.getElementById('themeToggle');
           const themeIcon = document.getElementById('themeIcon');
           
           // Check for saved theme preference or prefer-color-scheme
           const savedTheme = localStorage.getItem('theme');
           const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
           
           if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
               document.body.classList.add('dark-mode');
               updateThemeIcon(true);
           }
           
           themeToggle.addEventListener('click', function() {
               document.body.classList.toggle('dark-mode');
               const isDark = document.body.classList.contains('dark-mode');
               localStorage.setItem('theme', isDark ? 'dark' : 'light');
               updateThemeIcon(isDark);
           });
           
           function updateThemeIcon(isDark) {
               if (isDark) {
                   themeIcon.innerHTML = '<path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>';
               } else {
                   themeIcon.innerHTML = '<path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>';
               }
           }
           
           // Copy to clipboard functionality
           const copyBtn = document.getElementById('copyBtn');
           if (copyBtn) {
               copyBtn.addEventListener('click', function() {
                   const outputText = document.getElementById('outputText').innerText;
                   const tooltip = document.getElementById('copyTooltip');
                   
                   navigator.clipboard.writeText(outputText).then(function() {
                       tooltip.textContent = "Copied!";
                       setTimeout(function() {
                           tooltip.textContent = "Copy to clipboard";
                       }, 2000);
                   }, function() {
                       tooltip.textContent = "Failed to copy";
                       setTimeout(function() {
                           tooltip.textContent = "Copy to clipboard";
                       }, 2000);
                   });
               });
           }
           
           // Font style preview functionality
           const inputText = document.getElementById('inputText');
           const fontStyle = document.getElementById('fontStyle');
           const previewArea = document.getElementById('previewArea');
           const previewLoading = document.getElementById('previewLoading');
           
           // Preview text as user types
           let previewTimeout;
           inputText.addEventListener('input', debouncePreview);
           fontStyle.addEventListener('change', debouncePreview);
           
           function debouncePreview() {
               clearTimeout(previewTimeout);
               previewArea.style.display = 'none';
               previewLoading.style.display = 'flex';
               
               previewTimeout = setTimeout(updatePreview, 300);
           }
           
           function updatePreview() {
               if (inputText.value.trim() === '') {
                   previewArea.innerHTML = '<span class="text-muted">Preview will appear here...</span>';
               } else {
                   // Create a form data object
                   const formData = new FormData();
                   formData.append('inputText', inputText.value);
                   formData.append('fontStyle', fontStyle.value);
                   
                   // Use fetch to make AJAX call
                   fetch(window.location.href, {
                       method: 'POST',
                       body: formData
                   })
                   .then(response => response.text())
                   .then(html => {
                       // Create a temporary element to parse the HTML
                       const tempDiv = document.createElement('div');
                       tempDiv.innerHTML = html;
                       
                       // Find the outputText in the response
                       const outputText = tempDiv.querySelector('#outputText');
                       if (outputText) {
                           previewArea.innerHTML = outputText.innerHTML;
                       } else {
                           previewArea.innerHTML = '<span class="text-muted">Error generating preview</span>';
                       }
                   })
                   .catch(error => {
                       previewArea.innerHTML = '<span class="text-muted">Error generating preview</span>';
                       console.error('Preview error:', error);
                   })
                   .finally(() => {
                       previewLoading.style.display = 'none';
                       previewArea.style.display = 'block';
                   });
               }
           }
           
           // Initial preview load
           if (inputText.value.trim() !== '') {
               updatePreview();
           } else {
               previewLoading.style.display = 'none';
               previewArea.innerHTML = '<span class="text-muted">Preview will appear here...</span>';
               previewArea.style.display = 'block';
           }
           
           // Popular font style selection
           const fontPreviews = document.querySelectorAll('.font-preview');
           fontPreviews.forEach(preview => {
               preview.addEventListener('click', function() {
                   const styleValue = this.getAttribute('data-style');
                   fontStyle.value = styleValue;
                   updatePreview();
               });
           });
           
           // Handle form submission
           const fontForm = document.getElementById('fontForm');
           fontForm.addEventListener('submit', function(e) {
               if (inputText.value.trim() === '') {
                   e.preventDefault();
                   inputText.focus();
               }
           });
           
           // Autoresize textarea
           function autoResize(textarea) {
               textarea.style.height = 'auto';
               textarea.style.height = textarea.scrollHeight + 'px';
           }
           
           if (inputText.value) {
               autoResize(inputText);
           }
           
           inputText.addEventListener('input', function() {
               autoResize(this);
           });
       });
   </script>
</body>
</html>
             