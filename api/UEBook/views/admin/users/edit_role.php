<div id="main" role="main">
    <?php $this->load->view('header/breadcrumb');
    ?>
    <div id="content">
        <div id="infoMessage"><?php echo $message;?></div>
        <section id="widget-grid" class="">
            <div data-widget-editbutton="false" id="8521cbb7b77c1acb05ccf76f73014447" class="jarviswidget jarviswidget-sortable" role="widget">
                <div role="content">
                    <div class="widget-body ">
                        <div class="tabbable">
                            <form class="smart-form" id="country-form" novalidate="novalidate" data-parsley-validate="" novalidate="" method="post" enctype="multipart/form-data" action="<?php echo current_url() ?>">
                                <div class="tab-content padding-10">
                                    <div id="tab1" class="tab-pane active">
                                        <div class="row">
                                            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
                                                    <fieldset>
                                                        <section id="tour-grp">
                                                            <label class="label">Name</label>
                                                            <label class="input">
                                                                <input type="text" placeholder="Enter Role" name="group_name" required="" value="<?php echo $group->name ?>">
                                                            </label>
                                                        </section>


                                                        <section>
                                                            <label class="label">Description</label>
                                                            <label class="textarea"> 										
                                                                <textarea rows="3" name="group_description" placeholder="Additional info"><?php echo $group->description ?></textarea> 
                                                            </label>
                                                        </section>
                                                        
                                                    </fieldset>

                                            </article>
                                        </div>

                                    </div>
                                    <footer>
                                        <hr class="simple">
                                        <button class="btn btn-primary pull-right" type="submit">
                                            Update
                                        </button>
                                    </footer>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

