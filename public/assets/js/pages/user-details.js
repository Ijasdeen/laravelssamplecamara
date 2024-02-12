$(document).ready(function() {
    function initRating(row) {
        $('span.rating', row).raty({
            half: true,
            starHalf: 'https://cdnjs.cloudflare.com/ajax/libs/raty/2.7.0/images/star-half.png',
            starOff: 'https://cdnjs.cloudflare.com/ajax/libs/raty/2.7.0/images/star-off.png',
            starOn: 'https://cdnjs.cloudflare.com/ajax/libs/raty/2.7.0/images/star-on.png',
            readOnly: true,
            score: function() {
                var score = $(this).attr('data-score');
                return score;
            },
            hints: function() {
                var score = $(this).attr('data-score');
                return [score, score, score, score, score];
            },
        });
    }
    // Bookmark class table
    var table = $('#bookmark_class_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [1, 'desc']
        ],
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // Download class table
    var table = $('#download_class_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [1, 'desc']
        ],
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // Viewers class table
    var table = $('#viewers_class_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [1, 'desc']
        ],
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // Rating review class
    var table = $('#rating_review_class_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [2, 'desc']
        ],
        responsive: {
            details: {
                renderer: function(api, rowIdx, columns) {
                    var $details = $.fn.DataTable.Responsive.defaults.details.renderer(api,
                        rowIdx, columns);
                    initRating($details);

                    return $details;
                }
            }
        },
        drawCallback: function(settings) {
            var api = this.api();
            initRating(api.table().container());
        }
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // Bookmark recipe table
    var table = $('#bookmark_recipe_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [1, 'desc']
        ],
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // Download recipe table
    var table = $('#download_recipe_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [1, 'desc']
        ],
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // Viewers recipe table
    var table = $('#viewers_recipe_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [1, 'desc']
        ],
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    // Rating recipe class
    var table = $('#rating_review_recipe_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [2, 'desc']
        ],
        responsive: {
            details: {
                renderer: function(api, rowIdx, columns) {
                    var $details = $.fn.DataTable.Responsive.defaults.details.renderer(api,
                        rowIdx, columns);
                    initRating($details);

                    return $details;
                }
            }
        },
        drawCallback: function(settings) {
            var api = this.api();
            initRating(api.table().container());
        }
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    // Coach subscription table
    var table = $('#coach_subscription_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [3, 'asc']
        ],
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // Coach class subscription table
    var table = $('#coach_class_subscription_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [2, 'asc']
        ],
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

});