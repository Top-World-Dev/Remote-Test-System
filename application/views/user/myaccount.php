            <div class="input-form">
                <div class="pt-64pt">
                    <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
                        <div class="flex d-flex flex-column flex-sm-row align-items-center">
                            <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                                <h2 class="mb-0"><?=$title?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container page__container page-section" style="margin-top: 0px;">
                    
                    <div class="col-md-6 p-0">
                        <form method="post">
                            <div style="margin-bottom: 2rem;">
                                <label class="form-label">User Name</label>
                                <input type="hidden" name="id" value="<?=$uinfo->uid?>">
                                <input type="text" name="uname" class="form-control required" value="<?=$uinfo->uname?>" placeholder="Your Name ...">
                            </div>
                            <div style="margin-bottom: 2rem;">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="uemail" class="form-control required" value="<?=$uinfo->uemail?>" placeholder="Your Email Address ...">
                                <small class="form-text text-muted">Note that if you change your email, you will have to confirm it again.</small>
                            </div>
                            <div class="row mb-32pt">
                                <div class="flex" style="max-width: 100%; position: absolute; right: 0px;">
                                    <div class="button-list">
                                        <a><button class="btn btn-primary change"><i class="material-icons icon--left">create</i> Save Changes</button></a>
                                        <a href="<?=site_url("student/changeAccount")?>"><button type="button" class="btn btn-accent"><i class="material-icons icon--left">keyboard_backspace</i> Cancel</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
                            url: '<?=site_url('student/updateAccount')?>',
                            success: function(data)
                            {
                                var json = JSON.parse(data);
                                if(json.status)
                                    swal("", "Your Account changed Successfully.");
                                else {
                                    swal({
                                        title: "",
                                        text: "The Email Address already exist."
                                    }).then(function() {
                                        location.href = "<?=site_url('student/changeAccount')?>";
                                    });
                                }
                                btn.attr('disabled', false);
                            }
                        });
                    }
                });
            }
        </script>