<?php
/*$lat = 18.5407074;
$lng = -72.319546;
$json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng);

$obj = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng)->results[0]->formatted_address;
$obj = json_decode($json);
echo $json;
if ($obj->status == 'OK')
    echo $obj->results[0]->formatted_address;
else
    echo "Il y a quelque chose qui ne va pas.";*/

/*echo $this->Form->create('Users');
echo $this->Form->input('name', array('id'=>'name'));
echo $this->Form->input('age', array('id'=>'age'));
echo $this->Form->button('Add Info', array(
    'type'=>'button',
    'onclick'=>'infoAdd();'
));
$this->Form->end();*/
?>

<?php echo $result; ?>
<?php echo $this->Form->input('your_field', array('id' => 'resultField')); ?>
<script>
    jQuery("#performAjaxLink").click(
        function()
        {
            jQuery.ajax({
                type:'POST',
                async: true,
                cache: false,
                url: '<?= \Cake\Routing\Router::Url(['controller' => 'users', 'action' => 'test'], TRUE); ?>',
                success: function(response) {
                    jQuery('#resultField').val(response);
                },
                data:jQuery('form').serialize()
            });
            return false;
        }
    );
</script>