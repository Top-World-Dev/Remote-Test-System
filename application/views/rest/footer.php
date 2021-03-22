<?php
    if(isset($scripts)) {
        foreach ($scripts as $script) {
?>
    <script src="<?=base_url("assets/".$script)?>"></script>
<?php
        }
    }
?>

    <script>
        $('.input-form').css('min-height', (window.innerHeight * 75 / 100) + 'px');
    </script>

    </body>
</html>