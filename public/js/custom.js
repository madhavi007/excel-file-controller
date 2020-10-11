$(document).ready(function () {

    $(".upload-file").on('change', function (e) {
        e.preventDefault();
        var file = e.target.files[0];

        if (file.size >= 1024 * 1024) {
            alert("File should be maximum 1MB");
            $(".upload-form").get(0).reset();
            return;
        }

        if (!file.type.match('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) {
            alert("only xlsx or xls files");
            $(".upload-form").get(0).reset();
            return;
        }
    });

    $(document).on("click", ".fetch_data", function (e) {
        e.preventDefault();
        fetch_data();
    });
    $(document).on("click", ".search", function (e) {
        e.preventDefault();
        var select_value = $(".search_value").val();
        var select_key = $(".search_key").val();
        search_data(select_value, select_key);
    });
    $(document).on("click", ".reset_all", function (e) {
        e.preventDefault();
        fetch_data();
        $(".search_value").val('');
        $(".search_key").val('');
    });


    $(document).on("click", ".sort", function (e) {
        e.preventDefault();
        var header_name = $(this).attr("data_value");
        var select_value = $(".search_value").val();
        var select_key = $(".search_key").val();
        var header_order = $(this).attr("data_order");
        $.ajax({
            url: "/search",
            type: 'GET',
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                header_name: header_name,
                select_value: select_value,
                select_key: select_key,
                header_order: header_order
            },
            success: function (data) {

                var file_data = "";
                var swap_header_order = header_order == 'desc' ? header_order = 'asc' : header_order = 'desc';
                $.each(JSON.parse(data), function (i, e) {
                    file_data += '<tr>';
                    $.each(e, function (i2, e2) {

                        if (i == 0) {
                            if (e2 == header_name) {
                                file_data += '<td>' + e2 + '<img src="/images/sort.png" height="20" width="20"  class="sort" data_value=' + e2 + ' data_order=' + swap_header_order + '></td>';
                            } else {
                                file_data += '<td>' + e2 + '<img src="/images/sort.png" height="20" width="20"  class="sort" data_value=' + e2 + ' data_order="desc"></td>';
                            }

                        }
                        if (e2 != null && i != 0) {
                            file_data += '<td>' + e2 + '</td>';
                        }
                    });

                    file_data += '</tr>';
                });
                $('.table_list').html(file_data);
            }
        });
    });
});

function fetch_data() {
    $.ajax({
        url: "/fetch",
        type: 'GET',
        dataType: "json",
        data: {
            "_token": "{{ csrf_token() }}",
        },
        success: function (data) {
            var file_data = "";
            $(".search_div").css('display', 'block');
            $.each(JSON.parse(data), function (i, e) {

                file_data += '<tr>';
                $.each(e, function (i2, e2) {
                    if (i == 1) {
                        file_data += '<td>' + e2 + '<img src="/images/sort.png" height="20" width="20"  class="sort" data_value=' + e2 + ' data_order="desc"></td>';
                    }
                    if (e2 != null && i != 1) {
                        file_data += '<td>' + e2 + '</td>';
                    }

                });

                file_data += '</tr>';
            });
            $('.table_list').html(file_data);
        }
    });
}

function search_data(select_value, select_key) {
    $.ajax({
        url: "/search",
        type: 'GET',
        dataType: "json",
        data: {
            "_token": "{{ csrf_token() }}",
            select_value: select_value,
            select_key: select_key
        },
        success: function (data) {

            var file_data = "";

            $.each(JSON.parse(data), function (i, e) {
                file_data += '<tr>';
                $.each(e, function (i2, e2) {
                    if (i == 0) {
                        file_data += '<td>' + e2 + '<img src="/images/sort.png" height="20" width="20"  class="sort" data_value=' + e2 + '></td>';
                    }
                    if (e2 != null && i != 0) {
                        file_data += '<td>' + e2 + '</td>';
                    }
                });

                file_data += '</tr>';
            });
            $('.table_list').html(file_data);
        }
    });
}

