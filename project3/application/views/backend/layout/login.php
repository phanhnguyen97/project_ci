<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="(isset($description))?htmlspecialchars($description):''" />
    <meta name="keywords" content="(isset($keywords))?htmlspecialchars($keywords):''" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?php echo base_url(); ?>">
    <link rel="stylesheet" href="public/template/backend/css/normalize.css" type="text/css">
    <link rel="stylesheet" href="public/template/backend/css/login.css" type="text/css">
    <title><?= (isset($title))?htmlspecialchars($title):'';?></title>
</head>
<body>
<header></header>
<?php $this->load->view($template,isset($data)?$data:NULL)?>
<footer><p>Copyright &#169; <?php echo gmdate('Y', time() + 7*3600);?> - Powered by <a href="https://kenh14.vn/" target="_blank" title="Thiết kế web">ITQ</a></p></footer>
</body>
</html>
