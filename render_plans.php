<?php
function sort_plans_by_period($a, $b) { //сортирует варианты периодов оплаты по количеству месяцев. 
	return ($a->pay_period < $b->pay_period) ? -1 : 1;
}
function right_month_ending($period) { //возвращает правильное окончание к слову месяц
	if($period >= 11 and $period <= 19)
		return 'ев';
	$period = $period % 10;
	if($period == 1)
		return '';
	if($period >= 2 and $period <= 4)
		return 'а';
	return 'ев';
}
function render_plans($plans) {	//создаёт размеку для тарифов
	foreach ($plans as $plan_group_key => $plan_group):
		$lowest_price = 0;
		$highest_price = 0;
		usort($plan_group->tarifs, 'sort_plans_by_period');
		$highest_price = $plan_group->tarifs[0]->price;
		$longest_plan = end($plan_group->tarifs);
		reset($plan_group->tarifs);	//вернёт указатель в начало массива
		$lowest_price = $longest_plan->price / $longest_plan->pay_period;
		
		$price_string = "{$lowest_price} &#8211; {$highest_price} &#x20bd;/мес";?>
		<template v-if="currentStep==0">
			<input type="radio" 
					name="plan_group_radio" 
					id="plangroup_<?=$plan_group_key?>" 
					forheader="<?=$plan_group->title;?>" 
					value="<?=$plan_group_key?>" 
					v-on:click="openGroup">
			<label for="plangroup_<?=$plan_group_key?>" class="step0">
				<h1>Тариф "<?=$plan_group->title;?>"</h1>
				<div>
					<span class="speed" forcolor="<?=$plan_group->title;?>"><?=$plan_group->speed;?> Мбит/с</span>
					<span class="price"><?=$price_string;?></span>
					<?php if (isset($plan_group->free_options)) {
						echo '<span class="free_options">'.implode('<br>', $plan_group->free_options).'</span>';
					}?>
				</div>
				<a href="<?=$plan_group->link;?>">узнать подробнее на сайте www.sknt.ru</a>
			</label>
		</template>
		<template v-if="currentStep && currentGroup==<?=$plan_group_key?>">
		<?php
		foreach ($plan_group->tarifs as $plan_ind => $plan) :
			$month_price = $plan->price / $plan->pay_period;
			
			$timestamp = substr($plan->new_payday, 0, -5);
			$timezone_offset = substr($plan->new_payday,-5);
			$date = date_create("@{$timestamp}"); //не получится передать TZ сразу, если используется timestamp
			date_timezone_set($date, timezone_open($timezone_offset));
			//var_dump($date);
			$date_string = date_format($date, 'd.m.Y');?>
			<template v-if="currentStep==1">
				<input type="radio" name="plan_radio" id="plan_<?=$plan_ind;?>" value="<?=$plan->ID;?>" v-on:click="openPlan">
				<label for="plan_<?=$plan_ind;?>" class="step1">
					<h1><?=$plan->pay_period.' месяц'.right_month_ending($plan->pay_period);?></h1>
					<div>
						<span class="price"><?=$month_price;?> &#x20bd;/мес</span>
						<span class="total_price">разовый платёж &#8211; <?=$plan->price;?> &#x20bd;</span>
						<?php if ($highest_price > $month_price) :?>
							<span class="discount">скидка &#8211; <?=(($highest_price * $plan->pay_period) - $plan->price);?> &#x20bd;</span>
						<?php endif;?>
					</div>
				</label>
			</template>
			<label class="step2" v-if="currentStep==2 && currentPlan==<?=$plan->ID;?>">
				<h1>Тариф "<?=$plan_group->title;?>"</h1>
				<div>
					<span class="price">Период оплаты &#8211; <?=$plan->pay_period.' месяц'.right_month_ending($plan->pay_period).'<br>'.$month_price;?> &#x20bd;/мес</span>
					<span class="total_price">разовый платёж &#8211; <?=$plan->price;?> &#x20bd;
						<br>со счёта спишется &#8211; <?=$plan->price;?> &#x20bd;</span>
					<span class="dates">вступит в силу &#8211; сегодня
						<br>активно до &#8211; <?=$date_string?></span>
				</div>
			</label>
		<?php endforeach;?>
		</template>
	<?php endforeach;
}
?>