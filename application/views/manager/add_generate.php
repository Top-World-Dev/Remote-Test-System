                <form method="post">
                    <div class="row mb-32pt">
                        <div class="col-lg-4">
                            <div class="page-separator">
                                <div class="page-separator__text">Select Option</div>
                            </div>
                            <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                                You must select options to generate a new set.
                            </p>
                        </div>
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="flex" style="max-width: 100%">
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">SET ID</label>
                                        <input type="text" class="form-control required" id="SETID" name="SETID" placeholder="ex: 200">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Product ID</label>
                                        <select class="form-control required" id="PrID" name="PrID">
                                <?php
                                        foreach($products as $product)
                                        {
                                ?>
                                            <option><?=$product->product_id?></option>
                                <?php
                                        }
                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Subject ID</label>
                                        <select class="form-control required" id="SubID" name="SubID">
                                <?php
                                        foreach($subjects as $subject)
                                        {            
                                ?>
                                            <option><?=$subject->subject_id?></option>
                                <?php
                                        }
                                ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Module ID</label>
                                        <select class="form-control required" id="ModulID" name="ModulID">
                                <?php
                                        foreach($modules as $module)
                                        {            
                                ?>
                                            <option><?=$module->module_id?></option>
                                <?php
                                        }
                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Subject Type ID</label>
                                        <select class="form-control required" id="SubTyID" name="SubTyID">
                                <?php
                                        foreach($subjecttypes as $subjecttype)
                                        {            
                                ?>
                                            <option><?=$subjecttype->type_id?></option>
                                <?php
                                        }
                                ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="custom-select">Time Allowed</label>
                                        <select class="form-control required" id="TimeAllow" name="TimeAllow">
                                <?php
                                        foreach($timeAllows as $timeAllow)
                                        {            
                                ?>
                                            <option><?=$timeAllow->test_duration?> <?=$timeAllow->unit?></option>
                                <?php
                                        }
                                ?>
                                        </select>
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
                                When "PROCESS" is clicked, Question numbers are assigned in "Assigned Questions" field to the SET.
                            </p>
                        </div>
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="flex" style="max-width: 100%">
                                <div class="form-group">
                                    <label class="form-label">Assigned Questions</label>
                                    <input type="text" class="form-control" id="questions" name="questions" placeholder="">
                                </div> 
                                <!--<div class="form-group">
                                    <label class="form-label" for="custom-select">Validate</label>
                                    <div class="custom-controls-stacked" style="padding: 8px 4px;">
                                        <div class="custom-control custom-radio" style="display: inline-block;">
                                            <input id="radioStacked1" name="radio-stacked" type="radio" class="custom-control-input" value="1" checked>
                                            <label for="radioStacked1" class="custom-control-label">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio" style="display: inline-block; margin-left: 13px;">
                                            <input id="radioStacked2" name="radio-stacked" type="radio" class="custom-control-input" value="0">
                                            <label for="radioStacked2" class="custom-control-label">No</label>
                                        </div>
                                    </div>
                                </div>-->    
                            </div>
                        </div>
                    </div>
                    <div class="row mb-32pt">
                        <div class="flex" style="max-width: 100%; position: absolute; right: 24px;">
                            <div class="button-list">
                                <a>
                                    <button class="btn btn-primary generate">
                                        <i class="material-icons icon--left">create</i> Proccess
                                    </button>
                                </a>
                                <a href="<?=site_url("admin/generate")?>">
                                    <button type="button" class="btn btn-accent">
                                        <i class="material-icons icon--left">keyboard_backspace</i> CANCEL
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
                $('.generate').click(function() {
                    Generate(this);
                });
            });

            Generate = function(el) {
                var btn = $(el);
                var form = $(el).closest('form');
                form.validate({
                    errorClass: 'error text-danger',
                    submitHandler: function() {
                        addSpinnerEffect(el); 
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                params: form.serializeArray(),
                            },
                            url: '<?=site_url('admin/saveGenerate')?>',
                            success: function(data)
                            {
                                removeSpinnerEffect(el);
                                if (data.expired) { 
                                    swal({
                                        title: "WARNING",
                                        text: "Your session has timed out. Please sign in again.",
                                    }).then(function () {
                                        location.href = data.url;
                                    });
                                } else {
                                    if (data.status) {
                                        swal({
                                            title: "SUCCESS",
                                            text: data.message
                                        }).then(function() {
                                            location.href = "<?=site_url('admin/generate')?>";
                                        });
                                        $('#questions').val(data.data);
                                    } else {
                                        swal({
                                            title: "WARNING",
                                            text: data.message,
                                        });
                                    }
                                }
                            }
                        });
                    }
                });
            }
        </script>