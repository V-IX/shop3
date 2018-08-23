<?=link_tag('assets/plugins/elfinder/css/jquery-ui.css');?>
<?=link_tag('assets/plugins/elfinder/css/theme.css');?>
<?=link_tag('assets/plugins/elfinder/css/elfinder.min.css');?>
<?=link_tag('assets/plugins/elfinder/css/icons.css');?>

<?=script('assets/plugins/jquery/jquery-1.6.2.min.js');?>
<?=script('assets/plugins/jquery/jquery-ui-1.8.14.min.js');?>

<?=script('assets/plugins/elfinder/js/elfinder.full.js');?>
<?=script('assets/plugins/elfinder/js/i18n/elfinder.ru.js');?>

<script type="text/javascript" charset="utf-8">
    $().ready(function() {
        var elf = $('#elfinder').elfinder({
			
			validName  : /^[a-zA-Z0-9_\%\-]$/,
			//onlyMimes  : ["image"],// ? оставлять
			lang       : 'ru',
			url        : '<?=base_url('/admin/files/elfinder_init');?>',
			customData : {
				csrf_test_name: "<?=$this->security->get_csrf_hash(); ?>"
			},
			
        }).elfinder('instance');            
    });
</script>

<div id="elfinder"></div>