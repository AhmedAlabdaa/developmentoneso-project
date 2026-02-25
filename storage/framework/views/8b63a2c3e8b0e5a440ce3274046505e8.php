<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
  body { background: linear-gradient(to right, #e0f7fa, #e1bee7); font-family: Arial, sans-serif; }
  .table th, .table td { vertical-align: middle; }
  .nav-tabs .nav-link { transition: background-color .2s; }
  .nav-tabs .nav-link:hover { background-color: #f8f9fa; }
  .nav-tabs .nav-link.active { background-color: #007bff; color: #fff; }
  .table-responsive { margin-top: 20px; }
  .btn { transition: background-color .2s, color .2s; }
  .btn:hover { background-color: #007bff; color: #fff; }
  .card-title { font-weight: normal; }
  .description { font-size: 12px; color: #343a40; margin: 10px 0; padding: 10px; background: #f8f9fa; border-left: 5px solid #007bff; }
  .table thead th, .table tfoot th { background: linear-gradient(to right, #007bff, #00c6ff); color: #fff; text-align: center; font-weight: normal; }
  .btn-primary { background: linear-gradient(to right, #007bff, #00c6ff); border: none; }
  .input-group-text { cursor: pointer; }
  .preloader { padding: 20px; text-align: center; }
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card flex-fill">
          <div class="card-body">

            <div class="row mb-3 align-items-center">
              <div class="col-lg-4">
                <h5 class="card-title mb-0">All Customers</h5>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <input type="text" class="form-control" id="global_search" placeholder="Search by Emirates ID, Name, Mobile, Email">
                  <span class="input-group-text clear-filter" data-target="global_search">
                    <i class="fas fa-times"></i>
                  </span>
                  <button class="btn btn-outline-secondary" type="button" id="global_search_btn">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
              <div class="col-lg-4 text-lg-end mt-2 mt-lg-0">
                <a href="<?php echo e(route('crm.create')); ?>" class="btn btn-primary me-2">
                  <i class="fas fa-plus-circle"></i> Add Customer
                </a>
                <button type="button" class="btn btn-success" id="export_csv_btn">
                  <i class="fas fa-file-csv"></i> Export CSV
                </button>
              </div>
            </div>

            <?php if(session('success')): ?>
              <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <div><?php echo e(session('success')); ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php elseif(session('error')): ?>
              <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div><?php echo e(session('error')); ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <form id="filter_form"></form>

            <div class="table-responsive" id="customer_table">
              <div class="preloader">
                <i class="fas fa-spinner fa-spin"></i> Loading...
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
$(document).ready(function(){
    var debounceTimer;

    function getActiveStatus() {
        var activeTab = $('.nav-tabs a.active');
        return activeTab.length ? activeTab.data('status') : 'all';
    }

    function buildQueryString(status, page) {
        var formData = $('#filter_form').serialize();
        var globalSearch = $('#global_search').val();
        var query = formData ? formData : '';
        if (globalSearch) {
            query += (query ? '&' : '') + 'global_search=' + encodeURIComponent(globalSearch);
        }
        if (status) {
            query += (query ? '&' : '') + 'status=' + encodeURIComponent(status);
        }
        if (page) {
            query += (query ? '&' : '') + 'page=' + encodeURIComponent(page);
        }
        return query;
    }

    function loadCustomers(status = 'all', page = 1) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function(){
            var queryString = buildQueryString(status, page);
            $('.preloader').show();
            $.ajax({
                url: '<?php echo e(route("crm.index")); ?>',
                type: 'GET',
                data: queryString,
                success: function(data){
                    $('#customer_table').html(data);
                    $('.preloader').hide();
                },
                error: function(){
                    $('.preloader').hide();
                }
            });
        }, 300);
    }

    function exportCustomers() {
        var status = getActiveStatus();
        var queryString = buildQueryString(status);
        $.ajax({
            url: '<?php echo e(route("crm.export")); ?>',
            type: 'GET',
            data: queryString,
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data, textStatus, xhr){
                var disposition = xhr.getResponseHeader('Content-Disposition');
                var filename = 'customers.csv';
                if (disposition && disposition.indexOf('filename=') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) {
                        filename = matches[1].replace(/['"]/g, '');
                    }
                }
                var url = window.URL.createObjectURL(data);
                var a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            },
            error: function(){
            }
        });
    }

    loadCustomers();

    $('#global_search').on('keyup change', function(){
        loadCustomers(getActiveStatus());
    });

    $('#global_search_btn').click(function(){
        loadCustomers(getActiveStatus());
    });

    $('.clear-filter').click(function(){
        var target = $(this).data('target');
        if (target === 'global_search') {
            $('#global_search').val('');
        } else {
            $('[name="' + target + '"]').val('');
        }
        loadCustomers(getActiveStatus());
    });

    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadCustomers(getActiveStatus(), page);
    });

    $('#export_csv_btn').on('click', function(){
        exportCustomers();
    });

    $(document).on('shown.bs.tab', '.nav-tabs a', function(){
        loadCustomers(getActiveStatus());
    });
});
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/crm/index.blade.php ENDPATH**/ ?>