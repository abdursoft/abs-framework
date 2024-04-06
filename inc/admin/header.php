<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $meta; ?> <!-- Loading meta data here -->
    <link rel="shortcut icon" href="<?= $favicon ?>" type="image/x-icon"> <!-- Loading Favicon -->
    <link rel="canonical" href="<?= BASE_URL ?>" /> <!-- Site base url -->
    <title><?= $page_title ?? 'ABS framework' ?></title> <!-- Loading page title -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/abs_theme.css"> <!-- Loading theme Css -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <?= $style ?>  <!-- Loading imported style here -->
    <?= $flash ?>  <!-- Loading flash message script here -->
    <?= $script ?> <!-- Loading imported script here -->
</head>
<body>
<h3>Admin Header</h3>