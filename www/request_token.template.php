<?php
$requiredVariables = ['requestUrl'];
checkRequiredTemplateVariables($requiredVariables, get_defined_vars(), __FILE__);
?>
<div class="card">
    <div class="card-content">
        <h1>Reading dump</h1>
        <p>
            So, you've added plenty of articles on
            Pocket and are not reading them? We can
            help you.
        </p>
        <p>
            We tag articles that take less than 5
            minutes to read.
        </p>
    </div>
    <div class="card-action">
        <a class="waves-effect waves-light btn" href="<?=$requestUrl?>">
            Connect to Pocket
        </a>
    </div>
</div>
<div class="card">
    <div class="card-content">
        <h1>Reading dump</h1>
        <p>
            So, you've added plenty of articles on
            Pocket and are not reading them? We can
            help you.
        </p>
        <p>
            We tag articles that take less than 5
            minutes to read.
        </p>
    </div>
    <div class="card-action">
        <a class="waves-effect waves-light btn" href="<?=$requestUrl?>">
            Connect to Pocket
        </a>
    </div>
</div>
