<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>Support</span>
      </h1>
    </div>
  </div>
</div>
<div class="container-fluid mt-n10">
  @if (Session::has('bgs_msg'))
  {!! session('bgs_msg') !!}
  @endif
  <div class="card mb-4">
    <div class="card-header">
    </div>
    <div class="card-body">
      <div class="col-lg-12">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="" data-target="#faqs" data-toggle="tab" class="nav-link active">FAQs</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#how-to" data-toggle="tab" class="nav-link">How To</a>
          </li>
        </ul>
        <div class="tab-content py-4">
          <div class="tab-pane active" id="faqs">
            <div class="container py-3">
              <div class="row">
                <div class="col-10 mx-auto">
                  <div class="accordion" id="faqExample">
                    <div class="card">
                      <div class="card-header p-2" id="headingOne">
                        <h5 class="mb-0">
                          <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Q: How does this work?
                          </button>
                        </h5>
                      </div>

                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqExample">
                        <div class="card-body">
                          <b>Answer:</b> It works using the Bootstrap 4 collapse component with cards to make a vertical accordion that expands and collapses as questions are toggled.
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header p-2" id="headingTwo">
                        <h5 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Q: What is Bootstrap 4?
                          </button>
                        </h5>
                      </div>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqExample">
                        <div class="card-body">
                          Bootstrap is the most popular CSS framework in the world. The latest version released in 2018 is Bootstrap 4. Bootstrap can be used to quickly build responsive websites.
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header p-2" id="headingThree">
                        <h5 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Q. What is another question?
                          </button>
                        </h5>
                      </div>
                      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqExample">
                        <div class="card-body">
                          The answer to the question can go here.
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header p-2" id="headingThree">
                        <h5 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Q. What is the next question?
                          </button>
                        </h5>
                      </div>
                      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqExample">
                        <div class="card-body">
                          The answer to this question can go here. This FAQ example can contain all the Q/A that is needed.
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <!--/row-->
            </div>
            <!--container-->
          </div>
          <div class="tab-pane" id="how-to">
            <div class="row">
              <div class="col-4">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/v64KOxKVLVg" allowfullscreen></iframe>
                </div>
              </div>
              <div class="col-4">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/137857207" allowfullscreen></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>