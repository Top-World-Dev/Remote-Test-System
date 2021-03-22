                <div class="row">
                    <div class="col-lg-12 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">
                            <div class="form-row">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-lg-32pt">
                    <div class="table-responsive" data-toggle="lists" data-lists-sort-by="js-lists-values-date" data-lists-sort-desc="true" data-lists-values='["js-lists-values-name", "js-lists-values-company", "js-lists-values-phone", "js-lists-values-date"]'>
                        <table id="user_table" class="table mb-0 thead-border-top-0 table-nowrap">
                            <thead style="text-align: center;">
                                <tr>
                                    <th style="width: 10%;">ID</th>
                                    <th style="width: 25%;">Name</th>
                                    <th style="width: 40%;">Email</th>
                                    <th style="width: 20%;">Created At</th>
                                    <th style="width: 20%;">Status</th>
                                    <th style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="clients">
                        <?php
                            $i = 1;
                            foreach($users as $user) 
                            {
                        ?>
                                <tr data-id="<?=$user->uid?>" style="text-align:center;">
                                    <td><?=$user->uid?></td>
                                    <td><?=$user->uname?></td>
                                    <td><?=$user->uemail?></td>
                                    <td><?=date("m/d/Y", $user->create_at)?></td>
                                    <td><?=$user->status?'<span class="badge bg-danger">Banned</span>':'<span class="badge bg-success">Active</span>'?></td>
                                    <td>
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
                        text: "Are you sure want to remove this user?",
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
                    url: '<?=site_url("admin/removeRowUsers")?>',
                    success: function(data) {
                        location.href = "<?=site_url('admin/users')?>";
                    }
                });
            }
        </script>