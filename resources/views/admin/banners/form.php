<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	echo "<pre>" . print_r($_POST). "</pre>";
}
?>
    <form method="post" enctype="multipart/form-data" id="banners">
        
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

          
            <!-- begin:: Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        
                        <div class="kt-portlet__body">


                            <div class="form-group row">
                                <div class="col-lg-7">
                                    <label for="title" class="-col-lg-2 -col-sm-12 -col-form-label required">Title:</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value=""/>
                                </div>
                                
                                
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="description" class="-col-lg-2 -col-sm-12 -col-form-label">Description:</label>
                                    <textarea name="description" id="description" placeholder="Description" class="editor form-control" cols="30" rows="8"></textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                        </div>

                        <div class="kt-portlet__foot">
                            <div class="btn-group">
                                <button name="submit" type="submit">Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>