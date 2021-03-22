    </div>
    <?=$this->ViewModel->loadSideBar('layouts/admin/sidebar', $uinfo->rank)?>
    <!-- Bootstrap -->
    <script src="<?=base_url("assets/vendors/popper.min.js")?>"></script>
    <script src="<?=base_url("assets/vendors/bootstrap.min.js")?>"></script>
    <!-- Perfect Scrollbar -->
    <script src="<?=base_url("assets/vendors/perfect-scrollbar.min.js")?>"></script>
    <!-- DOM Factory -->
    <script src="<?=base_url("assets/vendors/dom-factory.js")?>"></script>
    <!-- MDK -->
    <script src="<?=base_url("assets/vendors/material-design-kit.js")?>"></script>
    <!-- Fix Footer -->
    <script src="<?=base_url("assets/vendors/fix-footer.js")?>"></script>
    <!-- App JS -->
    <script src="<?=base_url("assets/admin/js/app.js")?>"></script>
    <!-- Touchspin -->
    <script src="<?=base_url("assets/vendors/jquery.bootstrap-touchspin.js")?>"></script>
    <script src="<?=base_url("assets/admin/js/touchspin.js")?>"></script>
    <!-- Flatpickr -->
    <script src="<?=base_url("assets/vendors/flatpickr/flatpickr.min.js")?>"></script>
    <script src="<?=base_url("assets/admin/js/flatpickr.js")?>"></script>
    <!-- DateRangePicker -->
    <script src="<?=base_url("assets/vendors/moment.min.js")?>"></script>
    <script src="<?=base_url("assets/vendors/daterangepicker.js")?>"></script>
    <script src="<?=base_url("assets/admin/js/daterangepicker.js")?>"></script>
    <!-- jQuery Mask Plugin -->
    <script src="<?=base_url("assets/vendors/jquery.mask.min.js")?>"></script>
    <script src="<?=base_url("assets/vendors/select2/select2.min.js")?>"></script>
    <script src="<?=base_url("assets/admin/js/select2.js")?>"></script>
    <script src="<?=base_url("assets/js/sweetalert2.min.js")?>"></script>
    <script src="<?=base_url("assets/js/custom.js")?>"></script>
<?php
    if(isset($scripts)) {
        foreach($scripts as $script)
        {
?>
            <script src="<?=base_url("assets/".$script)?>"></script>
<?php
        }
    }
?>
    <script>
        $('.modal').on('shown.bs.modal', function (e) {
            $('.mdk-header-layout').css('position', 'initial');
        });

        $('.modal').on('hidden.bs.modal', function (e) {
            $('.mdk-header-layout').css('position', '');
        });
    </script>
</body>
</html>