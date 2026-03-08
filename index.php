<?php
require_once 'includes/header.php';
require_once 'includes/modules.php';
?>

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Pegasus Doxing - OSINT Search</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="search.php">
                    <div class="mb-3">
                        <label for="search_input" class="form-label">Enter Target Information</label>
                        <input type="text" class="form-control" id="search_input" name="search_input"
                               placeholder="Name, username, email, or phone number" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Modules</label>
                        <?php render_module_checkboxes(); ?>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
