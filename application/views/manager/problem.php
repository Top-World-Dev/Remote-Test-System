        <div class="row">
            <div class="col-lg-12 d-flex align-items-center">
                <div class="flex" style="max-width: 100%">
                    <!-- <form method="post"> -->
                    <div class="form-row">
                        <div class="col-12 col-md-2 mb-2">
                            <label class="form-label" for="custom-select">Type</label>
                            <select class="form-control" id="type_select" name="type_select">
                                <option value="0">Show All</option>
                                <?php
                                foreach ($PrTypes as $PrType) {
                                ?>
                                    <option><?= $PrType->product_type ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-2 mb-2">
                            <label class="form-label" for="custom-select">Category</label>
                            <select id="catego_select" class="form-control required">
                                <option value="0">Show All</option>
                                <option value="Standard">Standard</option>
                                <option value="Advance">Advance</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-2 mb-2">
                            <label class="form-label" for="custom-select">Subject</label>
                            <select id="subject_select" class="form-control required">
                                <option value="0">Show All</option>
                                <?php
                                foreach ($records as $record) {
                                ?>
                                    <option><?= $record->subject ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mb-2">
                            <!-- <label class="form-label" for="custom-select">Mode</label>
                                <div class="custom-controls-stacked" style="padding: 8px 4px;">
                                    <div class="custom-control custom-radio" style="display: inline-block;">
                                        <input id="radioStacked1" name="radio-stacked" type="radio" class="custom-control-input mode" checked="">
                                        <label for="radioStacked1" class="custom-control-label">Practice</label>
                                    </div>
                                    <div class="custom-control custom-radio" style="display: inline-block; margin-left: 13px;">
                                        <input id="radioStacked2" name="radio-stacked" type="radio" class="custom-control-input mode">
                                        <label for="radioStacked2" class="custom-control-label">Examination</label>
                                    </div>
                                </div> -->
                        </div>
                        <div class="col-12 col-md-2 mb-2">
                            <label class="form-label" for="custom-select"></label>
                            <a href="<?= site_url("admin/addproblem") ?>">
                                <button type="button" class="btn btn-accent pr-add">
                                    <i class="material-icons icon--left">library_add</i> Create
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <div class="card mb-lg-32pt">
            <div class="table-responsive">
                <table style="table-layout:fixed; width: 100%;" id="problem_table" class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr style="text-align: center;">
                            <th width="7%">Id</th>
                            <th width="8%">Type</th>
                            <th width="20%">Problem</th>
                            <th>Mode</th>
                            <th width="10%">Category</th>
                            <th>Subject</th>
                            <th width="12%">Module</th>
                            <th width="7%">PR/SR</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="clients">
                        <?php
                        $i = 1;
                        foreach ($problems as $problem) {
                        ?>
                            <tr data-id="<?= $problem->Id ?>" style="text-align: center;">
                                <td><?= $problem->Id ?></td>
                                <td><?= $problem->type ?></td>
                                <td id="appadd"><?= htmlentities($problem->question) ?></td>
                                <td><?= $problem->sub_type ?></td>
                                <td><?= $problem->category ?></td>
                                <td><?= $problem->subject ?></td>
                                <td><?= $problem->module ?></td>
                                <td>
                                    <a href="<?= site_url("admin/edit-picture/{$problem->Id}") ?>" class="btn btn-primary btn-circle btn-sm mr-2"><i class="material-icons list-icon">add_a_photo</i></a>
                                </td>
                                <td>
                                    <a href="<?= site_url("admin/edit-problem/{$problem->Id}") ?>" class="btn btn-dark btn-circle btn-sm mr-2"><i class="material-icons list-icon">edit</i></a>
                                    <button type="button" class="btn btn-danger btn-circle btn-sm remove"><i class="material-icons list-icon">delete</i></button>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        </div>
        <!-- // END Header Layout Content -->

        <script>
            $(document).ready(function() {
                $('.remove').click(function() {
                    var _this = this;
                    swal({
                        title: "",
                        text: "Are you sure want to remove this row?",
                        showCancelButton: true
                    }).then(function() {
                        removeRow($(_this).closest('tr'));
                    });
                });

                $("#type_select, #catego_select, #subject_select").on('change', function() {
                    // var id = 'type';
                    typefetch();
                });

                /*$('#problem_table').Datatable({

                });*/
            });

            removeRow = function($_el) {
                var params = [];
                params[0] = $_el.data("id");
                $.ajax({
                    type: 'POST',
                    dataType: 'text',
                    data: {
                        params: params,
                    },
                    url: '<?= site_url("admin/removeRowProblem") ?>',
                    success: function(data) {
                        location.href = "<?= site_url('admin/problem') ?>";
                    }
                });
            }

            typefetch = function() {
                var selectType = $('#type_select').val(),
                    selectCate = $('#catego_select').val(),
                    selectSubj = $('#subject_select').val();
                console.log(selectType, selectCate, selectSubj);
                $.ajax({
                    type: 'POST',
                    dataType: 'text',
                    data: {
                        selectType: selectType,
                        selectCate: selectCate,
                        selectSubj: selectSubj
                    },
                    // cache: false,
                    // async: true,
                    url: '<?= site_url('admin/problemRowFetch/') ?>',
                    success: function(data) {
                        // console.log(data);
                        $('#problem_table tbody').html(data);
                    }
                });
            }
        </script>