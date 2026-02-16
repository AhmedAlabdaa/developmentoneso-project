@include('../layout.Sales_Coordinator_header')
<main id="main" class="main">
  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="row">
          <!-- Profiles Card -->
          <div class="col-xxl-4 col-md-6 mb-3">
            <div class="card info-card profiles-card">
              <div class="card-body">
                <h5 class="card-title" title="Total number of profiles available.">Profiles</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-circle"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none">0</a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Active Profiles Card -->
          <div class="col-xxl-4 col-md-6 mb-3">
            <div class="card info-card active-profiles-card">
              <div class="card-body">
                <h5 class="card-title" title="Profiles that are currently active and in use.">Active Profiles</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-check"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none">0</a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Expired Profiles Card -->
          <div class="col-xxl-4 col-md-6 mb-3">
            <div class="card info-card expired-profiles-card">
              <div class="card-body">
                <h5 class="card-title" title="Profiles that have expired and are no longer valid.">Expired Profiles</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-x"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none">0</a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Cancelled Profiles Card -->
          <div class="col-xxl-4 col-md-6 mb-3">
            <div class="card info-card cancelled-card">
              <div class="card-body">
                <h5 class="card-title" title="Profiles that have been cancelled.">Cancelled</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-x-circle"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none">0</a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Profiles Approaching Expiry Date Card -->
          <div class="col-xxl-4 col-md-6 mb-3">
            <div class="card info-card expiry-card">
              <div class="card-body">
                <h5 class="card-title" title="Profiles that are approaching their expiry date.">Expiry</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-calendar-x"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none">0</a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Overstay Profiles Card -->
          <div class="col-xxl-4 col-md-6 mb-3">
            <div class="card info-card overstay-card">
              <div class="card-body">
                <h5 class="card-title" title="Profiles that have overstayed beyond the allowed duration.">Overstay</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-clock-history"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none">0</a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- This Month Expiry Profiles Card -->
          <div class="col-xxl-4 col-md-6 mb-3">
            <div class="card info-card this-month-expiry-card">
              <div class="card-body">
                <h5 class="card-title" title="Profiles expiring within this month.">This Month Expiry</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-calendar-month"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none">0</a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Next Month Expiry Profiles Card -->
          <div class="col-xxl-4 col-md-6 mb-3">
            <div class="card info-card next-month-expiry-card">
              <div class="card-body">
                <h5 class="card-title" title="Profiles expiring in the next month.">Next Month Expiry</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-calendar-plus"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none">0</a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Passport Expiry Profiles Card -->
          <div class="col-xxl-4 col-md-6 mb-3">
            <div class="card info-card passport-expiry-card">
              <div class="card-body">
                <h5 class="card-title" title="Passports that are about to expire this month.">Passport Expiry</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-passport"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none">0</a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Expired Passports Card -->
          <div class="col-xxl-4 col-md-6 mb-3">
            <div class="card info-card expired-passports-card">
              <div class="card-body">
                <h5 class="card-title" title="Passports that have expired.">Expired Passports</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-passport"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none">0</a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@include('../layout.footer')
