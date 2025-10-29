<?php
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate Robots.txt
    if (isset($_POST['generate_robots'])) {
        $userAgent = isset($_POST['user_agent']) ? "User-agent: " . htmlspecialchars($_POST['user_agent']) . "\n" : "";
        $disallow = isset($_POST['disallow']) ? "Disallow: " . htmlspecialchars($_POST['disallow']) . "\n" : "";
        $allow = isset($_POST['allow']) ? "Allow: " . htmlspecialchars($_POST['allow']) . "\n" : "";
        $crawlDelay = isset($_POST['crawl_delay']) ? "Crawl-delay: " . htmlspecialchars($_POST['crawl_delay']) . "\n" : "";
        $sitemap = isset($_POST['sitemap_url']) ? "Sitemap: " . htmlspecialchars($_POST['sitemap_url']) . "\n" : "";
        $comments = isset($_POST['comments']) ? "# " . htmlspecialchars($_POST['comments']) . "\n" : "";
        
        $robotsContent = $comments . $userAgent . $allow . $disallow . $crawlDelay . $sitemap;
        
        // Force download
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="robots.txt"');
        echo $robotsContent;
        exit;
    }

    // Generate Sitemap
    if (isset($_POST['generate_sitemap'])) {
        $urls = isset($_POST['url']) ? $_POST['url'] : [];
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        foreach ($urls as $index => $url) {
            if (!empty($url['loc'])) {
                $xml .= "  <url>\n";
                $xml .= "    <loc>" . htmlspecialchars($url['loc']) . "</loc>\n";
                $xml .= "    <lastmod>" . (empty($url['lastmod']) ? date('Y-m-d') : htmlspecialchars($url['lastmod'])) . "</lastmod>\n";
                $xml .= "    <changefreq>" . (empty($url['changefreq']) ? 'monthly' : htmlspecialchars($url['changefreq'])) . "</changefreq>\n";
                $xml .= "    <priority>" . (empty($url['priority']) ? '0.5' : htmlspecialchars($url['priority'])) . "</priority>\n";
                $xml .= "  </url>\n";
            }
        }
        
        $xml .= "</urlset>";
        
        // Force download
        header('Content-Type: application/xml');
        header('Content-Disposition: attachment; filename="sitemap.xml"');
        echo $xml;
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infinitytoolspace - Robots.txt & Sitemap Generator</title>
    <meta name="description" content="Generate custom Robots.txt files and XML sitemaps for better search engine optimization. Improve your website's crawling and indexing with our free SEO tools.">
    <meta name="keywords" content="robots.txt generator, xml sitemap generator, seo tools, search engine optimization, website crawling">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(120deg, #6a11cb 0%, #2575fc 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
        .preview-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <!--<nav class="navbar navbar-expand-lg navbar-dark gradient-bg">-->
    <!--    <div class="container">-->
    <!--        <a class="navbar-brand" href="#">SEO Tools</a>-->
    <!--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">-->
    <!--            <span class="navbar-toggler-icon"></span>-->
    <!--        </button>-->
    <!--        <div class="collapse navbar-collapse" id="navbarNav">-->
    <!--            <ul class="navbar-nav">-->
    <!--                <li class="nav-item">-->
    <!--                    <a class="nav-link active" href="#robots-generator">Robots.txt</a>-->
    <!--                </li>-->
    <!--                <li class="nav-item">-->
    <!--                    <a class="nav-link" href="#sitemap-generator">Sitemap</a>-->
    <!--                </li>-->
    <!--            </ul>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</nav>-->

    <div class="container py-5">
        <!-- Robots.txt Generator -->
        <div class="card mb-4 card-hover" id="robots-generator">
            <div class="card-header gradient-bg text-white">
                <h3 class="mb-0">Robots.txt Generator</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">User-agent</label>
                            <input type="text" class="form-control" name="user_agent" placeholder="*" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Allow</label>
                            <input type="text" class="form-control" name="allow" placeholder="/">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Disallow</label>
                            <input type="text" class="form-control" name="disallow" placeholder="/private/">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Crawl-delay</label>
                            <input type="number" class="form-control" name="crawl_delay" placeholder="10">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Sitemap URL</label>
                            <input type="url" class="form-control" name="sitemap_url" placeholder="https://example.com/sitemap.xml">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Comments</label>
                            <textarea class="form-control" name="comments" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" name="generate_robots" class="btn btn-primary">Generate Robots.txt</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sitemap Generator -->
        <div class="card mb-4 card-hover" id="sitemap-generator">
            <div class="card-header gradient-bg text-white">
                <h3 class="mb-0">XML Sitemap Generator</h3>
            </div>
            <div class="card-body">
                <form method="POST" id="sitemapForm">
                    <div id="urlFields">
                        <div class="row g-3 mb-3 url-row">
                            <div class="col-md-4">
                                <input type="url" class="form-control" name="url[0][loc]" placeholder="URL" required>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="url[0][lastmod]" value="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="url[0][changefreq]">
                                    <option value="always">Always</option>
                                    <option value="hourly">Hourly</option>
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly" selected>Monthly</option>
                                    <option value="yearly">Yearly</option>
                                    <option value="never">Never</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" step="0.1" min="0" max="1" class="form-control" name="url[0][priority]" placeholder="0.5" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-url" disabled><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-success" id="addUrl"><i class="bi bi-plus"></i> Add URL</button>
                        <button type="submit" name="generate_sitemap" class="btn btn-primary">Generate Sitemap</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- SEO Content -->
        <div class="mt-5">
            <h2 class="mb-4">Optimize Your Website's Search Engine Visibility</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <h4>Why Use a Robots.txt File?</h4>
                    <p>Properly configuring your robots.txt file helps search engines understand which parts of your website should be crawled and indexed. Our generator helps you create search-engine-friendly directives to:</p>
                    <ul>
                        <li>Prevent duplicate content issues</li>
                        <li>Block sensitive areas of your site</li>
                        <li>Manage crawl budget efficiently</li>
                        <li>Specify sitemap locations</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4>Benefits of XML Sitemaps</h4>
                    <p>An XML sitemap improves your website's SEO by helping search engines discover and understand your content structure. Key advantages include:</p>
                    <ul>
                        <li>Faster indexing of new pages</li>
                        <li>Better understanding of page relationships</li>
                        <li>Priority signaling for important pages</li>
                        <li>Tracking content updates efficiently</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <!--<footer class="gradient-bg text-white py-4">-->
    <!--    <div class="container">-->
    <!--        <div class="row">-->
    <!--            <div class="col-md-6">-->
    <!--                <h5>About SEO Tools</h5>-->
    <!--                <p>Professional-grade search engine optimization tools for webmasters and digital marketers. Improve your website's crawling efficiency and search engine rankings with our free generators.</p>-->
    <!--            </div>-->
    <!--            <div class="col-md-3">-->
    <!--                <h5>Quick Links</h5>-->
    <!--                <ul class="list-unstyled">-->
    <!--                    <li><a href="#robots-generator" class="text-white text-decoration-none">Robots.txt Generator</a></li>-->
    <!--                    <li><a href="#sitemap-generator" class="text-white text-decoration-none">Sitemap Generator</a></li>-->
    <!--                </ul>-->
    <!--            </div>-->
    <!--            <div class="col-md-3">-->
    <!--                <h5>SEO Resources</h5>-->
    <!--                <ul class="list-unstyled">-->
    <!--                    <li><a href="https://developers.google.com/search/docs" class="text-white text-decoration-none" target="_blank">Google SEO Docs</a></li>-->
    <!--                    <li><a href="https://www.bing.com/webmasters" class="text-white text-decoration-none" target="_blank">Bing Webmaster Tools</a></li>-->
    <!--                </ul>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--        <div class="text-center mt-3">-->
    <!--            <p>&copy; 2023 SEO Tools. All rights reserved.</p>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</footer>-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dynamic URL fields for sitemap
        let urlIndex = 1;
        document.getElementById('addUrl').addEventListener('click', () => {
            const clone = document.querySelector('.url-row').cloneNode(true);
            clone.querySelectorAll('input, select').forEach(el => {
                el.name = el.name.replace('[0]', `[${urlIndex}]`);
                el.value = el.type === 'date' ? new Date().toISOString().split('T')[0] : 
                          el.type === 'number' ? '0.5' : '';
            });
            clone.querySelector('.remove-url').disabled = false;
            clone.querySelector('.remove-url').addEventListener('click', () => clone.remove());
            document.getElementById('urlFields').appendChild(clone);
            urlIndex++;
        });

        // Enable remove buttons
        document.querySelectorAll('.remove-url').forEach(btn => {
            btn.addEventListener('click', () => btn.closest('.url-row').remove());
        });
    </script>
</body>
</html>