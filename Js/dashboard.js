    $("#dashboard-link").click(function (e) {
        e.preventDefault();
        $("#dashboard-content").show();
        $("#account-management-content").hide();
        $("#posts-management-content").hide();
        $("#update-form").hide();
    });

    $("#account-management-link").click(function (e) {
        e.preventDefault();
        $("#dashboard-content").hide();
        $("#account-management-content").show();
        $("#posts-management-content").hide();
        $("#update-form").hide();
    });

    $("#posts-management-link").click(function (e) {
        e.preventDefault();
        $("#dashboard-content").hide();
        $("#account-management-content").hide();
        $("#posts-management-content").show();
        $("#update-form").hide();
    });

    $(".update-button").click(function () {
        var username = $(this).data('username');
        var row = $("tr[data-username='" + username + "']");
        $("#update-username").val(username);
        $("#update-nama").val(row.find("td:eq(0)").text());
        $("#update-email").val(row.find("td:eq(1)").text());
        $("#update-password").val(row.find("td:eq(3)").text());
        $("#update-tanggal_lahir").val(row.find("td:eq(4)").text());
        $("#update-form").show();
    });

    $(".delete-button").click(function () {
        var username = $(this).data('username');
        if (confirm('Are you sure you want to delete this account?')) {
            $("#delete-username").val(username);
            $("#delete-form").submit();
        }
    });

    $("#update-form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "dashboard.php",
            data: $(this).serialize(),
            success: function () {
                alert('Account updated successfully.');
                location.reload();
            }
        });
    });

    $("#delete-form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "dashboard.php",
            data: $(this).serialize(),
            success: function () {
                alert('Account deleted successfully.');
                location.reload();
            }
        });
    });
