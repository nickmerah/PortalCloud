      <!-- Main Content -->
      <div class="main-content">
            <section class="section">

              <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">

                  <h4 class="page-title m-b-0">My UTME Results</h4>
                </li>
                <li class="breadcrumb-item">
                  <a href="<?= base_url('applicant');?>">
                    <i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ul>

              <div class="container-fluid p-0">

  					<div class="row">


              <div class="col-md-9 col-xl-12">
							<div class="tab-content">
								 <div class="tab-pane fade show active" id="application" role="tabpanel">

									<div class="card">

										<div class="card-body">


                               <strong>ADD UTME RESULT DETAILS</strong>





<hr />


    <form   name="add_jamb"  action="add_jamb" method="post">


                                <div class="row">

 


                                 <div class="mb-3 col-md-12">
								   <label class="form-label" for="inputCity"><strong> UTME No</strong></label>
                             <input name="jambno" type="text" class="form-control" id="jambno"  value ="<?= $jambs[0]->jambno; ?>"  autocomplete = "off" required>    </div>



                             <div class=" col-lg-12">




                                                 <div class="alert alert-light ">

                                                UTME SUBJECTS & SCORE
                                                 </div>


                                           </div>
          <?php  //add multiple fields



 for($i = 1; $i <= 4 ; $i++)
 {
     $j = $i -1;
	 $subject = "subject$i";
	  $score = "score$i";
		  ?>



       <div class="mb-1 col-md-6">



       
          <input   type="text" class="form-control" id="score"   autocomplete = "off" value ="<?= $jambs[0]->$subject ;?>" required >



</div>


		 <div class="mb-1 col-md-6">

				<input  type="text" class="form-control" id="score"   autocomplete = "off" value ="<?= $jambs[0]->$score ;?>" required >




</div>
<br /><br />
			 <?php  }


			 ?>
<div class="mb-1 col-md-6">

				<strong>TOTAL: <?= $jambs[0]->score ;?></strong>




</div>
    
			  </div>

                               </form>

								</div>

						</div>
								<?php
								  if ($jambs)  {

								echo	 '<a href =  "'.base_url().'/applicant/appfinish/6" class="btn btn-info"><i class="fas fa-info"></i> Click here to Save and Continue </a>'; 

									 



								}?>

								</div>



							</div>
						</div>

              </div>
