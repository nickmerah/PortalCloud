 <div class="row">

   <div class="col-12 col-sm-12 col-lg-12">

     <div class="card card-primary">
       <div class="card-header">
         <h4>Create Account

         </h4>

       </div>
       <?php if (session()->getFlashdata('error')) : ?>
         <div class="alert alert-danger">
           <?= session()->getFlashdata('error') ?>
         </div>
       <?php endif; ?>

       <?php if (session()->getFlashdata('success')) : ?>
         <div class="alert alert-success">
           <?= session()->getFlashdata('success') ?>
         </div>
       <?php endif; ?>
       <?php if (session()->getFlashdata('errors')) : ?>
         <div class="alert alert-danger">
           <?php foreach (session()->getFlashdata('errors') as $error) : ?>
             <p><?= esc($error) ?></p>
           <?php endforeach; ?>
         </div>
       <?php endif; ?>


       <form id="add_create" name="add_create" action="<?= base_url('account/store'); ?>" method="post">
         <?= csrf_field() ?>
         <div class="card-body">
           <input name="isjamb" type="hidden" value="no">

           <div class="form-group">
             <div class="input-group mb-2">
               <div class="input-group-prepend">
                 <div class="input-group-text"><i class="fas fa-user"></i></div>
               </div>
               <input name="log_surname" type="text" class="form-control" placeholder="Surname" required autocomplete="off" value="<?= old('log_surname'); ?>">
             </div>
           </div>

           <div class="form-group">
             <div class="input-group mb-2">
               <div class="input-group-prepend">
                 <div class="input-group-text"><i class="fas fa-user-plus"></i></div>
               </div>
               <input name="log_firstname" type="text" class="form-control" placeholder="Firstname" required autocomplete="off" value="<?= old('log_firstname'); ?>">
             </div>
           </div>

           <div class="form-group">
             <div class="input-group mb-2">
               <div class="input-group-prepend">
                 <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
               </div>
               <input name="log_othernames" type="text" class="form-control" placeholder="Othernames" autocomplete="off" value="<?= old('log_othernames'); ?>">
             </div>
           </div>

           <div class="form-group">
             <div class="input-group mb-2">
               <div class="input-group-prepend">
                 <div class="input-group-text"><i class="fas fa-school"></i></div>
               </div>
              <select name="sprogtype" id="sprogtype" class="form-control" required>
                 <option value="">Select Programme Type</option>
                 <?php foreach ($progtypes as $progtype) : ?>
                   <option value="<?= $progtype->programmet_id; ?>" <?= old('sprogtype') == $progtype->programmet_id ? 'selected' : '' ?>><?= $progtype->programmet_name; ?></option>
                 <?php endforeach; ?>
               </select>
             </div>
           </div>

           <div class="form-group">
             <div class="input-group mb-3">
               <div class="input-group-prepend">
                 <span class="input-group-text"><i class="fas fa-university"></i></span>
               </div>
               <select name="sprog" id="sel_prog" class="form-control" required>
                 <option value="">Select Programme</option>
                 <?php foreach ($progs as $prog) : ?>
                   <option value="<?= $prog->programme_id; ?>" <?= old('sprog') == $prog->programme_id ? 'selected' : '' ?>>
                     <?= $prog->programme_name; ?>
                   </option>
                 <?php endforeach; ?>
               </select>
             </div>
           </div>

           <div class="form-group">
             <div class="input-group mb-2">
               <div class="input-group-prepend">
                 <div class="input-group-text"><i class="fas fa-school"></i></div>
               </div>
               <select name="prog_id" id="sel_cos" class="form-control" required>
                 <option value="">Select Course of Study - First Choice</option>
               </select>
             </div>
           </div>

           <div class="form-group">
             <div class="input-group mb-2">
               <div class="input-group-prepend">
                 <div class="input-group-text"><i class="fas fa-school"></i></div>
               </div>
               <select name="prog_id_two" id="sel_cos_two" class="form-control" required>
                 <option value="">Select Course of Study - Second Choice</option>
               </select>
             </div>
           </div>

           <script>
             function updateCourseOptions(selectId, progId, progTypeId, optionText) {
               var cosSelect = document.getElementById(selectId);

               cosSelect.innerHTML = `<option value="">${optionText}</option>`;

               if (progId && progTypeId) {
                 fetch("<?= base_url('/account/getCos'); ?>", {
                     method: 'POST',
                     headers: {
                       'Content-Type': 'application/x-www-form-urlencoded'
                     },
                     body: new URLSearchParams({
                       'prog_id': progId,
                       'prog_type_id': progTypeId
                     })
                   })
                   .then(response => response.json())
                   .then(data => {
                     cosSelect.innerHTML = `<option value="">${optionText}</option>`;

                     data.forEach(cos => {
                       var option = document.createElement('option');
                       option.value = cos.do_id;
                       option.text = cos.programme_option;
                       cosSelect.add(option);
                     });
                   })
                   .catch(error => console.error('Error fetching Course of Study:', error));
               }
             }

             document.getElementById('sprogtype').addEventListener('change', function() {
               var sprogTypeId = this.value;

               document.getElementById('sel_prog').value = '';
               document.getElementById('sel_cos').innerHTML = '<option value="">Select Course of Study - First Choice</option>';
               document.getElementById('sel_cos_two').innerHTML = '<option value="">Select Course of Study - Second Choice</option>';

               document.getElementById('sel_prog').addEventListener('change', function() {
                 var progId = this.value;

                 document.getElementById('sel_cos').innerHTML = '<option value="">Select Course of Study - First Choice</option>';
                 document.getElementById('sel_cos_two').innerHTML = '<option value="">Select Course of Study - Second Choice</option>';

                 setTimeout(function() {
                   updateCourseOptions('sel_cos', progId, sprogTypeId, 'Select First Choice');
                   updateCourseOptions('sel_cos_two', progId, sprogTypeId, 'Select Second Choice');
                 }, 500); // Delay of 200ms to allow for the dropdown reset
               });
             });
           </script>


           <div class="form-group">
             <div class="input-group mb-2">
               <div class="input-group-prepend">
                 <div class="input-group-text"><i class="fas fa-lock"></i></div>
               </div>
               <input name="pwd" type="password" class="form-control pwstrength" placeholder="Password" required data-indicator="pwindicator" value="<?= old('pwd'); ?>">
             </div>
           </div>

           <div class="form-group">
             <div class="input-group mb-2">
               <div class="input-group-prepend">
                 <div class="input-group-text"><i class="fas fa-at"></i></div>
               </div>
               <input name="log_email" type="email" class="form-control" placeholder="Email Address" required autocomplete="off" value="<?= old('log_email'); ?>">
             </div>
           </div>

           <div class="form-group">
             <div class="input-group mb-2">
               <div class="input-group-prepend">
                 <div class="input-group-text"><i class="fas fa-phone"></i></div>
               </div>
               <input name="log_gsm" type="number" class="form-control" placeholder="Phone Number" required autocomplete="off" value="<?= old('log_gsm'); ?>">
             </div>
           </div>

           <div class="form-group">
             <div class="input-group mb-2">
               <div class="input-group-prepend">
                 <div class="input-group-text"><i class="fas fa-user-lock"></i></div>
               </div>
               <input type="number" class="form-control" name="captchaResult" placeholder="Solve the Math: <?php $min_number = 2;
                                                                                                            $max_number = 10;
                                                                                                            $random_number1 = mt_rand($min_number, $max_number);
                                                                                                            $random_number2 = mt_rand($min_number, $max_number);
                                                                                                            echo $random_number1 . ' + ' . $random_number2 . ' = '; ?>" required autocomplete="off">
             </div>
             <input name="firstNumber" type="hidden" value="<?= $random_number1; ?>" />
             <input name="secondNumber" type="hidden" value="<?= $random_number2; ?>" />
           </div>

           <div align="center">
             <button class="btn btn-primary btn-lg btn-block" type="submit">Create Account</button>
           </div>

           <br />
           <div class="float-right">
             <a href="<?= base_url(); ?>"><strong>&lt;&lt; Back to Home</strong></a>
           </div>
         </div>
       </form>


     </div>
     <div align="center" class="example5">
       <marquee> <?= $marquee; ?> </marquee>
     </div>

   </div>


 </div>

 </section>

 </div>
 <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
 <div class="simple-footer">
   Copyright &copy; DSPG
 </div>