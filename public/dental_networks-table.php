<section class="content-header">
    <h1>
        Dental Provider Networks /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
    </h1>
    <!-- <ol class="breadcrumb">
            <a class="btn btn-block btn-default" href="add-category.php"><i class="fa fa-plus-square"></i> Add New Category</a>
    </ol> -->
    
</section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="">Filter by From Date</label>
                                    <input type="date" class="form-control" name="from_date" id="from_date">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Filter by To Date</label>
                                    <input type="date" class="form-control" name="to_date" id="to_date">
                                </div>
                            </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=dental_networks" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc"  
                        data-show-export="true" data-export-types='["txt","csv"]'  data-export-options='{
                            "fileName": "dental_networks-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="name">User Name</th>
                                    <th data-field="datetime" data-sortable="true">Datetime</th>
                                    <th data-field="clinic_name" data-sortable="true">Clinic Name</th>
                                    <th data-field="address" data-sortable="true">Address</th>
                                    <th data-field="email" data-sortable="true">Email</th>
                                    <th data-field="mobile" data-sortable="true">Mobile Number</th>
                                    <th data-field="latitude" data-sortable="true">Latitude</th>
                                    <th data-field="longitude" data-sortable="true">Longitude</th>
                                    <!-- <th data-field="operate">Action</th> -->
                    
                    
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="separator"> </div>
        </div>
        <!-- /.row (main row) -->
    </section>
<script>
    // $('#seller_id').on('change', function() {
    //     $('#products_table').bootstrapTable('refresh');
    // });
    $('#from_date').on('change', function() {
        id = $('#from_date').val();
        $('#users_table').bootstrapTable('refresh');
    });
    $('#to_date').on('change', function() {
        id = $('#to_date').val();
        $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "from_date": $('#from_date').val(),
            "to_date": $('#to_date').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>