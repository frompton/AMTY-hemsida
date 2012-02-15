<?php
/**
 * AMTY Extra information meta box
 * Print metabox for extra information about sizes
 *
 * @param $type_id int
 * @param $types array
 * @param $type[]->value int
 * @param $type[]->label string
 * @param $this->domain string
 */
?>
		<p><?php echo __( 'Fyll i extra information om storlekar. Obs, denna information visas endast om produkten har storlekar', 'amty' );?></p>
		<textarea style="width: 100%; height: 150px;" id="<?php echo $this->domain . '_extra_information';?>" name="<?php echo $this->domain . '_extra_information';?>"><?php echo $extra_information ?></textarea>
