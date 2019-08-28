<?php
function render_plans($plans) {
	foreach ($plans as $key => $plan):
		$price_string = '400 - 500 &#x20bd;/мес'?>
		<input type="radio" name="plan_step0" id="plan_<?=$key?>">
		<label for="plan_<?=$key?>" class="step0">
			<h1>Тариф "<?=$plan->title;?>"</h1>
			<div>
				<span class="speed" forcolor="<?=$plan->title;?>"><?=$plan->speed;?> Мбит/с</span>
				<span class="price"><?=$price_string;?></span>
				<?php if (isset($plan->free_options)) {
					echo '<span class="free_options">'.implode('<br>', $plan->free_options).'</span>';
				}?>
			</div>
			<a href="<?=$plan->link;?>">узнать подробнее на сайте www.sknt.ru</a>
		</label>
	<?php endforeach;
}
?>