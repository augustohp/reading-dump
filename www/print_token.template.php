<?php
$requiredVariables = ['accessToken'];
checkRequiredTemplateVariables($requiredVariables, get_defined_vars(), __FILE__);
?>
<style>
span {
    background-color: lightgray;
    padding: 5px;
    border-radius: 5px;
    color: black;
}
</style>
<h1>Pocket Access Token</h1>

<p>Your access token is <span><?=$accessToken?></span>, keep it safe.</p>
<p>To use in the command line: <span> export POCKET_APP_ACCESS_TOKEN="<?=$accessToken?>"</span></p>
