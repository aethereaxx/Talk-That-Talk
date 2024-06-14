$(document).ready(function () {
    // Toggle display of management sections
    $('#dashboard-link').click(function () {
        $('#dashboard-content').show();
        $('#account-management-content').hide();
        $('#posts-management-content').hide();
    });

    $('#account-management-link').click(function () {
        $('#dashboard-content').hide();
        $('#account-management-content').show();
        $('#posts-management-content').hide();
    });

    $('#posts-management-link').click(function () {
        $('#dashboard-content').hide();
        $('#account-management-content').hide();
        $('#posts-management-content').show();
    });

    // Handle update button click for users
    $('.update-button').click(function () {
        var row = $(this).closest('tr');
        var username = row.data('username');
        var nama = row.find('td:eq(0)').text();
        var email = row.find('td:eq(1)').text();
        var password = row.find('td:eq(3)').text();
        var tanggal_lahir = row.find('td:eq(4)').text();

        $('#update-form').show();
        $('#delete-form').hide();
        $('#update-username').val(username);
        $('#update-old-username').val(username); // hidden field for old username
        $('#update-nama').val(nama);
        $('#update-email').val(email);
        $('#update-password').val(password);
        $('#update-tanggal_lahir').val(tanggal_lahir);
    });

    // Handle delete button click for users with confirmation
    $('.delete-button').click(function () {
        var username = $(this).closest('tr').data('username');
        if (confirm('Are you sure you want to delete this account?')) {
            $('#delete-username').val(username);
            $('#delete-form').submit();
        }
    });

    // Handle update button click for posts
    $('.update-post-button').click(function () {
        var row = $(this).closest('tr');
        var postID = row.data('post-id');
        var title = row.find('td:eq(1)').text();
        var content = row.find('td:eq(2)').text();

        $('#update-post-form').show();
        $('#delete-post-form').hide();
        $('#update-post-id').val(postID);
        $('#update-title').val(title);
        $('#update-content').val(content);
    });

    // Handle delete button click for posts with confirmation
    $('.delete-post-button').click(function () {
        var postID = $(this).closest('tr').data('post-id');
        if (confirm('Are you sure you want to delete this post?')) {
            $('#delete-post-id').val(postID);
            $('#delete-post-form').submit();
        }
    });
});
