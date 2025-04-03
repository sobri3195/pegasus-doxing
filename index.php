<?php
require_once 'includes/header.php';
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
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
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 