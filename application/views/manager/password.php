                <div class="col-md-6 p-0" style="margin-left: 10%; margin-top: 25px;">
                    <form method="post">
                        <div class="form-group" style="margin-bottom: 2rem;">
                            <label class="form-label" for="password">New Password:</label>
                            <input id="password" name="password" type="password" class="form-control required" placeholder="Type a new password ...">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password2">Confirm Password:</label>
                            <input id="npassword" name="npassword" type="password" class="form-control required" placeholder="Confirm your new password ...">
                        </div>
                        <div class="row mb-32pt">
                            <div class="flex" style="max-width: 100%; position: absolute; right: 0px;">
                                <div class="button-list">
                                    <a><button class="btn btn-primary change"><i class="material-icons icon--left">create</i> Save Password</button></a>
                                    <a href="<?=site_url("admin/users")?>"><button type="button" class="btn btn-accent"><i class="material-icons icon--left">keyboard_backspace</i> Cancel</button></a>
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
                    ChangePassword(this);
                });
            });

            ChangePassword = function(el) {
                var btn = $(el);
                var form = $(el).closest('form');
                form.validate({
                    errorClass: 'error text-danger',
                    rules: {
                        password: {
                            minlength: 8,
                            maxlength: 20
                        },
                        npassword: {
                            minlength: 8,
                            maxlength: 20
                        }
                    },
                    submitHandler: function() {
                        btn.attr('disabled', true);
                        $.ajax({
                            type: 'POST',
                            dataType: 'text',
                            data: {
                                params: form.serializeArray(),
                            },
                            url: '<?=site_url('admin/updatePassword')?>',
                            success: function(data)
                            {
                                var json = JSON.parse(data);
                                if(json.status)
                                    swal("", "Your Password changed Successfully.");
                                else
                                    swal("", "The Confirm Password field does not match the Password field.");
                                btn.attr('disabled', false);
                                form[0].reset();
                            }
                        });
                    }
                });
            }
        </script>