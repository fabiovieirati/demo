<?php

use Illuminate\Support\Facades\Storage;
use Nette\Utils\Json;

$prices = Json::decode(Storage::disk('local')->get('prices.json'));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @foreach ($prices as $price)
        <li> {{ $price->codigo }} </li>
        <li> {{ $price->minimo_vidas }} </li>
        <li> {{ $price->faixa1 }} </li>
        <li> {{ $price->faixa2 }} </li>
        <li> {{ $price->faixa3 }} </li>
    @endforeach
</body>
</html>