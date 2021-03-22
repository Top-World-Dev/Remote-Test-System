var userDataTable,
    problemDataTable,
    productDataTable, 
    subjectDataTable,
    subjecttypeDataTable,
    moduleDataTable,
    producttypeDataTable,
    priceDataTable,
    durationDataTable,
    generateDataTable,
    connectDataTable;
    // prDataTable;

$(document).ready(function() {
    var userTable = $('#user_table'),
        problemTable = $('#problem_table'),
        productTable = $('#product_table'),
        subjectTable = $('#subject_table'),
        subjecttypeTable = $('#subject_type_table'),
        moduleTable = $('#module_table'),
        producttypeTable = $('#product_type_table'),
        priceTable = $('#price_table'),
        durationTable = $('#duration_table'),
        generateTable = $('#generate_table'),
        connectTable = $('#connect_table');

    if(userTable.length > 0) {
        userDataTable = userTable.DataTable({

        });
    }

    if(problemTable.length > 0) {
        problemDataTable = problemTable.DataTable({

        });
    }

    if(productTable.length > 0) {
        productDataTable = productTable.DataTable({

        });
    }

    if(subjectTable.length > 0) {
        subjectDataTable = subjectTable.DataTable({

        });
    }

    if(subjecttypeTable.length > 0) {
        subjecttypeDataTable = subjecttypeTable.DataTable({

        });
    }

    if(moduleTable.length > 0) {
        moduleDataTable = moduleTable.DataTable({

        });
    }

    if(producttypeTable.length > 0) {
        producttypeDataTable = producttypeTable.DataTable({

        });
    }

    if(priceTable.length > 0) {
        priceDataTable = priceTable.DataTable({

        });
    }

    if(durationTable.length > 0) {
        durationDataTable = durationTable.DataTable({

        });
    }

    if(generateTable.length > 0) {
        generateDataTable = generateTable.DataTable({

        });
    }

    if(connectTable.length > 0) {
        connectDataTable = connectTable.DataTable({

        });
    }
});