<?php
require_once 'includes/header.php';
require_once 'includes/modules.php';

function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function run_module($module_name, $input, $available_modules) {
    if (!array_key_exists($module_name, $available_modules)) {
        return ['error' => 'Module is not registered'];
    }

    $module_path = "modules/{$module_name}/process.php";
    if (!file_exists($module_path)) {
        return ['error' => 'Module process file is missing'];
    }

    require_once $module_path;
    $function_name = "run_{$module_name}";

    if (!function_exists($function_name)) {
        return ['error' => 'Module function is missing'];
    }

    return $function_name($input);
}

$available_modules = get_available_modules();
$results = [];
$selected_modules = [];
$input = '';
$messages = [];
$log_file = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = isset($_POST['search_input']) ? sanitize_input($_POST['search_input']) : '';
    $selected_modules = isset($_POST['modules']) && is_array($_POST['modules']) ? $_POST['modules'] : [];
    $selected_modules = array_values(array_intersect($selected_modules, array_keys($available_modules)));

    if (empty($input)) {
        $messages[] = ['type' => 'warning', 'text' => 'Input cannot be empty.'];
    } elseif (empty($selected_modules)) {
        $messages[] = ['type' => 'warning', 'text' => 'Select at least one module to run analysis.'];
    } else {
        foreach ($selected_modules as $module) {
            $module_result = run_module($module, $input, $available_modules);
            if ($module_result !== null) {
                $results[$module] = $module_result;
            }
        }

        $log_dir = 'output/logs';
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0775, true);
        }

        $timestamp = date('Y-m-d_H-i-s');
        $log_file = $log_dir . "/search_{$timestamp}.log";
        file_put_contents($log_file, json_encode($results, JSON_PRETTY_PRINT));

        $messages[] = ['type' => 'success', 'text' => 'Module execution completed successfully.'];
    }
}
?>

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Pegasus Doxing - OSINT Search</h3>
            </div>
            <div class="card-body">
                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-<?php echo $message['type'] === 'success' ? 'success' : 'warning'; ?>">
                        <?php echo htmlspecialchars($message['text']); ?>
                    </div>
                <?php endforeach; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="search_input" class="form-label">Enter Target Information</label>
                        <input type="text" class="form-control" id="search_input" name="search_input"
                               placeholder="Name, username, email, or phone number" value="<?php echo htmlspecialchars($input); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Modules</label>
                        <?php render_module_checkboxes($selected_modules); ?>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if (!empty($results)): ?>
        <div class="card mt-4">
            <div class="card-header">
                <h4>Search Results</h4>
            </div>
            <div class="card-body">
                <?php foreach ($results as $module => $result): ?>
                    <div class="mb-4">
                        <h5><?php echo htmlspecialchars($available_modules[$module]['label'] ?? ucfirst($module)); ?></h5>
                        <div class="result-content">
                            <?php echo '<pre>' . htmlspecialchars(print_r($result, true)) . '</pre>'; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if ($log_file !== null): ?>
                <div class="text-center mt-3">
                    <a href="<?php echo htmlspecialchars($log_file); ?>" class="btn btn-secondary" download>Download Log</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-primary">Back to Search</a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
