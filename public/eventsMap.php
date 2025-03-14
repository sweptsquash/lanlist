<?php

define('MAIN_NOPADDING', true);
require_once 'includes/widgets/header.php';

use libAllure\Session;
?>
<h2>LAN Parties On A Map...</h2>
<div>
    <div class = "content">
        <div id = "map" style = "width: 100%; height: 600px;border: 1px solid LightGray;" >
            <noscript>
                <p>There should be a map here, but you dont have javascript...</p>
            </noscript>
        </div>

        <div style = "padding: 1em;">
            <p>
                <?php
                if (Session::isLoggedIn()) {
                    echo 'Go to your <a href = "account.php">account</a> to add events. ';
                } else {
                    echo 'You can get the list in <a href = "eventsList.php">many different formats</a>, or you can add your own events if you <a href = "login.php">login</a>. ';
                }
                ?>
                For feature requests, bugs and whatnot, get in <a href = "contact.php">contact</a>.
            </p>
        </div>
    </div>
</div>

<?php startSidebar(); ?>

<script type = "text/javascript">
renderMap("<?php echo getGeoIpCountry(); ?>");

window.addEventListener('DOMContentLoaded', () => {
<?php echo jsForEvents(); ?>
});

</script>

<template id = "tplEventPopup">
    <div class = "infoPopup">';
    <h2><a href = "viewEvent.php?id=">?</a></h2>';
    <strong>Start:</strong><span id = "eventPopupStart"></span><br />
    <strong>Finish:</strong><span id = "eventPopupFinish"></span><br /><br />
    <strong>Seats:</strong><span id = "eventPopupSeats"></span><br />
    <a href = "viewEvent.php?id=' + eventObject.id + '">more details...</a>';
    </div>
</template>

    <?php

    require_once 'includes/widgets/infoboxNextEvent.php';

    $tpl->display('infobox.addEvents.tpl');

    require_once 'includes/widgets/footer.php';

    ?>
