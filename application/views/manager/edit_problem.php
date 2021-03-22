        <form method="post">
            <div class="row mb-32pt">
                <div class="col-lg-4">
                    <div class="page-separator">
                        <div class="page-separator__text">Select Option</div>
                    </div>
                    <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                        You must select these options for adding problem.</br><a href="<?= site_url("admin/problem") ?>" style="font-weight: bold;">Show problem table</a>
                    </p>
                </div>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="flex" style="max-width: 100%">
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Product Type</label>
                                <input type="hidden" name="Id" value="<?= $record->Id ?>">
                                <select id="PrType" name="PrType" class="form-control required">
                                    <?php
                                    foreach ($PrTypes as $PrType) {
                                    ?>
                                        <option <?= $record->type == $PrType->product_type ? 'selected' : '' ?>><?= $PrType->product_type ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Product Unique Reference</label>
                                <select id="Ref" name="Ref" class="form-control required">
                                    <?php
                                    foreach ($Refs as $Ref) {
                                    ?>
                                        <option <?= $record->product_unique_ref == $Ref->product_unique_ref ? 'selected' : '' ?>><?= $Ref->product_unique_ref ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Special Question</label>
                                <select id="sq" name="sq" class="form-control required">
                                    <option <?= $record->sq == 'Yes' ? 'selected' : '' ?>>Yes</option>
                                    <option <?= $record->sq == 'No' ? 'selected' : '' ?>>No</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Test Mode</label>
                                <select id="mode" name="mode" class="form-control required">
                                    <option <?= $record->sub_type == 'Practicing' ? 'selected' : '' ?>>Practicing</option>
                                    <option <?= $record->sub_type == 'Examination' ? 'selected' : '' ?>>Examination</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Category</label>
                                <select id="category" name="category" class="form-control required">
                                    <option <?= $record->category == 'Standard' ? 'selected' : '' ?>>Standard</option>
                                    <option <?= $record->category == 'Advance' ? 'selected' : '' ?>>Advance</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Subject</label>
                                <select id="subject" name="subject" class="form-control required">
                                    <?php
                                    foreach ($subjects as $subject) {
                                    ?>
                                        <option <?= $record->subject == $subject->subject ? 'selected' : '' ?>><?= $subject->subject ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Module</label>
                                <select id="module" name="module" class="form-control required">
                                    <?php
                                    foreach ($modules as $module) {
                                    ?>
                                        <option <?= $record->module == $module->module ? 'selected' : '' ?>><?= $module->module ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Correct Answer</label>
                                <select id="correct" name="correct" class="form-control required">
                                    <?php
                                    $answers = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                                    foreach ($answers as $answer) { ?>
                                        <option <?= $answer == $record->correct ? 'selected' : '' ?>><?= $answer ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Question Number</label>
                                <input type="text" class="form-control required" name="qs_num" id="qs_num" value="<?= $record->question_number ?>">
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="row mb-32pt">
                <div class="col-lg-4">
                    <div class="page-separator">
                        <div class="page-separator__text">Edit Question</div>
                    </div>
                    <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                        You can use this field to add Question.</br><a href="<?= site_url("admin/problem") ?>" style="font-weight: bold;">Show problem table</a>
                    </p>
                </div>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="flex" style="max-width: 100%">
                        <label class="form-label">Question</label>
                        <div style="height: 150px;" id="question" data-toggle="quill" data-quill-placeholder="Please edit problem here" data-quill-modules-toolbar='[
                            [{"font": []}, {"size": []}],
                            [{"header": "1"}, {"header": "2"}],
                            ["bold", "italic", "underline", "strike"], 
                            [{"color": []}, {"background": []}],
                            ["direction", {"align": []}],
                            [{"list": "ordered"}, {"list": "bullet"}, {"indent": "-1"}, {"indent": "+1"}], 
                            ["link", "blockquote", "code"],
                            [{"script": "super"}, {"script": "sub"}],
                            ["image", "video", "formula"]]'><?= $record->question ?></div>
                        <textarea class="form-control required" id="hquestion" name="question" style="display:none;"><?= $record->question ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-32pt">
                <div class="col-lg-4">
                    <div class="page-separator">
                        <div class="page-separator__text">Edit Solution</div>
                    </div>
                    <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                        You can use this field to add Solution.</br><a href="<?= site_url("admin/problem") ?>" style="font-weight: bold;">Show problem table</a>
                    </p>
                </div>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="flex" style="max-width: 100%">
                        <label class="form-label">Solution</label>
                        <div style="height: 150px;" id="explanation" data-toggle="quill" data-quill-placeholder="Please edit solution here" data-quill-modules-toolbar='[
                            [{"font": []}, {"size": []}],
                            [{"header": "1"}, {"header": "2"}],
                            ["bold", "italic", "underline", "strike"], 
                            [{"color": []}, {"background": []}],
                            ["direction", {"align": []}],
                            [{"list": "ordered"}, {"list": "bullet"}, {"indent": "-1"}, {"indent": "+1"}], 
                            ["link", "blockquote", "code"],
                            [{"script": "super"}, {"script": "sub"}],
                            ["image", "video", "formula"]]'><?= $record->explanation ?></div>
                        <textarea class="form-control required" id="hexplanation" name="explanation" style="display:none;"><?= $record->explanation ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-32pt">
                <div class="col-lg-4">
                    <div class="page-separator">
                        <div class="page-separator__text">Answer Group</div>
                    </div>
                    <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                        You can use these fields to edit answers.</br><a href="<?= site_url("admin/problem") ?>" style="font-weight: bold;">Show problem table</a>
                    </p>
                </div>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="flex" style="max-width: 100%">
                        <?php
                        foreach ($answers as $answer) { ?>
                            <div class="form-group">
                                <label class="form-label">Answer <?= $answer ?></label>
                                <div style="height: 150px;" id="<?= $answer ?>" data-toggle="quill" data-quill-placeholder="Please edit Answer <?= $answer ?>" data-quill-modules-toolbar='[
                                    [{"font": []}, {"size": []}],
                                    [{"header": "1"}, {"header": "2"}],
                                    ["bold", "italic", "underline", "strike"], 
                                    [{"color": []}, {"background": []}],
                                    ["direction", {"align": []}],
                                    [{"list": "ordered"}, {"list": "bullet"}, {"indent": "-1"}, {"indent": "+1"}], 
                                    ["link", "blockquote", "code"],
                                    [{"script": "super"}, {"script": "sub"}],
                                    ["image", "video", "formula"]]'>
                                    <?= $record->{$answer} ?>
                                </div>
                                <textarea class="form-control required" id="h<?= $answer ?>" name="<?= $answer ?>" style="display:none;"><?= $record->{$answer} ?></textarea>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row mb-32pt">
                <div class="flex" style="max-width: 100%; position: absolute; right: 24px;">
                    <div class="button-list">
                        <a><button class="btn btn-primary update"><i class="material-icons icon--left">create</i> UPDATE</button></a>
                        <a href="<?= site_url("admin/problem") ?>"><button type="button" class="btn btn-accent"><i class="material-icons icon--left">keyboard_backspace</i> BACK</button></a>
                    </div>
                </div>
            </div>
        </form>
        </div>
        </div>
        <script>
            var editors = {};
            $(document).ready(function() {
                var enableMathQuillFormulaAuthoring = mathquill4quill();
                $('.update').click(function() {
                    update(this);
                });

                $('div[data-toggle="quill"]').each(function() {
                    editors[this.id] = new Quill(this, {
                        modules: {
                            formula: true,
                            toolbar: $(this).data('quill-modules-toolbar')
                        },
                        placeholder: $(this).data('quill-placeholder'),
                        theme: 'snow'
                    });
                    $(this).attr('data-quill-modules-toolbar', '');

                    enableMathQuillFormulaAuthoring(editors[this.id], {
                        operators: [
                            ["\\sqrt[n]{x}", "\\nthroot"],
                            ["\\frac{x}{y}", "\\frac"]
                        ]
                    });

                    editors[this.id].on('text-change', (delta, oldContents, source) => {
                        if (source !== 'user') return;
                        $("#h" + this.id).val($("#" + this.id + " .ql-editor")[0].outerHTML.replace('contenteditable="true"', ''));
                    });
                });
            });

            update = function(el) {
                var btn = $(el);
                var form = $(el).closest('form');
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
                            url: '<?= site_url('admin/updateproblem') ?>',
                            success: function(data) {
                                swal({
                                    title: "",
                                    text: "The problem information have been updated successfully."
                                }).then(function() {
                                    location.href = "<?= site_url('admin/problem') ?>";
                                });
                                btn.attr('disabled', false);
                            }
                        });
                    }
                });
            }
        </script>