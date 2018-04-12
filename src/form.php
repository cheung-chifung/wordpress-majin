<div class="wrap">
    <form method="post" action="options.php">
    <?php
        // This prints out all hidden setting fields
        settings_fields($this->plugin->name);
        do_settings_sections('majin-settings');
        submit_button();
    ?>
    </form>
</div>
