
$(function() {
    
    $('#display_stories').DataTable({
        "order": [[ 0, "desc" ]]
    } );
    $('#subscriber_table').DataTable({
        "order": [[ 0, "desc" ]]
    } );
    $('#display_epaper').DataTable({
        "order": [[ 0, "desc" ]]
    } );
    
    $('#failed_jobs_table').DataTable();
    $('#queued_jobs_table').DataTable();
} );


