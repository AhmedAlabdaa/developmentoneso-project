@include('role_header')
<main id="main" class="main">
  <section class="section settings">
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-body pt-3">

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#user-management">User Management</button>
              </li>
              <li class="nav-item">
                <button class="nav-link {{ old('settings_type') == 'notifications' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#notifications">Notifications</button>
              </li>
              <li class="nav-item">
                <button class="nav-link {{ old('settings_type') == 'system' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#system-settings">System Settings</button>
              </li>
            </ul>
            <div class="tab-content pt-2">
              <!-- User Management -->
              <div class="tab-pane fade show active" id="user-management">
                <h5 class="card-title">User Management</h5>
                <form action="{{ route('settings.users.update') }}" method="POST">
                  @csrf
                  <input type="hidden" name="settings_type" value="user_management">
                  <div class="row mb-3">
                    <label for="defaultRole" class="col-md-4 col-lg-3 col-form-label">Default User Role</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" class="form-control" name="default_role" value="HRM" readonly>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="userApproval" class="col-md-4 col-lg-3 col-form-label">User Approval</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="userApproval" name="user_approval" {{ old('user_approval', $settings->user_approval ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="userApproval">
                          Require admin approval for new users
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form>
              </div>
              <!-- Notifications -->
              <div class="tab-pane fade {{ old('settings_type') == 'notifications' ? 'show active' : '' }}" id="notifications">
                <h5 class="card-title">Notification Settings</h5>
                <form action="{{ route('settings.notifications.update') }}" method="POST">
                  @csrf
                  <input type="hidden" name="settings_type" value="notifications">
                  <div class="row mb-3">
                    <label for="emailNotifications" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="emailNotifications" name="email_notifications" {{ old('email_notifications', $settings->email_notifications ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="emailNotifications">
                          Enable email notifications
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="pushNotifications" class="col-md-4 col-lg-3 col-form-label">Push Notifications</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="pushNotifications" name="push_notifications" {{ old('push_notifications', $settings->push_notifications ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="pushNotifications">
                          Enable push notifications
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form>
              </div>
              <!-- System Settings -->
              <div class="tab-pane fade {{ old('settings_type') == 'system' ? 'show active' : '' }}" id="system-settings">
                <h5 class="card-title">System Settings</h5>
                <form action="{{ route('settings.system.update') }}" method="POST">
                  @csrf
                  <input type="hidden" name="settings_type" value="system">
                  <div class="row mb-3">
                    <label for="timezone" class="col-md-4 col-lg-3 col-form-label">Timezone</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="timezone" id="timezone" class="form-select">
                        <!-- Populate this with a list of timezones -->
                        <option value="UTC" {{ old('timezone', $settings->timezone ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                        <option value="America/New_York" {{ old('timezone', $settings->timezone ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New York</option>
                        <option value="Europe/London" {{ old('timezone', $settings->timezone ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                        <!-- Add more options as needed -->
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="dateFormat" class="col-md-4 col-lg-3 col-form-label">Date Format</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="date_format" id="dateFormat" class="form-select">
                        <option value="Y-m-d" {{ old('date_format', $settings->date_format ?? '') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                        <option value="d/m/Y" {{ old('date_format', $settings->date_format ?? '') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                        <option value="m/d/Y" {{ old('date_format', $settings->date_format ?? '') == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                        <!-- Add more options as needed -->
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="language" class="col-md-4 col-lg-3 col-form-label">Language</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="language" id="language" class="form-select">
                        <option value="en" {{ old('language', $settings->language ?? '') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ old('language', $settings->language ?? '') == 'es' ? 'selected' : '' }}>Spanish</option>
                        <option value="fr" {{ old('language', $settings->language ?? '') == 'fr' ? 'selected' : '' }}>French</option>
                        <option value="ar" {{ old('language', $settings->language ?? '') == 'ar' ? 'selected' : '' }}>Arabic</option>
                        <!-- Add more options as needed -->
                      </select>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@include('../layout.footer')
