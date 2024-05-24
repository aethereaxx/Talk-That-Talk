<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mute and Block</title>
    <link rel="stylesheet" href="../Style/menu.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav>
        <div>
            <a href="timeline.php"><i class="fa-solid fa-arrow-left"></i></a>
            <h1>Mute and Block</h1>
        </div>
    </nav>
    <section>
        <div class="container">
            <div class="buttons">
                <button <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'muted') ? 'class="active"' : ''; ?> onclick="window.location.href='mute.php?tab=muted'">Muted</button>
                <button <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'blocked') ? 'class="active"' : ''; ?> onclick="window.location.href='mute.php?tab=blocked'">Blocked</button>
            </div>
            <main>
                <?php
                $tab = isset($_GET['tab']) ? $_GET['tab'] : '';

                if ($tab == 'muted') {
                    echo '<h2>Muted Accounts</h2>';
                    echo '<p>Posts from muted accounts won’t show up in your Home timeline. Mute accounts directly from their profile or post.</p>';
                } elseif ($tab == 'blocked') {
                    echo '<h2>Blocked Unwanted Accounts</h2>';
                    echo '<p>When you block someone, that person won’t be able to follow or message you.</p>';
                } else {
                    echo '<h3>Select to view Muted or Blocked accounts.</h3>';
                }
                ?>
            </main>
        </div>
    </section>
</body>
</html>
