<?php
require_once 'includes/header.php';

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Function to run a module
function run_module($module_name, $input) {
    $module_path = "modules/{$module_name}/process.php";
    if (file_exists($module_path)) {
        require_once $module_path;
        $function_name = "run_{$module_name}";
        if (function_exists($function_name)) {
            return $function_name($input);
        }
    }
    return null;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = sanitize_input($_POST['search_input']);
    $selected_modules = isset($_POST['modules']) ? $_POST['modules'] : [];
    
    if (!empty($input)) {
        $results = [];
        $timestamp = date('Y-m-d_H-i-s');
        $log_file = "output/logs/search_{$timestamp}.log";
        
        foreach ($selected_modules as $module) {
            $module_result = run_module($module, $input);
            if ($module_result) {
                $results[$module] = $module_result;
            }
        }
        
        // Save results to log file
        file_put_contents($log_file, json_encode($results, JSON_PRETTY_PRINT));
    }
}
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Pegasus Doxing - OSINT Search</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="search_input" class="form-label">Enter Target Information</label>
                        <input type="text" class="form-control" id="search_input" name="search_input" 
                               placeholder="Name, username, email, or phone number" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Select Modules</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="doxid" id="doxid">
                                    <label class="form-check-label" for="doxid">Doxid</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="webbio" id="webbio">
                                    <label class="form-check-label" for="webbio">Webbio</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="usernamedna" id="usernamedna">
                                    <label class="form-check-label" for="usernamedna">UsernameDNA</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="geopost" id="geopost">
                                    <label class="form-check-label" for="geopost">Geopost</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="whatsapp_check" id="whatsapp_check">
                                    <label class="form-check-label" for="whatsapp_check">WhatsApp Check</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="timepattern" id="timepattern">
                                    <label class="form-check-label" for="timepattern">TimePattern</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="emailcross" id="emailcross">
                                    <label class="form-check-label" for="emailcross">EmailCross</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="exifscan" id="exifscan">
                                    <label class="form-check-label" for="exifscan">ExifScan</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="socialsigs" id="socialsigs">
                                    <label class="form-check-label" for="socialsigs">SocialSigs</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="redirectchain" id="redirectchain">
                                    <label class="form-check-label" for="redirectchain">RedirectChain</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php if (isset($results) && !empty($results)): ?>
        <div class="card mt-4">
            <div class="card-header">
                <h4>Search Results</h4>
            </div>
            <div class="card-body">
                <?php foreach ($results as $module => $result): ?>
                    <div class="mb-4">
                        <h5><?php echo ucfirst($module); ?></h5>
                        <div class="result-content">
                            <?php 
                            if (is_array($result)) {
                                echo '<pre>' . print_r($result, true) . '</pre>';
                            } else {
                                echo $result;
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="text-center mt-3">
                    <a href="<?php echo $log_file; ?>" class="btn btn-secondary" download>Download Log</a>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            No results found. Please try a different search or select different modules.
        </div>
        <?php endif; ?>
        
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-primary">Back to Search</a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 