<!DOCTYPE html>
<html lang="<?= $language?>">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title?> » Admin CMS</title>
    <link href="<?= my_library::admin_css()?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= my_library::admin_css()?>font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?= my_library::admin_css()?>nprogress.css" rel="stylesheet">
    <link href="<?= my_library::admin_css()?>custom.min.css" rel="stylesheet">
    <link href="<?= my_library::admin_css()?>pnotify.css" rel="stylesheet">
    <link href="<?= my_library::admin_css()?>sweetalert.css" rel="stylesheet">
    <script type="text/javascript">
        var configs = {
        base_url: '<?= my_library::base_url()?>',
        admin_site: '<?= my_library::admin_site()?>',
        controller: '<?= $controller?>',
        lang: '<?= $language?>'
        }
    </script>
    <?php if (!empty($extraCss)): ?>
        <?php foreach ($extraCss as $key => $value): ?>
            <link href="<?= my_library::admin_css().$value?>" rel="stylesheet">
        <?php endforeach ?>
    <?php endif ?>
  </head>