                <div class="row mb-32pt">
                    <div class="col-lg-4">
                        <div class="page-separator">
                            <div class="page-separator__text">Add Reference Pictures</div>
                        </div>
                        <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                            You must add 10 pictures to complete problem.</br>
                            Also, you can add only one image each field.</br><a href="<?=site_url("admin/problem")?>" style="font-weight: bold;">Show problem table</a>
                        </p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">
                            <div class="form-row">
                                <div class="col-md-12 form-group row">
                                    <div class="flex col-md-3">   
                                        <label class="form-label">PR1</label>
                                        <div class="dropzone" id="PR1"></div>
                                    </div>
                                    <div class="flex col-md-3">   
                                        <label class="form-label">PR2</label>
                                        <div class="dropzone" id="PR2"></div>
                                    </div>
                                    <div class="flex col-md-3">   
                                        <label class="form-label">PR3</label>
                                        <div class="dropzone" id="PR3"></div>
                                    </div>
                                    <div class="flex col-md-3">   
                                        <label class="form-label">PR4</label>
                                        <div class="dropzone" id="PR4"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group row">
                                    <div class="flex col-md-3">   
                                        <label class="form-label">PR5</label>
                                        <div class="dropzone" id="PR5"></div>
                                    </div>
                                    <div class="flex col-md-3">   
                                        <label class="form-label">PR6</label>
                                        <div class="dropzone" id="PR6"></div>
                                    </div>
                                    <div class="flex col-md-3">   
                                        <label class="form-label">PR7</label>
                                        <div class="dropzone" id="PR7"></div>
                                    </div>
                                    <div class="flex col-md-3">   
                                        <label class="form-label">PR8</label>
                                        <div class="dropzone" id="PR8"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group row">
                                    <div class="flex col-md-3">   
                                        <label class="form-label">PR9</label>
                                        <div class="dropzone" id="PR9"></div>
                                    </div>
                                    <div class="flex col-md-3">   
                                        <label class="form-label">PR10</label>
                                        <div class="dropzone" id="PR10"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-32pt">
                    <div class="col-lg-4">
                        <div class="page-separator">
                            <div class="page-separator__text">Add Solution Pictures</div>
                        </div>
                        <p class="card-subtitle text-70 mb-16pt mb-lg-0">
                            You can add pictures to complete problem.</br>
                            Also, you can add only one image each field.</br><a href="<?=site_url("admin/problem")?>" style="font-weight: bold;">Show problem table</a>
                        </p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">
                            <div class="form-row">
                                <div class="col-md-12 form-group row">
                                    <div class="flex col-md-3">   
                                        <label class="form-label">SR1</label>
                                        <div class="dropzone" id="SR1"></div>
                                    </div>
                                    <div class="flex col-md-3">   
                                        <label class="form-label">SR2</label>
                                        <div class="dropzone" id="SR2"></div>
                                    </div>
                                    <div class="flex col-md-3">   
                                        <label class="form-label">SR3</label>
                                        <div class="dropzone" id="SR3"></div>
                                    </div>
                                    <div class="flex col-md-3">   
                                        <label class="form-label">SR4</label>
                                        <div class="dropzone" id="SR4"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group row">
                                    <div class="flex col-md-3">   
                                        <label class="form-label">SR5</label>
                                        <div class="dropzone" id="SR5"></div>
                                    </div>
                                    <div class="flex col-md-3">   
                                        <label class="form-label">SR6</label>
                                        <div class="dropzone" id="SR6"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-32pt">
                    <div class="flex" style="max-width: 100%; position: absolute; right: 45px;">
                        <a href="<?=site_url("admin/problem")?>"><button type="button" class="btn btn-accent"><i class="material-icons icon--left">keyboard_backspace</i> BACK</button></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- // END Header Layout Content -->

        <script>
            $(document).ready(function() {
                Dropzone.autoDiscover = false;

                var PR1 = new Dropzone('#PR1', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadPRFile-1/{$prnumber}")?>"
                });
                var PR2 = new Dropzone('#PR2', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadPRFile-2/{$prnumber}")?>"
                });
                var PR3 = new Dropzone('#PR3', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadPRFile-3/{$prnumber}")?>"
                });
                var PR4 = new Dropzone('#PR4', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadPRFile-4/{$prnumber}")?>"
                });
                var PR5 = new Dropzone('#PR5', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadPRFile-5/{$prnumber}")?>"
                });
                var PR6 = new Dropzone('#PR6', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadPRFile-6/{$prnumber}")?>"
                });
                var PR7 = new Dropzone('#PR7', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadPRFile-7/{$prnumber}")?>"
                });
                var PR8 = new Dropzone('#PR8', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadPRFile-8/{$prnumber}")?>"
                });
                var PR9 = new Dropzone('#PR9', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadPRFile-9/{$prnumber}")?>"
                });
                var PR10 = new Dropzone('#PR10', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadPRFile-10/{$prnumber}")?>"
                });

                var SR1 = new Dropzone('#SR1', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadSRFile-1/{$prnumber}")?>"
                });
                var SR2 = new Dropzone('#SR2', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadSRFile-2/{$prnumber}")?>"
                });
                var SR3 = new Dropzone('#SR3', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadSRFile-3/{$prnumber}")?>"
                });
                var SR4 = new Dropzone('#SR4', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadSRFile-4/{$prnumber}")?>"
                });
                var SR5 = new Dropzone('#SR5', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadSRFile-5/{$prnumber}")?>"
                });
                var SR6 = new Dropzone('#SR6', {
                    maxFiles: 1,
                    url: "<?=site_url("admin/uploadSRFile-6/{$prnumber}")?>"
                });
            });
        </script>