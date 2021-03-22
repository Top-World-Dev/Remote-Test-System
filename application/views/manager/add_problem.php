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
                                <select id="PrType" name="PrType" class="form-control required">
                                    <?php
                                    foreach ($PrTypes as $PrType) {
                                    ?>
                                        <option><?= $PrType->product_type ?></option>
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
                                        <option><?= $Ref->product_unique_ref ?></option>
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
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Test Mode</label>
                                <select id="mode" name="mode" class="form-control required">
                                    <option>Practicing</option>
                                    <option>Examination</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Category</label>
                                <select id="category" name="category" class="form-control required">
                                    <option>Standard</option>
                                    <option>Advance</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Subject</label>
                                <select id="subject" name="subject" class="form-control required">
                                    <?php
                                    foreach ($subjects as $subject) {
                                    ?>
                                        <option><?= $subject->subject ?></option>
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
                                        <option><?= $module->module ?></option>
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
                                        <option><?= $answer ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="custom-select">Question Number</label>
                                <input type="text" class="form-control required" name="qs_num" id="qs_num">
                            </div>
                        </div>
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
                        <div style="height: 150px;" id="question" data-toggle="quill" data-quill-placeholder="Please enter problem" data-quill-modules-toolbar='[
                            [{"font": []}, {"size": []}],
                            [{"header": "1"}, {"header": "2"}],
                            ["bold", "italic", "underline", "strike"], 
                            [{"color": []}, {"background": []}],
                            ["direction", {"align": []}],
                            [{"list": "ordered"}, {"list": "bullet"}, {"indent": "-1"}, {"indent": "+1"}], 
                            ["link", "blockquote", "code"],
                            [{"script": "super"}, {"script": "sub"}],
                            ["image", "video", "formula"]]'></div>
                        <textarea class="form-control required" id="hquestion" name="question" style="display:none;"></textarea>
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
                        <div style="height: 150px;" id="explanation" data-toggle="quill" data-quill-placeholder="Please enter solution" data-quill-modules-toolbar='[
                            [{"font": []}, {"size": []}],
                            [{"header": "1"}, {"header": "2"}],
                            ["bold", "italic", "underline", "strike"], 
                            [{"color": []}, {"background": []}],
                            ["direction", {"align": []}],
                            [{"list": "ordered"}, {"list": "bullet"}, {"indent": "-1"}, {"indent": "+1"}], 
                            ["link", "blockquote", "code"],
                            [{"script": "super"}, {"script": "sub"}],
                            ["image", "video", "formula"]]'></div>
                        <textarea class="form-control required" id="hexplanation" name="explanation" style="display:none;"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-32pt">
                <div class="col-lg-4">
                    <div class="page-separator">
                        <div class="page-separator__text">Answer Group</div>
                    </div>
                    <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                        You can use these fields to add answers.</br><a href="<?= site_url("admin/problem") ?>" style="font-weight: bold;">Show problem table</a>
                    </p>
                </div>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="flex" style="max-width: 100%">
                        <?php
                        foreach ($answers as $answer) { ?>
                            <div class="form-group">
                                <label class="form-label">Answer <?= $answer ?></label>
                                <div style="height: 150px;" id="<?= $answer ?>" data-toggle="quill" data-quill-placeholder="Please enter Answer <?= $answer ?>" data-quill-modules-toolbar='[
                                    [{"font": []}, {"size": []}],
                                    [{"header": "1"}, {"header": "2"}],
                                    ["bold", "italic", "underline", "strike"], 
                                    [{"color": []}, {"background": []}],
                                    ["direction", {"align": []}],
                                    [{"list": "ordered"}, {"list": "bullet"}, {"indent": "-1"}, {"indent": "+1"}], 
                                    ["link", "blockquote", "code"],
                                    [{"script": "super"}, {"script": "sub"}],
                                    ["image", "video", "formula"]]'></div>
                                <textarea class="form-control required" id="h<?= $answer ?>" name="<?= $answer ?>" style="display:none;"></textarea>
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
                        <a><button class="btn btn-primary create"><i class="material-icons icon--left">create</i> CREATE</button></a>
                        <a href="<?= site_url("admin/problem") ?>"><button type="button" class="btn btn-accent"><i class="material-icons icon--left">keyboard_backspace</i> BACK</button></a>
                    </div>
                </div>
            </div>
        </form>
        </div>
        </div>
        <script>
            var editors = {}
            $(document).ready(function() {
                var enableMathQuillFormulaAuthoring = mathquill4quill();
                $('.create').click(function() {
                    createProblem(this);
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
                        $("#h" + this.id).val($("#" + this.id + " .ql-editor").html());
                    });
                });
            });

            createProblem = function(el) {
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
                            url: '<?= site_url('admin/createproblem') ?>',
                            success: function(data) {
                                swal({
                                    title: "",
                                    text: "Created New Problem. You can link Images by Image link button at Problem Table."
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