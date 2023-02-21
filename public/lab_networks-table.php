<section class="content-header">
    <h1>
        LAB Networks /
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

                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=lab_networks" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc"  data-export-options='{
                            "fileName": "lab_networks-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="name" data-sortable="false">User Name</th>
                                    <th data-field="center_name" data-sortable="true">Center Name</th>
                                    <th data-field="email" data-sortable="true">Email</th>
                                    <th data-field="mobile" data-sortable="true">Mobile Number</th>
                                    <th data-field="manager_name" data-sortable="true"> Manager Name</th>
                                    <th data-field="center_address" data-sortable="true"> Center Address</th>
                                    <th data-field="operational_hours" data-sortable="true">Operational Hours</th>
                                    <th data-field="latitude" data-sortable="true">Latitude</th>
                                    <th data-field="longitude" data-sortable="true">Longitude</th>
                                    <th data-field="image">Image</th>
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
    $('#seller_id').on('change', function() {
        $('#products_table').bootstrapTable('refresh');
    });
    $('#community').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "category_id": $('#category_id').val(),
            "seller_id": $('#seller_id').val(),
            "community": $('#community').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>