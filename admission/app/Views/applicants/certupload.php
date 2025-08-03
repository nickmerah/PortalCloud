      <!-- Main Content -->

      <div class="main-content">
          <section class="section">
              <ul class="breadcrumb breadcrumb-style">
                  <li class="breadcrumb-item">
                      <h4 class="page-title m-b-0">Document Upload</h4>
                  </li>
                  <li class="breadcrumb-item">
                      <a href="{{ url('applicant') }}">
                          <i class="fas fa-home"></i>
                      </a>
                  </li>
                  <li class="breadcrumb-item active">Dashboard</li>
              </ul>

              <div class="col-md-9 col-xl-12">
                  <div class="tab-content">
                      <div class="tab-pane fade show active" id="application" role="tabpanel">
                          <div class="card">
                              <div class="card-body">
                                  @php
                                  $showITform = false;
                                  $resultname = "Jamb";

                                  if ($stddetails[0]->stdprogramme_id == 2) {
                                  $resultname = "ND";
                                  $showITform = true;
                                  }
                                  @endphp

                                  @if(session('success'))
                                  <div class="alert alert-success">
                                      {{ session('success') }}
                                  </div>
                                  @endif

                                  @if(session('error'))
                                  <div class="alert alert-danger">
                                      {{ session('error') }}
                                  </div>
                                  @endif

                                  @if ($getdocs)
                                  <h5 class="card-title mb-0"><strong>DOCUMENT UPLOAD</strong></h5>
                                  <hr>
                                  <table class="table table-bordered" style="font-size: 13px;">
                                      <thead>
                                          <tr>
                                              <th>DOCUMENT NAME</th>
                                              <th>ACTION</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($getdocs as $docs)
                                          <tr>
                                              <td>{{ $docs->docname }}</td>
                                              <td>
                                                  <a href="{{ url('writable/uploads/' . $docs->uploadname) }}" target="_blank">
                                                      View Document
                                                  </a>
                                              </td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                                  <br>
                                  <a class="btn btn-danger"
                                      href="{{ url('/applicant/rem_doc/' . $docs->stdid) }}"
                                      onclick="return confirm('Are you sure you want to re-upload the documents? This will remove any existing uploaded documents.');">
                                      ReUpload Documents
                                  </a>
                                  @else
                                  <hr />
                                  <strong>UPLOAD DOCUMENT</strong>

                                  <div class="alert alert-warning">
                                      <strong>File Upload Guidelines:</strong>
                                      <ul>
                                          <li>Only PDF files are allowed.</li>
                                          <li>Minimum file size: 100KB.</li>
                                      </ul>
                                  </div>
                                  <hr />

                                  <form name="addcert" action="{{ route('admissions.documents') }}" method="post" enctype="multipart/form-data">
                                      @csrf
                                      <div class="row">
                                          <div class="mb-3 col-md-12">
                                              <label class="form-label"><strong>{{ $resultname }} Result</strong></label>
                                              <input name="jamb_nd_result" type="file" class="form-control" required accept=".pdf">
                                          </div>

                                          <div class="mb-3 col-md-12">
                                              <label class="form-label"><strong>O’ Level Result (If you have 2 results, combine in one file)</strong></label>
                                              <input name="o_level_result" type="file" class="form-control" required accept=".pdf">
                                          </div>

                                          <div class="mb-3 col-md-12">
                                              <label class="form-label"><strong>Birth Certificate</strong></label>
                                              <input name="birth_certificate" type="file" class="form-control" required accept=".pdf">
                                          </div>

                                          <div class="mb-3 col-md-12">
                                              <label class="form-label"><strong>Proof of LGA</strong></label>
                                              <input name="lga_proof" type="file" class="form-control" required accept=".pdf">
                                          </div>

                                          <div class="mb-3 col-md-12">
                                              <label class="form-label"><strong>Attestation Letter</strong></label>
                                              <input name="attestation_letter" type="file" class="form-control" required accept=".pdf">
                                          </div>

                                          @if ($showITform)
                                          <div class="mb-3 col-md-12">
                                              <label class="form-label"><strong>ND Admission Letter / Jamb Result</strong></label>
                                              <input name="nd_admission_letter_jamb_result" type="file" class="form-control" required accept=".pdf">
                                          </div>

                                          <div class="mb-3 col-md-12">
                                              <label class="form-label"><strong>IT Letter</strong></label>
                                              <input name="it_letter" type="file" class="form-control" required accept=".pdf">
                                          </div>
                                          @endif
                                      </div>

                                      <button type="submit" class="btn btn-primary">Upload Documents</button>
                                  </form>
                                  @endif
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
      </div>