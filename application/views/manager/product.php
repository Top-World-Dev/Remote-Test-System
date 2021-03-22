                <div class="row">
                    <div class="col-lg-12 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">
                            <div class="form-row">
                                <div class="col-12 col-md-2 mb-2">
                                    <!-- <label class="form-label" for="custom-select">Product</label>
                                    <select class="form-control">
                            <?php
                            foreach ($records as $record) {
                            ?>
                                        <option><?= $record->product ?></option>
                            <?php
                            }
                            ?>
                                    </select> -->
                                </div>
                                <div class="col-12 col-md-2 mb-2">
                                    <!-- <label class="form-label" for="custom-select">Module</label>
                                    <select class="form-control">
                            <?php
                            foreach ($records as $record) {
                            ?>
                                        <option><?= $record->module ?></option>
                            <?php
                            }
                            ?>
                                    </select> -->
                                </div>
                                <div class="col-12 col-md-2 mb-2">
                                    <!-- <label class="form-label" for="custom-select">Price(USD)</label>
                                    <select class="form-control">
                            <?php
                            foreach ($records as $record) {
                            ?>
                                        <option><?= $record->price_usd ?></option>
                            <?php
                            }
                            ?>
                                    </select> -->
                                </div>
                                <div class="col-12 col-md-4 mb-2"></div>
                                <div class="col-12 col-md-2 mb-2">
                                    <label class="form-label" for="custom-select"></label>
                                    <a href="<?= site_url("admin/newproduct") ?>">
                                        <button type="button" class="btn btn-accent pr-add">
                                            <i class="material-icons icon--left">library_add</i> Create
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-lg-32pt">
                    <div class="table-responsive" data-toggle="lists" data-lists-sort-by="js-lists-values-date" data-lists-sort-desc="true" data-lists-values='["js-lists-values-name", "js-lists-values-company", "js-lists-values-phone", "js-lists-values-date"]'>
                        <table id="product_table" class="table mb-0 thead-border-top-0 table-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 18px;" class="pr-0">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input js-toggle-check-all" data-target="#clients" id="customCheckAll_clients">
                                            <label class="custom-control-label" for="customCheckAll_clients"><span class="text-hide">Toggle all</span></label>
                                        </div>
                                    </th>
                                    <th>No</th>
                                    <th>Unique Ref</th>
                                    <th>Subject</th>
                                    <th>Subject Type</th>
                                    <th>Test During</th>
                                    <th>Nums of Question</th>
                                    <th>Test Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="clients">
                                <?php
                                $i = 1;
                                foreach ($records as $record) {
                                ?>
                                    <tr data-id="<?= $record->Id ?>">
                                        <td class="pr-0">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck1_clients_<?= $i ?>">
                                                <label class="custom-control-label" for="customCheck1_clients_<?= $i ?>"><span class="text-hide">Check</span></label>
                                            </div>
                                        </td>
                                        <td><?= $i ?></td>
                                        <td><?= $record->product_unique_ref ?></td>
                                        <td><?= $record->subject ?></td>
                                        <td><?= $record->subject_type ?></td>
                                        <td><?= $record->test_duration ?></td>
                                        <td><?= $record->number_of_question ?></td>
                                        <td><?= $record->test_date ?> <?= $record->test_time_gmt ?></td>
                                        <td><?= $record->validity ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Banned</span>' ?></td>
                                        <td>
                                            <a href="<?= site_url("admin/edit-product/{$record->Id}") ?>" class="btn btn-dark btn-circle btn-sm mr-2"><i class="material-icons list-icon">edit</i></a>
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
                        })
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
                            url: '<?= site_url("admin/removeRowProduct") ?>',
                            success: function(data) {
                                location.href = "<?= site_url('admin/product') ?>";
                            }
                        });
                    }
                </script>