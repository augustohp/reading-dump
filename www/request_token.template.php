<?php
$requiredVariables = ['requestUrl'];
checkRequiredTemplateVariables($requiredVariables, get_defined_vars(), __FILE__);
?>
<h1>Grant application access</h1>

<p>This <a href="<?=$requestUrl?>">page</a> will ask for permission to acess Pocket information belonging to you. After that you will be redirected back to this page with the password (<i>Access Token</i>) for us to use</p>
