<!-- a simple view, outputing all the comments -->
<?php include "view/header.php"?>
<br>
<div class="container" style="background-color: lightblue; padding-bottom: 2%; padding-top: 2%;">
    <div class="row">
        <div class="col">
            <div class="input-group mb-3">
                <h6>Tracking Number</h6>
            </div>
            <div class="input-group mb-3">
                <input name="tracking_number" id="tracking_number" type="text" class="form-control" aria-describedby="basic-addon1" required>
            </div>
            <button class="btn btn-outline-primary" type="button" id="cerca" name="cerca">Cerca</button>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <pre id="json"></pre>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        Tracking.getInstance();
    });
</script>
<?php include "view/footer.php"?>

