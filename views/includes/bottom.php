<div class="site-bottom">
    <div class="container">
        <?php echo (new Page)->getContent(PAGE_BOTTOM); ?>
        <hr/>
        <?php include(BASE_PATH."/views/includes/social.php"); ?>
    </div>
</div>
<p class="copy-right text-center">
    <?php echo COMPANY_NAME."."; ?> Todos los derechos reservados <?php echo date("Y"); ?>
</p>