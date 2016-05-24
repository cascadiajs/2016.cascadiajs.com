<?php

class Colors {
const primary_green = "#022d01";
const primary_blue = "#1c2d4a";
const primary_red = "#99001a";
const primary_purple = "#639";
const primary_orange = "#ed7e1d";
// const primary_yellow = "#edc61d";
const raw_green = "#04ff00";
const raw_blue = "#005eff";
// const raw_red = "#ff002b";
const raw_purple = "#8000ff";
const raw_orange = "#f70";
// const raw_yellow = "#ffd000";
const secondary_green = "#137630";
const secondary_blue = "#014da6";
const secondary_red = "#ff2a1c";
const secondary_purple = "#9c2172";
const secondary_orange = "#f35221";
// const secondary_yellow = "#f9930a";
const secondary_green_light = "#5a9f6e";
const secondary_blue_light = "#4d82c1";
// const secondary_red_light = "#ff6a60";
const secondary_purple_light = "#ba649c";
// const secondary_orange_light = "#f78664";
// const secondary_yellow_light = "#fbb354";
const secondary_green_dark = "#0b471d";
const secondary_blue_dark = "#012e64";
// const secondary_red_dark = "#991911";
// const secondary_purple_dark = "#5e1444";
// const secondary_orange_dark = "#923114";
// const secondary_yellow_dark = "#955806";
const neutral_green = "#31583c";
const neutral_blue = "#335175";
// const neutral_red = "#bb6660";
const neutral_purple = "#774666";
const neutral_orange = "#b47460";
// const neutral_yellow = "#b18952";
const neutral_green_light = "#6faf82";
const neutral_blue_light = "#6f95c1";
// const neutral_red_light = "#d6a3a0";
const neutral_purple_light = "#b886a7";
// const neutral_orange_light = "#d2aba0";
// const neutral_yellow_light = "#d0b897";
const neutral_green_dark = "#1d3524";
const neutral_blue_dark = "#1e3146";
// const neutral_red_dark = "#773733";
const neutral_purple_dark = "#472a3d";
// const neutral_orange_dark = "#714335";
// const neutral_yellow_dark = "#6b5230";
const mostly_white = "#e2efe6";
const mostly_black = "#171717";
}

$ref = new ReflectionClass('Colors');
$colors = $ref->getConstants();

$polygons = [

    18 => [
        "points" => hexPoints("900,600"),
        "colors" => getColors(3)
    ],


    15 => [
        "points" => hexPoints("640,450"),
        "colors" => getColors(3)
    ],
    16 => [
        "points" => hexPoints("1160,450"),
        "colors" => getColors(3)
    ],
    17 => [
        "points" => hexPoints("900,900"),
        "colors" => getColors(3)
    ],


    12 => [
        "points" => hexPoints("900,300"),
        "colors" => getColors(3)
    ],
    13 => [
        "points" => hexPointS("640,750"),
        "colors" => getColors(3)
    ],
    14 => [
        "points" => hexPoints("1160,750"),
        "colors" => getColors(3)
    ],

    6 => [
        "points" => hexPoints("1160,150"),
        "colors" => getColors(3)
    ],
    7 => [
        "points" => hexPoints("640,150"),
        "colors" => getColors(3)
    ],
    8 => [
        "points" => hexPoints("380,600"),
        "colors" => getColors(3)
    ],
    9 => [
        "points" => hexPoints("1420,600"),
        "colors" => getColors(3)
    ],
    10 => [
        "points" => hexPoints("640,1050"),
        "colors" => getColors(3)
    ],
    11 => [
        "points" => hexPoints("1160,1050"),
        "colors" => getColors(3)
    ],

    0 => [
        "points" => hexPoints("900,0"),
        "colors" => getColors(3)
    ],
    1 => [
        "points" => hexPoints("380,900"),
        "colors" => getColors(3)
    ],
    2 => [
        "points" => hexPoints("1420,900"),
        "colors" => getColors(3)
    ],
    3 => [
        "points" => hexPoints("1420,300"),
        "colors" => getColors(3)
    ],
    4 => [
        "points" => hexPoints("380,300"),
        "colors" => getColors(3)
    ],
    5 => [
        "points" => hexPoints("900,1200"),
        "colors" => getColors(3)
    ],



];

$polyTemplate = '<polygon id="poly-{index}" points="{points}" style="fill:{start};">{animate}</polygon>';
$animateTemplate = '<animate attributeName="fill" values="{colors}" repeatCount="indefinite" begin="{begin}s" dur="{dur}s" />';

$templateData = [
    'polygons' => []
];

foreach($polygons as $index => $item) {
    $item['start'] = $item['colors'][0];
    $item['index'] = $index;
    $item['animate'] = '';

    if(count($item['colors']) > 1) {
        $item['colors'][] = $item['colors'][0];
        $item['colors'] = implode('; ', $item['colors']);
        $item['begin'] = rand(0,2);
        $item['dur'] = rand(3,6);
        $item['animate'] = interpolate($animateTemplate, $item);
    }

    $templateData['polygons'][] = interpolate($polyTemplate, $item);
}

$templateData['polygons'] = implode("\n", $templateData['polygons']);

$svg = file_get_contents('template.svg');
$svg = interpolate($svg, $templateData);
file_put_contents('test.svg', $svg);

/**
* Interpolates context values into the message placeholders.
*/
function interpolate($message, array $context = array())
{
    // build a replacement array with braces around the context keys
    $replace = array();
    foreach ($context as $key => $val) {
        $replace['{' . $key . '}'] = $val;
    }

    // interpolate replacement values into the message and return
    return strtr($message, $replace);
}

function hexPoints($start) {
  // "900,0 1160,150 1160,450 900,600 640,450 640,150"
  $points = [$start];
  list($x, $y) = explode(',', $start);

  $points[] = ($x+260) . ',' . ($y+150);
  $points[] = ($x+260) . ',' . ($y+450);
  $points[] = ($x) . ',' . ($y+600);
  $points[] = ($x-260) . ',' . ($y+450);
  $points[] = ($x-260) . ',' . ($y+150);

  return implode(' ', $points);
}

function getColors($num = 1) {
  $found = [];

  $ref = new ReflectionClass('Colors');
  $colors = $ref->getConstants();

  for($i=0;$i<$num;$i++) {
    $found[] = $colors[array_rand($colors)];
  }
  return $found;
}