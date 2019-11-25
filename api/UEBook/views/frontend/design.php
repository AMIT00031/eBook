<nav class="navbar navbar-expand-lg navbar-light bg-light pt-0 pb-0">
      <a class="navbar-brand" href="#">Enter Name of Project</a> <a href="" class="text-primary ml-4">(Edit)</a> 
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse d-flex justify-content-end"" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link active" href="<?php echo base_url()?>">Home</a>
          <a class="nav-item nav-link" href="#">Reset Design</a>
          <a class="nav-item nav-link" href="#">Login</a>
          <a class="nav-item nav-link" href="#">Export Proposal(s)</a>
          <a class="nav-item nav-link bg-dark text-light" href="#">Request a Quote</a>
        </div>
      </div>
    </nav>

    <section class="page-wall" style="background: url('<?php echo base_url(); ?>assets/front/images/black-textured.jpg');">
      <div class="container-fuild">
        <div class="row">
          <div class="col-sm-12">
            <ul class="design-list list-inline float-left mr-5">
              <li class="active"><a href="">Option 1</a></li>
              <li><a href="">Option 2</a></li>
              <li><a href="">Option 3</a></li>
            </ul>

            <div class="input-group input-group-middle">
              <div class="input-group-prepend">
                <label class="input-group-text mt-2 mr-2 text-light" for="inputGroupSelect01">View</label>
              </div>
              <select class="custom-select mt-1" id="inputGroupSelect01" onchange="getImage(this.value)">
                <option value="1" selected >Video Display Drawings</option>
                <option value="2">Design Drawing</option>
                <option value="3">Power Cabling</option>
                <option value="4">Vedio Cabling</option>
              </select>

              <button type="button" class="btn btn-light btn-sm mt-1 ml-2 mr-2 text-uppercase" data-toggle="modal" data-target=".bd-example-modal-lg">Specifications</button>

              <div class="input-group-prepend">
                <label class="input-group-text mt-2 mr-2 text-light" for="inputGroupSelect01">Units</label>
              </div>
              <select class="custom-select mt-1" id="inputGroupSelect01">
                <option selected>Meters</option>
                <option value="1">Feet</option>
              </select>

            </div>

            <ul class="design-list design-tab-list list-inline float-right">
              <li class="active"><a class="flip" id="flip1">Video Display Configuration</a></li>
              <li><a class="flip" id="flip2">Room Setup</a></li>
              <li><a class="flip" id="flip3">Select Venue and Upload Video Content.</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
	
	 
    <div class="design_custom_tabs" id="design_tab_1">
        <h4 class="dst_title bg-dark text-white col-12 pt-3 pb-3">Video Display Configuration</h4>
        <div class="pt-2 pr-4 pb-2 pl-4 bb-666">
          <h4 class="text-muted"><i>Products & Modules</i></h4>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group select-size">
                <select value.bind="product &amp; signal:'app-state'" class="au-target form-control" au-target-id="222">
                    <option model.bind="null" class="au-target" au-target-id="223">Choose Product...</option>
                    <option model.bind="product.id" class="au-target" au-target-id="224">
                          Clarity Matrix G3
                    </option><option model.bind="product.id" class="au-target" au-target-id="224">
                          Leyard DLX
                    </option><option model.bind="product.id" class="au-target" au-target-id="224">
                          Leyard TWS
                    </option><option model.bind="product.id" class="au-target" au-target-id="224">
                          Leyard TWA
                    </option><option model.bind="product.id" class="au-target" au-target-id="224">
                          Leyard TVF
                    </option><!--anchor-->
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group select-size">
                <select value.bind="panel &amp; signal:'app-state'" class="au-target form-control" au-target-id="227">
				
					
                    <option class="au-target">Choose Model...</option>
                    <option class="au-target">Choose Model...</option>
                    <option class="au-target">Choose Model...</option>
                    <option class="au-target">Choose Model...</option>
                    <option class="au-target">Choose Model...</option>
					
                    <option model.bind="null" class="au-target" au-target-id="228">Choose Model...</option>
                    <option model.bind="panel.id" class="au-target" au-target-id="229">
                          MX46U
                    </option><option model.bind="panel.id" class="au-target" au-target-id="229">
                          LX46U
                    </option><option model.bind="panel.id" class="au-target" au-target-id="229">
                          MX46X
                    </option><option model.bind="panel.id" class="au-target" au-target-id="229">
                          LX46X
                    </option><option model.bind="panel.id" class="au-target" au-target-id="229">
                          MX55U
                    </option><option model.bind="panel.id" class="au-target" au-target-id="229">
                          LX55U
                    </option><option model.bind="panel.id" class="au-target" au-target-id="229">
                          MX55M
                    </option><option model.bind="panel.id" class="au-target" au-target-id="229">
                          LX55M
                    </option><option model.bind="panel.id" class="au-target" au-target-id="229">
                          MX55X
                    </option><option model.bind="panel.id" class="au-target" au-target-id="229">
                          LX55X
                    </option><option model.bind="panel.id" class="au-target" au-target-id="229">
                          MX65U
                    </option><!--anchor-->
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="pt-2 pr-4 pb-2 pl-4 bb-666">
          <h4 class="text-muted"><i>Vedio Wall Configuration</i></h4>
          <hr>
          <p class="text-light">Calculations will default to 16 x 9 aspect ratio <input type="radio" name="gender" value="male" class="float-right mt-1"></p>
          <hr>
          <p class="text-light d-inline-block w-100">Orientation 
            <span class="btn-group btn-group-toggle float-right" data-toggle="buttons">
              <label class="btn btn-secondary active">
                <input type="radio" name="options" id="option1" autocomplete="off" checked> Lanscape
              </label>
              <label class="btn btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off"> Portrait
              </label>
            </span>
          </p>
          <hr>
          <p class="text-light d-inline-block w-100">Configuration Method 
            <span class="btn-group btn-group-toggle mt-2 d-inline-block w-100" data-toggle="buttons">
              <label class="btn btn-secondary active">
                <input type="radio" name="options" id="option1" autocomplete="off" checked> Columns/Rows
              </label>
              <label class="btn btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off"> Vedio Wall Area
              </label>
              <label class="btn btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off"> Fit to Room
              </label>
            </span>
          </p>
          <hr>
        </div>

        <div class="pt-2 pr-4 pb-2 pl-4 bb-666">
          <h4 class="text-muted"><i>Product-Specific Options</i></h4>
          <hr>
          <p class="text-light d-inline-block w-100">Power Voltage 
            <span class="btn-group btn-group-toggle float-right" data-toggle="buttons">
              <label class="btn btn-secondary active">
                <input type="radio" name="options" id="option1" autocomplete="off" checked> 120V
              </label>
              <label class="btn btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off"> 240V
              </label>
            </span>
          </p>
          <hr>
          <p class="text-light d-inline-block w-100">Distance from Video Wall to Video Controllers (ft) 
            <span class="btn-group btn-group-toggle d-inline-block w-100 mt-2" data-toggle="buttons">
              <span class="form">
                <div class="value-button btn btn-dark" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                <input type="number" id="number" value="0" />
                <div class="value-button btn btn-dark" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
              </span>
              <label class="btn btn-secondary active float-right">
                <input type="radio" name="options" id="option1" autocomplete="off" checked> Distance Unknown
              </label>
            </span>
          </p>
          <hr>
          <p class="text-light d-inline-block w-100">Distance from Video Wall to Power Supplies (ft) 
            <span class="btn-group btn-group-toggle d-inline-block w-100 mt-2" data-toggle="buttons">
              <span class="form">
                <div class="value-button btn btn-dark" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                <input type="number" id="number" value="0" />
                <div class="value-button btn btn-dark" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
              </span>
              <label class="btn btn-secondary active float-right">
                <input type="radio" name="options" id="option1" autocomplete="off" checked> Distance Unknown
              </label>
            </span>
          </p>
          <hr>
          <p class="text-light d-inline-block w-100">Vedio Controllers
            <span class="btn-group btn-group-toggle float-right" data-toggle="buttons">
              <label class="btn btn-secondary active">
                <input type="radio" name="options" id="option1" autocomplete="off" checked> 9-Output
              </label>
              <label class="btn btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off"> 4-Output
              </label>
            </span>
          </p>
          <hr>
          <p class="text-light">Add Fiber Module <input type="radio" name="gender" value="male" class="float-right mt-1"></p>
          <hr>
          <p class="text-light">Add MultiTouch Option <input type="radio" name="gender" value="male" class="float-right mt-1"></p>
          <hr>
          <p class="text-light">Add ERO™ <input type="radio" name="gender" value="male" class="float-right mt-1"></p>
          <hr>
          <p class="text-light">Add Redundant Power <input type="radio" name="gender" value="male" class="float-right mt-1"></p>
        </div>
        <div class="pt-2 pr-4 pb-2 pl-4 bb-666">
          <div class="row">
            <div class="col-sm-6">
              <a href="" class="btn btn-light w-100 text-uppercase">Reset Setting</a>
            </div>
            <div class="col-sm-6">
              <a href="" class="btn btn-secondary w-100 text-uppercase">Delete Setting</a>
            </div>
          </div>
        </div>
    </div>   
    
    <div class="design_custom_tabs" id="design_tab_2">
        <h4 class="dst_title bg-dark text-white col-12 pt-3 pb-3">ROOM SETUP</h4>
        <div class="pt-2 pr-4 pb-2 pl-4 bb-666">
          <h4 class="text-muted"><i>Room Size</i></h4>
          <hr>
          <p class="text-light">Auto Room Size <input type="radio" name="gender" value="male" class="float-right mt-1"></p>
          <hr>
          <h4 class="text-muted"><i>Custom Room Dimensions (W X H) (ft)</i></h4>
          <span class="btn-group btn-group-toggle d-inline-block w-100 mt-2" data-toggle="buttons">
            <div class="row">
              <div class="col-sm-5 text-center">
                <span class="form">
                  <div class="value-button btn btn-dark" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                  <input type="number" id="number" value="0" />
                  <div class="value-button btn btn-dark" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                </span>
              </div>
              <div class="col-sm-2 text-center">
                <span class="form text-white h3">X</span>
              </div>
              <div class="col-sm-5 text-center">
                <span class="form">
                  <div class="value-button btn btn-dark" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                  <input type="number" id="number" value="0" />
                  <div class="value-button btn btn-dark" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                </span>
              </div>
            </div>
          </span>
        </div>

        <div class="pt-2 pr-4 pb-2 pl-4 bb-666">
          <h4 class="text-muted"><i>Select Room Environment</i></h4>
          <div class="form-group">
            <select value.bind="selectedEnvironment" class="au-target form-control" au-target-id="194">
              <option model.bind="environment.id" class="au-target" au-target-id="195">
                      None
              </option><option model.bind="environment.id" class="au-target" au-target-id="195">
                      Public Venue
              </option><option model.bind="environment.id" class="au-target" au-target-id="195">
                      Conference Room
              </option><option model.bind="environment.id" class="au-target" au-target-id="195">
                      Corporate Lobby
              </option><option model.bind="environment.id" class="au-target" au-target-id="195">
                      Retail
              </option><option model.bind="environment.id" class="au-target" au-target-id="195">
                      Control Room
              </option><option model.bind="environment.id" class="au-target" au-target-id="195">
                      Newsroom
              </option><!--anchor-->
            </select>
          <hr>
          <p class="text-light">Show Person <input type="radio" name="gender" value="male" class="float-right mt-1"></p>
          </div>
        </div>
        <div class="pt-2 pr-4 pb-2 pl-4 bb-666 d-inline-block w-100">
           <h4 class="text-muted"><i>Upload Custom Room Photo</i></h4>
          <div class="row">
            <div class="col-sm-6">
              <div class="edit-wall">
                <div class="env-img-rect"></div>
                <input id="environment-upload" type="file" files.bind="selectedFiles" change.delegate="onSelectFile($event)" class="env-img-file au-target" au-target-id="200">
              </div>
              <p><small class="text-light">* Acceptable file formats: .jpg., .gif, or .png - Maximum File Size 2mb</small></p>
            </div>
            <div class="col-sm-6">
              <a href="" class="btn btn-light w-100 mb-2">Show Me How</a>
              <a href="" class="btn btn-light w-100 mb-2">Add Custom Images</a>
              <a href="" class="btn btn-secondary w-100 mb-2" disabled>Edit</a>
              <a href="" class="btn btn-secondary w-100 mb-2" disabled>Deleted</a>
            </div>
          </div>
        </div>
    </div> 
    
    <div class="design_custom_tabs" id="design_tab_3">
        <h4 class="dst_title bg-dark text-white col-12 pt-3 pb-3">Select Venue and Upload Video Content.</h4>
        <div class="pt-2 pr-4 pb-2 pl-4 bb-666">
          <h4 class="text-muted"><i>Select Vedio Wall Content</i></h4>
          <div class="form-group">
            <select value.bind="background" class="au-target form-control" au-target-id="180">
              <option model.bind="background.id" class="au-target" au-target-id="181">
                    Choose Content...
              </option><option model.bind="background.id" class="au-target" au-target-id="181">
                    Retail
              </option><option model.bind="background.id" class="au-target" au-target-id="181">
                    Public Venue
              </option><option model.bind="background.id" class="au-target" au-target-id="181">
                    Corporate Lobby
              </option><option model.bind="background.id" class="au-target" au-target-id="181">
                    Control Room
              </option><option model.bind="background.id" class="au-target" au-target-id="181">
                    Conference Room
              </option><option model.bind="background.id" class="au-target" au-target-id="181">
                    Broadcast
              </option><!--anchor-->
            </select>
          </div>
        </div>
        <div class="pt-2 pr-4 pb-2 pl-4 bb-666 d-inline-block w-100">
           <h4 class="text-muted"><i>Upload Custom Vedio Wall Content</i></h4>
          <div class="row">
            <div class="col-sm-6">
              <div class="edit-wall">
                <div class="env-img-rect"></div>
                <input id="environment-upload" type="file" files.bind="selectedFiles" change.delegate="onSelectFile($event)" class="env-img-file au-target" au-target-id="200">
              </div>
            </div>
            <div class="col-sm-6">
              <a href="" class="btn btn-light w-100 mb-2">Upload</a>
              <a href="" class="btn btn-secondary w-100 mb-2" disabled>Delete</a>
            </div>
          </div>          
              <p><small class="text-light">* Acceptable file formats: .jpg., .gif, or .png - Maximum File Size 2mb</small></p>
        </div>
    </div>


     


    <section class="design_custom_wrp design_body text-center pt-5 pb-5" style="background: url('<?php echo base_url(); ?>assets/front/images/square.png'); background-size: 19px;">


      <div class="container">
        <div class="row flex justify-content-center">
            <div class="col-sm-8" id="defaultImg">
                <img src="<?php echo base_url(); ?>assets/front/images/desig_view.png" class="w-100">
            </div>
        </div>     
      </div>
    </section>

	<div class="modal bd-example-modal-lg specification_pop" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <h2 class="text-uppercase modal-title pl-3 pt-2 pb-2">Specification Data</h2>
		  <button type="button" data-dismiss="modal" class="btn btn-dark btn-close au-target close" au-target-id="367">X</button>
		</div>
		<div class="modal-body bg-white">
		  <table class="table table-bordered table-hover">
			<tr>
			  <th>SPECIFICATIONS</th>
			  <th>Option 1</th>
			  <th>Option 2</th>
			  <th>Option 3</th>
			</tr>
			<tr>
			  <td><strong>Product Model</strong></td>
			  <td><strong>Clarity Matrix G3</strong></td>
			  <td><strong>Clarity Matrix G3</strong></td>
			  <td><strong>Clarity Matrix G3</strong></td>
			</tr>
			<tr>
			  <td><strong>Product Option</strong></td>
			  <td><strong>MX55X-L</strong></td>
			  <td><strong>MX55X-L</strong></td>
			  <td><strong>MX55X-L</strong></td>
			</tr>
			<tr>
			  <td colspan="4" class="text-uppercase"><i>Display Requirements</i></td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Cabinets</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Mounts</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Mounts</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Mounts</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Mounts</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Mounts</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Mounts</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Mounts</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Mounts</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Mounts</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Mounts</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
			<tr>
			  <td><strong>Total Number of Display Mounts</strong></td>
			  <td>9</td>
			  <td>9</td>
			  <td>9</td>
			</tr>
		  </table>
		</div>
	  </div>
	</div>

  <script>
    function getImage(vall){

        var baseUrl = '<?php echo base_url()?>' ; 
       
        if(vall==2 || vall=='2'){  

             $('#defaultImg').html('<img src="http://dnddemo.com/vanguardled/assets/front/images/design-drawing.png" class="w-100">'); 

        }else if(vall==3 || vall=='3'){
           $('#defaultImg').html('<img src="http://dnddemo.com/vanguardled/assets/front/images/power-cabling.png" class="w-100">'); 
              
        }else if(vall==4 || vall=='4'){
             $('#defaultImg').html('<img src="http://dnddemo.com/vanguardled/assets/front/images/video-cabling.png" class="w-100">'); 
        }else{
             $('#defaultImg').html('<img src="http://dnddemo.com/vanguardled/assets/front/images/desig_view.png" class="w-100">'); 
        }

    
    }
  </script>
