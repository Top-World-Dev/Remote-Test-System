                <div class="row">
                    <div class="col-lg-12 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">
                            <div class="form-row">
                                <div class="col-12 col-md-10 mb-2"></div>
                                <div class="col-12 col-md-2 mb-2">
                                    <label class="form-label" for="custom-select"></label>
                                    <a href="<?=site_url("admin/newsubjecttype")?>">
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
                        <table id="subject_type_table" class="table mb-0 thead-border-top-0 table-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 18px;" class="pr-0">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input js-toggle-check-all" data-target="#clients" id="customCheckAll_clients">
                                            <label class="custom-control-label" for="customCheckAll_clients"><span class="text-hide">Toggle all</span></label>
                                        </div>
                                    </th>
                                    <th style="width: 10%;">No</th>
                                    <th style="width: 40%;">Subject Type</th>
                                    <th style="width: 30%;">Subject Type ID</th>
                                    <th>Status</th>
                                    <th style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="clients">
                        <?php 
                            $i = 1;
                            foreach($records as $record) 
                            {
                        ?>
                                <tr data-id="<?=$record->Id?>">
                                    <td class="pr-0">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck1_clients_<?=$i?>">
                                            <label class="custom-control-label" for="customCheck1_clients_<?=$i?>"><span class="text-hide">Check</span></label>
                                        </div>
                                    </td>
                                    <td><?=$i?></td>
                                    <td><?=$record->subject_type?></td>
                                    <td><?=$record->type_id?></td>
                                    <td><?=$record->validity?'<span class="badge bg-success">Active</span>':'<span class="badge bg-danger">Banned</span>'?></td>
                                    <td>
                                        <a href="<?=site_url("admin/edit_subjecttype/{$record->Id}")?>" class="btn btn-dark btn-circle btn-sm mr-2"><i class="material-icons list-icon">edit</i></a>
                                        <button type="button" class="btn btn-danger btn-circle btn-sm remove" data-id="<?=$record->Id?>"><i class="material-icons list-icon">delete</i></button>
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
                    url: '<?=site_url("admin/removeRowsubjecttype")?>',
                    success: function(data) {
                        location.href = "<?=site_url('admin/subjecttype')?>";
                    }
                });
            }
        </script>