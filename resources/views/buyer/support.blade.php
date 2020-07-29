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
                  <div class="accordion" id="faqList">
                    @foreach($faqs as $faq)
                    <div class="card">
                      <div class="card-header p-2" id="heading-{{ $faq['id'] }}">
                        <h5 class="mb-0">
                          <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-{{ $faq['id'] }}" aria-expanded="false" aria-controls="collapse-{{ $faq['id'] }}">
                            Q: {{ ucwords($faq['question']) }}
                          </button>
                        </h5>
                      </div>
                      <div id="collapse-{{ $faq['id'] }}" class="collapse" aria-labelledby="heading-{{ $faq['id'] }}" data-parent="#faqList">
                        <div class="card-body">
                          <b>Answer:</b> {{ ucwords($faq['answer']) }}
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>

                </div>
              </div>
              <!--/row-->
            </div>
            <!--container-->
          </div>
          <div class="tab-pane" id="how-to">
            <div class="row">
              @foreach($how_tos as $how_to)
              <div class="col-4">
                <h6><strong>{{ $how_to['title'] }}</strong></h6>
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="{{ $how_to['link'] }}" allowfullscreen></iframe>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>