<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
    <script src="selector.js" defer></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <!--<link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">-->
    <link href="style.css" rel="stylesheet">
    <title>Тарифы</title>
</head>
<body>
<form name="plan_selector">
<section class="plans" id="vueContainer">
    <header v-if="currentStep">
        <button type="button" v-on:click="goBack"></button>
        <h1 v-if="currentStep==1">{{currentHeaderText}}</h1>
        <h1 v-if="currentStep==2">Выбор тарифа</h1>
    </header>
    <main>
    <?php
$json_url    = 'http://sknt.ru/job/frontend/data.json';
$json_string = file_get_contents($json_url); //должен быть включен openssl в настройках php. для windows также нужно раскомментировать extension_dir
if ($json_string)
{
    $json_object = json_decode($json_string);
    if ($json_object)
    {
        if (isset($json_object->result) && !strcmp($json_object->result, "ok"))
        {
            if (isset($json_object->tarifs) && count($json_object->tarifs) > 0)
            {
                include('./render_plans.php');
                render_plans($json_object->tarifs);
            }
            else
            {
                echo 'Тарифных планов нет';
            }
        }
        else
        {
            echo 'JSON result != "ok"';
        }
    }
    else
    {
        echo 'Произошла ошибка при обработке данных (' . json_last_error_msg() . ')';
    }
}
else
{
    echo 'Произошла ошибка при получении данных о тарифах';
}
?>
   </main>
    <div class="button_wrapper" v-if="currentStep==2">
        <input hidden name="chosenPlan" value="">
        <button type="button" v-on:click="choosePlan">Выбрать</button>
    </div>
</section>
</form>
</body>
</html>