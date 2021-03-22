        <!--<div class="js-fix-footer2 bg-white border-top-2">
             <div class="container page__container page-section d-flex flex-column">
                <p class="text-70 brand mb-24pt">
                    <img class="brand-icon" src="<?=base_url('assets/img/black-70@2x.png')?>" width="30" alt="Luma"> Question & Answer
                </p>
                <p class="mb-8pt d-flex">
                    <a href="#" class="text-70 text-underline mr-8pt small">Terms</a>
                    <a href="#" class="text-70 text-underline small">Privacy policy</a>
                </p>
                <p class="text-50 small mt-n1 mb-0">Copyright 2020 © All rights reserved.</p>
            </div> 
        </div>-->
    </div>
</div>
<?php
if(isset($scripts)) {
    foreach ($scripts as $script) { ?>
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