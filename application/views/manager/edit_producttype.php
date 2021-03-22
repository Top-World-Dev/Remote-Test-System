<form method="post">
                    <div class="row mb-32pt">
                        <div class="col-lg-4">
                            <div class="page-separator">
                                <div class="page-separator__text">Data Group</div>
                            </div>
                            <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                                You can edit Product Type Information.</br><a href="<?=site_url("admin/producttype")?>" style="font-weight: bold;">Show Product Type Table</a>
                            </p>
                        </div>
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="flex" style="max-width: 100%">
                                <div class="form-group">
                                    <label class="form-label">Product</label>
                                    <input type="hidden" name="id" value="<?=$record->product_id?>">
                                    <input type="text" class="form-control required" id="name" name="name" placeholder="ex: QA" value="<?=$record->product_type?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="custom-select">Validate</label>
                                    <div class="custom-controls-stacked" style="padding: 8px 4px;">
                                        <div class="custom-control custom-radio" style="display: inline-block;">
                                            <input id="radioStacked1" name="radio-stacked" type="radio" class="custom-control-input" value="1" <?=$record->validity?'checked':''?>>
                                            <label for="radioStacked1" class="custom-control-label">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio" style="display: inline-block; margin-left: 13px;">
                                            <input id="radioStacked2" name="radio-stacked" type="radio" class="custom-control-input" value="0" <?=$record->validity?'':'checked'?>>
                                            <label for="radioStacked2" class="custom-control-label">No</label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="row mb-32pt">
                            <div class="flex" style="max-width: 100%; position: absolute; right: 24px;">
                                <div class="button-list">
                                    <a>
                                        <button class="btn btn-primary update">
                                            <i class="material-icons icon--left">create</i> UPDATE
                                        </button>
                                    </a>
                                    <a href="<?=site_url("admin/producttype")?>">
                                        <button type="button" class="btn btn-accent">
                                            <i class="material-icons icon--left">keyboard_backspace</i> BACK
                                        </button>
                                    </a>
                                </div>
                            </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- // END Header Layout Content -->

        <script>
            $(document).ready(function() {
                $('.update').click(function() {
                    update(this);
                });
            });

            update = function(el) {
                var btn = $(el);
                var form = $(el).closest('form');
                form.validate({
                    errorClass: 'error text-danger',
                    submitHandler: function() {
                        addSpinnerEffect(el);
                        $.ajax({
                            type: 'POST',
                            dataType: 'text',
                            data: {
                                params: form.serializeArray(),
                            },
                            url: '<?=site_url('admin/updateproducttype')?>',
                            success: function(data)
                            {
                                removeSpinnerEffect(el);
                                swal({
                                    title: "",
                                    text: "The information have been updated successfully!"
                                }).then(function() {
                                    location.href = "<?=site_url('admin/producttype')?>";
                                });
                            }
                        });
                    }
                });
            }
        </script>