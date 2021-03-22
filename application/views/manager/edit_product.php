<form method="post">
                    <div class="row mb-32pt">
                        <div class="col-lg-4">
                            <div class="page-separator">
                                <div class="page-separator__text">Select Option</div>
                            </div>
                            <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                                You must select options for add product.</br><a href="<?=site_url("admin/product")?>" style="font-weight: bold;">Show product table</a>
                            </p>
                        </div>
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="flex" style="max-width: 100%">
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Product</label>
                                        <input type="hidden" name="id" value="<?=$record->Id?>">
                                        <select class="form-control required" id="product" name="product">
                                <?php
                                        foreach($products as $product)
                                        {
                                ?>
                                            <option data-id="<?=$product->product_id?>"  <?=$record->product == $product->product_type?'selected':''?>><?=$product->product_type?></option>
                                <?php
                                        }
                                ?>
                                        </select>
                                        <input type="hidden" id="productId" name="productId">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Subject</label>
                                        <select class="form-control required" id="sub" name="sub">
                                <?php
                                        foreach($subjects as $subject)
                                        {            
                                ?>
                                            <option data-id="<?=$subject->subject_id?>" <?=$record->subject == $subject->subject?'selected':''?> ><?=$subject->subject?></option>
                                <?php
                                        }
                                ?>
                                        </select>
                                        <input type="hidden" id="subId" name="subId">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Subject Type</label>
                                        <select class="form-control required" id="subTy" name="subTy">
                                <?php
                                        foreach($subjecttypes as $subjecttype)
                                        {            
                                ?>
                                            <option data-id="<?=$subjecttype->type_id?>" <?=$record->subject_type == $subjecttype->subject_type?'selected':''?>><?=$subjecttype->subject_type?></option>
                                <?php
                                        }
                                ?>
                                        </select>
                                        <input type="hidden" id="subTyId" name="subTyId">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Module</label>
                                        <select class="form-control required" id="module" name="module">
                                <?php
                                        foreach($modules as $module)
                                        {            
                                ?>
                                            <option data-id="<?=$module->module_id?>" <?=$record->module == $module->module?'selected':''?>><?=$module->module?></option>
                                <?php
                                        }
                                ?>
                                        </select>
                                        <input type="hidden" id="moduleId" name="moduleId">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Price(USD)</label>
                                        <select class="form-control required" id="price" name="price">
                                <?php
                                        foreach($prices as $price)
                                        {            
                                ?>
                                            <option <?=$record->price_usd == $price->price_usd?'selected':''?>><?=$price->price_usd?></option>
                                <?php
                                        }
                                ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Price(USD) ID</label>
                                        <select class="form-control required" id="priceid" name="priceid">
                                <?php
                                        foreach($prices as $price)
                                        {            
                                ?>
                                            <option <?=$record->price_id == $price->price_id?'selected':''?>><?=$price->price_id?></option>
                                <?php
                                        }
                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Test Duration</label>
                                        <select class="form-control required" id="TimeAllow" name="TimeAllow">
                                <?php
                                        foreach($timeAllows as $timeAllow)
                                        {            
                                ?>
                                            <option <?=$record->test_duration == $timeAllow->test_duration.' '.$timeAllow->unit?'selected':''?>><?=$timeAllow->test_duration?> <?=$timeAllow->unit?></option>
                                <?php
                                        }
                                ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Question Number</label>
                                        <input type="text" class="form-control required" id="qs_number" name="qs_number" placeholder="ex: Unlimited or 1000" value="<?=$record->number_of_question?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-32pt">
                        <div class="col-lg-4">
                            <div class="page-separator">
                                <div class="page-separator__text">Date Group</div>
                            </div>
                            <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                                You can set date and time to add Product.</br><a href="<?=site_url("admin/product")?>" style="font-weight: bold;">Show product table</a>
                            </p>
                        </div>
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="flex" style="max-width: 100%">
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="text-label" for="dateRangePickerSample01">Test Date</label>
                                        <input id="Date" name="Date" type="text" class="form-control required" placeholder="Date example" data-toggle="daterangepicker" data-daterangepicker-drops="up" data-daterangepicker-start-date="2020/8/02" data-daterangepicker-single-date-picker="true">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="flatpickrSample05">Test Time</label>
                                        <input id="Time" name="Time" type="text" class="form-control required" placeholder="Flatpickr time example" data-toggle="flatpickr" data-flatpickr-enable-time="true" data-flatpickr-no-calendar="true" data-flatpickr-alt-format="H:i" data-flatpickr-date-format="H:i" value="15:35">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-32pt">
                        <div class="col-lg-4">
                            <div class="page-separator">
                                <div class="page-separator__text">Data Group</div>
                            </div>
                            <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                                You can edit product unique reference to add Product.</br><a href="<?=site_url("admin/product")?>" style="font-weight: bold;">Show product table</a>
                            </p>
                        </div>
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="flex" style="max-width: 100%">
                                <div class="form-group">
                                    <label class="form-label">Product Unique Reference</label>
                                    <input type="text" class="form-control required" id="ref" name="ref" value="<?=$record->product_unique_ref?>">
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
                                <a href="<?=site_url("admin/product")?>">
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

                $('#product').change(function() {
                    $('#productId').val($('#product option:selected').data('id'))
                })

                $('#sub').change(function() {
                    $('#subId').val($('#sub option:selected').data('id'));
                });

                $('#subTy').change(function() {
                    $('#subTyId').val($('#subTy option:selected').data('id'));
                });

                $('#module').change(function() {
                    $('#moduleId').val($('#module option:selected').data('id'));
                });

                $('#productId').val($('#product option:selected').data('id'))
                $('#subId').val($('#sub option:selected').data('id'))
                $('#subTyId').val($('#subTy option:selected').data('id'));
                $('#moduleId').val($('#module option:selected').data('id'));
            });

            update = function(el) {
                var btn = $(el);
                var form = $(el).closest('form');
                console.log(form.serializeArray());
                form.validate({
                    errorClass: 'error text-danger',
                    submitHandler: function() {
                        btn.attr('disabled', true);
                        $.ajax({
                            type: 'POST',
                            dataType: 'text',
                            data: {
                                params: form.serializeArray(),
                            },
                            url: '<?=site_url('admin/updateproduct')?>',
                            success: function(data)
                            {
                                swal({
                                    title: "",
                                    text: "The information have been updated successfully!"
                                }).then(function() {
                                    location.href = "<?=site_url('admin/product')?>";
                                });
                                btn.attr('disabled', false);
                            }
                        });
                    }
                });
            }
        </script>