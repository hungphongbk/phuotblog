<div class="wrap">
    <h2>My Plugin Options</h2>
    <hr>
    <form action="options.php" method="POST">
        <?php
        settings_fields(WPRandomPostController::OPTION_GROUP_ID);
        do_settings_sections(WPRandomPostController::MENU_SLUG);
        submit_button();
        ?>
    </form>
</div>