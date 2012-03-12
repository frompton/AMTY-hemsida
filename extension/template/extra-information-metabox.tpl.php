<?php
/**
 * AMTY Extra information meta box
 * Print metabox for extra information about sizes
 */
?>
        <p><label for="<?php echo $this->domain . '_purchase_price';?>">Inköpspris</label></p>
        <input type="text" id="<?php echo $this->domain . '_purchase_price';?>" name="<?php echo $this->domain . '_purchase_price';?>" value="<?php echo $purchase_price ?>">

		<p><?php echo __( 'Fyll i extra information om storlekar. Obs, denna information visas endast om produkten har storlekar', 'amty' );?></p>
		<textarea style="width: 100%; height: 150px;" id="<?php echo $this->domain . '_extra_information';?>" name="<?php echo $this->domain . '_extra_information';?>"><?php echo $extra_information ?></textarea>

        <p><?php echo __( 'Övrig info för internt bruk, visas ej för kund', 'amty' );?></p>
        <textarea style="width: 100%; height: 150px;" id="<?php echo $this->domain . '_internal_information';?>" name="<?php echo $this->domain . '_internal_information';?>"><?php echo $internal_information ?></textarea>
