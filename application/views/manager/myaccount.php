                
                <div class="col-md-6 p-0" style="margin-left: 10%; margin-top: 25px;">
                    <form method="post">
                        <div class="form-group" style="margin-bottom: 2rem;">
                            <label class="form-label">User Name</label>
                            <input type="hidden" name="id" value="<?=$uinfo->uid?>">
                            <input type="text" name="uname" class="form-control required" value="<?=$uinfo->uname?>" placeholder="Your Name ...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="uemail" class="form-control required" value="<?=$uinfo->uemail?>" placeholder="Your email address ...">
                            <small class="form-text text-muted">Note that if you change your email, you will have to confirm it again.</small>
                        </div>
                        <!-- <button class="btn btn-primary change">Save changes</button> -->
                        <div class="row mb-32pt">
                            <div class="flex" style="max-width: 100%; position: absolute; right: 0px;">
                                <div class="button-list">
                                    <a><button class="btn btn-primary change"><i class="material-icons icon--left">create</i> Save Changes</button></a>
                                    <a href="<?=site_url("admin/users")?>"><button type="button" class="btn btn-accent"><i class="material-icons icon--left">keyboard_backspace</i> BACK</button></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.change').click(function() {
                    ChangeAccount(this);
                });
            });

            ChangeAccount = function(el) {
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
                            url: '<?=site_url('admin/updateAccount')?>',
                            success: function(data)
                            {
                                var json = JSON.parse(data);
                                if(json.status)
                                    swal("", "Your Account changed Successfully.");
                                else
                                    swal("", "The Email Address already exist.");
                                btn.attr('disabled', false);
                            }
                        });
                    }
                });
            }
        </script>