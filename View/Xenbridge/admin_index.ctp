<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get("XENBRIDGE_MAIN_TITLE"); ?></h3> <span style="float:right;"><?= $Lang->get("PLUGIN_DEVELOPED_BY"); ?></span>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            <p style="text-align:justify;font-style:italic;"><?= $Lang->get("XENBRIDGE_PRESENTATION_TITLE"); ?></p>
                        </div>
                    </div>
					<h4 style="margin-top:30px;"><span class="fa fa-download"></span> <?= $Lang->get("XENBRIDGE_API_DOWNLOAD_TITLE"); ?></h4>
							<div class="row">
								<div class="col-md-5">
									<p style="text-align:justify;font-style:italic;"><?= $Lang->get("XENBRIDGE_API_DOWNLOAD"); ?></p>
									<p style="text-align:justify;font-style:italic;"><?= $Lang->get("XENBRIDGE_API_DOWNLOAD_EXPLAIN"); ?></p>
								</div>
							</div>
                    
                    <h4 style="margin-top:30px;"><span class="fa fa-list"></span> <?= $Lang->get("XENBRIDGE_PREREQUISITES_TITLE"); ?></h4>

                    <div class="row">
                        <div class="col-md-6">
                            <?php if(!$isRequestHttps || !$isForumHttps){ ?>
                                <div class="alert alert-warning">
                                    <strong>Oups !</strong> <?= $Lang->get("XENBRIDGE_SSL_MANDATORY"); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <?php if($isRequestHttps){ ?>
                    <span class="label label-success"><i class="fa fa-check"></i> <?= $Lang->get("XENBRIDGE_SSL_OK_MINEWEB"); ?></span>
                    <?php }else{ ?>
                    <span class="label label-danger"><i class="fa fa-times"></i> <?= $Lang->get("XENBRIDGE_SSL_NOTOK_MINEWEB"); ?></span>
                    <?php } ?>
                    <br><br>
                    <?php if($isForumHttps){ ?>
                    <span class="label label-success"><i class="fa fa-check"></i> <?= $Lang->get("XENBRIDGE_SSL_OK_FORUM"); ?></span>
                    <?php }else{ ?>
                    <span class="label label-danger"><i class="fa fa-times"></i> <?= $Lang->get("XENBRIDGE_SSL_NOTOK_FORUM"); ?></span>
                    <?php } ?>

                    <h4 style="margin-top:30px;"><span class="fa fa-file-text"></span> <?= $Lang->get("XENBRIDGE_CONFIGURATION_TITLE"); ?></h4>


                    <form method="post" action="<?= $this->Html->url(["controller" => "Xenbridge", "action" => "index", "admin" => true]); ?>" style="margin-left: -15px;">
                        <div class="form-group col-md-6">
                            <label class="control-label" id="xenapi_key"><?= $Lang->get("XENAPI_LABEL_XENAPI_KEY"); ?></label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-key"></span></span>
                                <input type="text" class="form-control" id="xenapi_key" name="xenapi_key" value="<?= (!empty($xenapi_key)) ? $xenapi_key : ''; ?>" placeholder="<?= $Lang->get("XENAPI_KEY_INPUT_PLACEHOLDER"); ?>" minlength="20" maxlength="50" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" id="xenapi_fullpath"><?= $Lang->get("XENAPI_LABEL_XENAPI_FULLPATH"); ?></label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-location-arrow"></span></span>
                                <input type="text" class="form-control" id="xenapi_fullpath" name="xenapi_fullpath" value="<?= (!empty($xenapi_fullpath)) ? $xenapi_fullpath : ''; ?>" placeholder="<?= $Lang->get("XENAPI_FULLPATH_INPUT_PLACEHOLDER"); ?>" minlength="10" required>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <span class="input-group-btn">
                                <input type="hidden" name="data[_Token][key]" value="<?= $csrfToken ?>">
                                <button type="submit" class="btn btn-primary"><?= $Lang->get("XENAPI_KEY_REGISTER"); ?></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<div class="clearfix"></div>
</section>